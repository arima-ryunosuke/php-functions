<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 一意な文字列を返す
 *
 * 最大でも8バイト（64ビット）に収まるようにしてある。
 *
 * - 41bit: 1ミリ秒単位
 * - 7bit: シーケンス
 * - 16bit: IPv4ホストアドレス
 *
 * いわゆる snowflake 系で sonyflake が近い。
 *
 * シーケンスは「単位時間（1ミリ秒）あたりに発行できる数」を表す。
 * 7bit で少し少ないが、生成にファイルロックを使用しているため、1ミリ秒で 128 回生成されることがそもそもレアケース。
 * 7bit を超えると強制的に1ミリ秒待って timestamp を変えることで重複を防ぐ（≒その時は発行に1ミリ秒かかる）。
 *
 * 複数の IPv4 アドレスを持つ場合はサブネットが最も長いもの（ホストアドレスが最も短いもの）が使用される。
 * IPv6 は未対応で、サブネット /16 未満も未対応。
 *
 * 引数はデバッグ用でいくつか用意しているが、実運用としては引数ゼロとして扱うこと。
 *
 * 以下、思考過程と備考。
 *
 * - 単調増加の値としてタイムスタンプを採用
 *     - 如何にホスト・シーケンスが同じになろうと発行時刻が別なら別IDにするためのプレフィックスとして使用する
 *     - 時間が巻き戻らない限りは大丈夫
 *     - 2093年までしか発行できない（`(2 ** 41) * (10 ** -3) / 60 / 60 / 24 / 365` = 69.73 年）
 * - サーバー間で重複を許したくない場合の候補は下記で、現在は IPv4 を採用している
 *     - ホスト名
 *         - 文字列で大きさが読めないし一意である保証もない
 *     - MAC アドレス
 *         - 一意だが少し大きすぎる
 *         - 下3桁がシリアルIDらしいので同メーカーなら重複しないかもしれない
 *         - ただそもそも php で MAC アドレスを簡単に得る手段がない
 *     - IPv4
 *         - サーバー間で重複を許さないような id の生成は大抵クラスタを組んでいて IP が振られているはず
 *         - そして 4byte でユニークな IP が振られることはまずない（大抵は 2,3byte で固有のはず。/12未満のクラスタ構成なんて見たことない）
 *     - IPv6
 *         - 桁が大きすぎる
 *         - まだまだ IPv4 も現役なので積極的に採用する理由に乏しい
 *     - 引数で machine id を渡す
 *         - 大抵のシステムでホスト数は1,2桁だろうので小bitで済む
 *         - でも引数無しにしたかった
 * - プロセス間の重複（シーケンス）はファイルロックを使用して採番している
 *     - プロセスIDを採用してたが思ったより大きすぎた（現代的な linux ではデフォルト 2**22 らしい）
 *     - 逐次ロックなので大量生成には全く向かない
 *
 * @package ryunosuke\Functions\Package\misc
 *
 * @param array $id_info 元になった生成データのレシーバ引数
 * @param array $debug デバッグ用引数（配列で内部の動的な値を指定できる）
 * @return string 一意なバイナリ文字列
 */
function unique_id(&$id_info = [], $debug = [])
{
    $id_info = [];

    assert(PHP_INT_SIZE === 8);
    static $TIMESTAMP_BASE = 1704034800; // 2024-01-01 00:00:00
    static $TIMESTAMP_PRECISION = 1;
    static $TIMESTAMP_BIT = 41;
    static $SEQUENCE_BIT = 7;
    static $IPADDRESS_BIT = 16;
    assert(($TIMESTAMP_BIT + $SEQUENCE_BIT + $IPADDRESS_BIT) === 64);

    static $ipaddress = null;
    $ipaddress ??= (function () {
        $addrs = [];
        foreach (net_get_interfaces() as $interface) {
            foreach ($interface['unicast'] as $addr) {
                // IPv4 で・・・
                if ($addr['family'] === AF_INET) {
                    // subnet/16 以上のもの
                    $subnet = strrpos(decbin((ip2long($addr['netmask']))), '1') + 1;
                    if ($subnet >= 16) {
                        $addrs[] = [$addr['address'], $subnet];
                    }
                }
                // @todo subnet が /104 なら IPv6 でもいける？
            }
        }
        if ($addrs) {
            usort($addrs, fn($a, $b) => -($a[1] <=> $b[1]));
            return reset($addrs)[0];
        }
        throw new \UnexpectedValueException("ip address is not found"); // @codeCoverageIgnore
    })();
    $ipaddress = $debug['ipaddress'] ?? $ipaddress;

    // プロセスを跨いだ連番生成器（何かに使えそうなのでクラスにまとめて少し冗長になっている）
    static $sequencer = null;
    $sequencer ??= new class (sys_get_temp_dir() . "/id-sequence") {
        private     $handle;
        private int $lockcount = 0;

        public function __construct(string $lockfile)
        {
            $this->handle = fopen($lockfile, 'c+');
        }

        public function lock(): int
        {
            if (flock($this->handle, LOCK_EX)) {
                $this->lockcount++;
            }
            return $this->lockcount;
        }

        public function unlock(): int
        {
            if (flock($this->handle, LOCK_UN)) {
                $this->lockcount--;
            }
            return $this->lockcount;
        }

        public function reset(int $sequence): void
        {
            assert($this->lockcount > 0, 'must be lock');

            set_error_handler(function ($severity, $message, $file, $line) { throw new \ErrorException($message, 0, $severity, $file, $line); });
            try {
                rewind($this->handle);
                ftruncate($this->handle, 0);
                fwrite($this->handle, $sequence);
            }
            finally {
                restore_error_handler();
            }
        }

        public function add(int $increment = 1): int
        {
            assert($this->lockcount > 0, 'must be lock');

            set_error_handler(function ($severity, $message, $file, $line) { throw new \ErrorException($message, 0, $severity, $file, $line); });
            try {
                rewind($this->handle);
                $sequence = (int) stream_get_contents($this->handle);

                $next = $sequence + $increment;
                $this->reset(is_float($next) ? 0 : $next);

                return $sequence;
            }
            finally {
                restore_error_handler();
            }
        }
    };

    $sequencer->lock();
    try {
        $timestamp = $debug['timestamp'] ?? microtime(true);
        if (isset($debug['sequence'])) {
            $sequencer->reset($debug['sequence']);
        }

        $sequence = $sequencer->add() % (1 << $SEQUENCE_BIT);
        if ($sequence === 0) {
            usleep(1000 * $TIMESTAMP_PRECISION);
            $timestamp = microtime(true);
        }
    }
    finally {
        $sequencer->unlock();
    }

    $id_info = [
        'timestamp' => (int) (($timestamp - $TIMESTAMP_BASE) * 1000 / $TIMESTAMP_PRECISION),
        'sequence'  => $sequence,
        'ipsegment' => ip2long($ipaddress) & ((1 << $IPADDRESS_BIT) - 1),
    ];

    assert(($id_info['timestamp'] & ((1 << $TIMESTAMP_BIT) - 1)) === $id_info['timestamp']);
    assert(($id_info['sequence'] & ((1 << $SEQUENCE_BIT) - 1)) === $id_info['sequence']);
    assert(($id_info['ipsegment'] & ((1 << $IPADDRESS_BIT) - 1)) === $id_info['ipsegment']);

    $ipaddress_right_bits = 0;
    $sequence_right_bits = $ipaddress_right_bits + $IPADDRESS_BIT;
    $timestamp_right_bits = $sequence_right_bits + $SEQUENCE_BIT;

    return pack('J', ($id_info['timestamp'] << $timestamp_right_bits) | ($id_info['sequence'] << $sequence_right_bits) | ($id_info['ipsegment'] << $ipaddress_right_bits));
}
