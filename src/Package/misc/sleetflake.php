<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../url/base62_encode.php';
require_once __DIR__ . '/../url/base64url_encode.php';
require_once __DIR__ . '/../utility/function_configure.php';
// @codeCoverageIgnoreEnd

/**
 * 一意な id を生成するオブジェクトを返す
 *
 * 最大でも8バイト（64ビット）に収まるようにしてある。
 *
 * - 41bit: 1ミリ秒単位（固定）
 * - 7bit: シーケンス（引数指定可能）
 * - 16bit: IPv4ホストアドレス（引数指定可能）
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
 * @return \Sleetflake|object
 */
function sleetflake(
    int $sequence_bit = 7,
    int $ipaddress_bit = 16,
    ?int $base_timestamp = null,
    ?float $timestamp = null,
    ?string $lockfile = null,
) {
    return new class($sequence_bit, $ipaddress_bit, $base_timestamp, $timestamp, $lockfile) {
        private int    $sequence_bit;
        private int    $ipaddress_bit;
        private int    $machine_id;
        private int    $base_timestamp;
        private ?float $timestamp;
        private        $lock_handle;

        private array $debugInfo;

        public function __construct(
            int $sequence_bit,
            int $ipaddress_bit,
            ?int $base_timestamp,
            ?float $timestamp,
            ?string $lockfile,
        ) {
            $this->sequence_bit = $sequence_bit;
            $this->ipaddress_bit = $ipaddress_bit;
            $this->base_timestamp = $base_timestamp ?? strtotime('2025/06/01');
            $this->timestamp = $timestamp;
            $this->lock_handle = fopen($lockfile ?? (function_configure('cachedir') . "/sleetflake-sequence"), 'c+');

            assert(($this->sequence_bit + $this->ipaddress_bit) <= 23);
        }

        public function __destruct()
        {
            fclose($this->lock_handle);
        }

        public function __debugInfo(): array
        {
            return $this->debugInfo;
        }

        public function binaryToInt(string $binary): int
        {
            return unpack('J', $binary)[1];
        }

        public function int(): int
        {
            $this->machine_id ??= $this->getMachineId();

            // この順番は決して変えてはならない（getSequence で待機する可能性があるので microtime はその後でなければならない）
            $machineid = $this->machine_id & ((1 << $this->ipaddress_bit) - 1);
            $sequence = $this->getSequence();
            $timestamp = (int) ((($this->timestamp ?? microtime(true)) - $this->base_timestamp) * 1000);

            $ipaddress_right_bits = 0;
            $sequence_right_bits = $ipaddress_right_bits + $this->ipaddress_bit;
            $timestamp_right_bits = $sequence_right_bits + $this->sequence_bit;

            $id = ($timestamp << $timestamp_right_bits) | ($sequence << $sequence_right_bits) | ($machineid << $ipaddress_right_bits);

            $this->debugInfo = [
                'id'        => $id,
                'timestamp' => $timestamp,
                'sequence'  => $sequence,
                'machineid' => $machineid,
            ];

            return $id;
        }

        public function binary(): string
        {
            return pack('J', $this->int());
        }

        public function base62(): string
        {
            return base62_encode($this->binary());
        }

        public function base64(): string
        {
            return base64_encode($this->binary());
        }

        public function base64url(): string
        {
            return base64url_encode($this->binary());
        }

        private function getMachineId(): int
        {
            $addrs = [];
            foreach (net_get_interfaces() as $interface) {
                foreach ($interface['unicast'] as $addr) {
                    // IPv4 で・・・
                    if ($addr['family'] === AF_INET) {
                        // subnet/16 以上のもの
                        $subnet = strrpos(decbin((ip2long($addr['netmask']))), '1') + 1;
                        if ($subnet >= $this->ipaddress_bit) {
                            $addrs[] = [$addr['address'], $subnet];
                        }
                    }
                    // @todo subnet が /104 なら IPv6 でもいける？
                }
            }
            if ($addrs) {
                usort($addrs, fn($a, $b) => -($a[1] <=> $b[1]));
                return ip2long(reset($addrs)[0]);
            }
            throw new \UnexpectedValueException("ip address is not found"); // @codeCoverageIgnore
        }

        private function getSequence(): int
        {
            set_error_handler(function ($severity, $message, $file, $line) { throw new \ErrorException($message, 0, $severity, $file, $line); });
            flock($this->lock_handle, LOCK_EX);

            try {
                rewind($this->lock_handle);
                $sequence = 1 + (int) stream_get_contents($this->lock_handle);
                if (($sequence >= (1 << $this->sequence_bit))) {
                    $sequence = 0;
                    usleep(1000);
                    if (isset($this->timestamp)) {
                        $this->timestamp += 0.001;
                    }
                }

                rewind($this->lock_handle);
                ftruncate($this->lock_handle, 0);
                fwrite($this->lock_handle, $sequence);

                return $sequence;
            }
            finally {
                restore_error_handler();
                flock($this->lock_handle, LOCK_UN);
            }
        }
    };
}
