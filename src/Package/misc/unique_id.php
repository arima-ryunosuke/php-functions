<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 一意な文字列を返す
 *
 * 最大でも12バイト（96ビット）に収まるようにしてある。
 *
 * - 41bit: ミリ秒
 * - 24bit: IPv4アドレス下3桁
 * - 22bit: プロセスID
 * - 9bit: シーケンス
 *
 * IPv6 のみは対応していないし、複数の IPv4 アドレスを持つ場合は先頭（loopback ではない subnet/8 以上のもの）が使用される。
 *
 * 以下、思考過程と備考。
 *
 * - この関数は暗号化の初期化ベクトルで使用する想定なので 12byte を超えたくない（GCM の IV が 12byte なので）
 * - サーバー間で重複を許したくない場合の候補は下記で、現在は IPv4 を採用している
 *     - ホスト名
 *         - 文字列で大きさが読めないし一意である保証もない
 *     - MAC アドレス
 *         - 一意だが少し大きすぎる
 *         - 下3桁がシリアルIDらしいので同メーカーなら重複しないかもしれない
 *         - ただそもそも php で MAC アドレスを簡単に得る手段がない
 *     - IPv4
 *         - サーバー間で重複を許さないような id の生成は大抵クラスタを組んでいて IP が振られているはず
 *         - そして 4byte でユニークな IP が振られることはまずない（大抵は 2,3byte で固有のはず。/8未満のクラスタ構成なんて見たことない）
 *     - IPv6
 *         - 桁が大きすぎる
 *         - まだまだ IPv4 も現役なので積極的に採用する理由に乏しい
 * - 同じサーバーでも別プロセスだと sequence が効かないのでプロセスIDが必要
 *     - 少なくとも Windows では 65535 を超えないらしいし、現代的な linux ではデフォルト 2**22 のようだ
 *
 * @package ryunosuke\Functions\Package\misc
 *
 * @param array $id_info 元になった生成データのレシーバ引数
 * @param array $debug デバッグ用引数（配列で内部の動的な値を指定できる）
 * @return string|array 一意なバイナリ文字列（debug.raw:true なら配列で返す）
 */
function unique_id(&$id_info = [], $debug = [])
{
    static $TIMESTAMP_BASE = 1704034800; // 2024-01-01 00:00:00
    static $TIMESTAMP_PRECISION = 1000;
    static $RESULT_BIT = 96;
    static $LONG_BIT = 8 * PHP_INT_SIZE;
    static $TIMESTAMP_BIT = 41;
    static $IPADDRESS_BIT = 24;
    static $PROCESSID_BIT = 22;
    static $SEQUENCE_BIT = 9;
    assert(PHP_INT_SIZE === 8);
    assert(($TIMESTAMP_BIT + $IPADDRESS_BIT + $PROCESSID_BIT + $SEQUENCE_BIT) === $RESULT_BIT);

    static $laststamp = null;
    static $ipaddress = null;
    static $processid = null;
    static $sequence = 0;

    $id_info = [];

    $timestamp = $debug['timestamp'] ?? (int) (microtime(true) * $TIMESTAMP_PRECISION);
    if ($sequence === 2 ** $SEQUENCE_BIT) {
        usleep(1 * $TIMESTAMP_PRECISION);
        $timestamp += (int) (microtime(true) * $TIMESTAMP_PRECISION);
    }
    if ($timestamp !== $laststamp) {
        $sequence = 0;
    }

    $ipaddress ??= $debug['ipaddress'] ?? (function () {
        foreach (net_get_interfaces() as $interface) {
            // linkup していて・・・
            if ($interface['up']) {
                foreach ($interface['unicast'] as $addr) {
                    // IPv4 で・・・
                    if ($addr['family'] === AF_INET) {
                        // loopback ではない subnet/8 以上のもの
                        if (strpos($addr['address'], '127.') !== 0 && strpos($addr['netmask'], '255.') === 0) {
                            return $addr['address'];
                        }
                    }
                    // @todo subnet が /104 なら IPv6 でもいける？
                }
            }
        }
        throw new \UnexpectedValueException("ip address is not found"); // @codeCoverageIgnore
    })();

    $processid ??= $debug['processid'] ?? (function () use ($PROCESSID_BIT) {
        $pid = getmypid();
        if ($pid <= 2 ** $PROCESSID_BIT) {
            return $pid;
        }
        throw new \UnexpectedValueException("process id is too big ($pid)"); // @codeCoverageIgnore
    })();

    $id_info = [
        'timestamp' => $timestamp - $TIMESTAMP_BASE,
        'ipsegment' => ip2long($ipaddress) & (2 ** $IPADDRESS_BIT - 1),
        'processid' => $processid,
        'sequence'  => $sequence++,
    ];
    $laststamp = $timestamp;

    $sequence_right_bits = 0;
    $processid_right_bits = $sequence_right_bits + $SEQUENCE_BIT;
    $ipaddress_right_bits = $processid_right_bits + $PROCESSID_BIT;
    $timestamp_right_bits = $ipaddress_right_bits + $IPADDRESS_BIT;
    $lo_bits = $LONG_BIT - $timestamp_right_bits;

    // 123456789A123456789B123456789C123456789D123456789E123456789F1234
    // 00000000000000000000000_____________________________________time
    $hi64 = $id_info['timestamp'];

    // 123456789A123456789B123456789C123456789D123456789E123456789F1234
    // 000000000______________________ip___________________pid______seq
    $lo64 = ($id_info['ipsegment'] << $ipaddress_right_bits) | ($id_info['processid'] << $processid_right_bits) | ($id_info['sequence'] << $sequence_right_bits);

    // 123456789A123456789B123456789C123456789D123456789E123456789F123456789G123456789H123456789I123456
    // ------------time 32------------|-time 9-|---------ip 24---------|--------pid 22-------|---seq---
    $binary = pack('NJ', $hi64 >> $lo_bits, (($hi64 & (2 ** $lo_bits - 1)) << $timestamp_right_bits) | $lo64);
    assert($binary === (function () use ($TIMESTAMP_BIT, $timestamp_right_bits, $hi64, $lo64) {
            $binstr = sprintf("%0{$TIMESTAMP_BIT}b%0{$timestamp_right_bits}b", $hi64, $lo64);
            $octets = str_split($binstr, 8);
            $bytes = array_map(fn($v) => bindec($v), $octets);
            $chars = array_map(fn($v) => chr($v), $bytes);
            return implode('', $chars);
        })(),
    );
    return $binary;
}