<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../exec/process.php';
require_once __DIR__ . '/../filesystem/path_resolve.php';
require_once __DIR__ . '/../network/getipaddress.php';
// @codeCoverageIgnoreEnd

/**
 * SNMPTrap を送信する
 *
 * UDP で送ろうかと思ったけど、実装が大変なので snmptrap コマンドに日和っている（ので Windows では動かない）。
 * 将来的には UDP/TCP にするかもしれない。
 *
 * インターフェースは v1 に寄せているが、v2 送信も可能。
 * 大抵の場合、generic:6 で固有トラップを送りたい場合に使うので $generic はオプショナルで未指定の場合自動設定される。
 *
 * $variables は値の型を見てバインド型を決めるので厳密に渡さなければならない（1 と 1.0 と "1" は全く別の意味になる）。
 *
 * @package ryunosuke\Functions\Package\network
 */
function snmp_trap(
    /** snmp バージョン */ int $version,
    /** 送信先 */ string $target,
    /** コミュニティ */ string $community,
    /** エンタープライズ OID */ string $enterprise,
    /** 固有トラップ番号 */ int $specific,
    /** 標準トラップ番号 */ ?int $generic = null,
    /** バインド変数 */ array $variables = [],
    /** 送信元アドレス（v1のみ） */ ?string $agent = null,
    /** リトライ回数 */ int $retry = 0,
    /** タイムアウト秒 */ int $timeout = 1,
) {
    assert(in_array($version, [1, 2], true));

    $cmdArgs = match ($version) {
        1 => [
            '-v' => '1',
            '-c' => $community,
            '-r' => $retry,
            '-t' => $timeout,
            $target,
            $enterprise,
            $agent ?? getipaddress($target) ?? '127.0.0.1',
            $generic ?? 6,
            $specific,
            '', // uptime
        ],
        2 => [
            '-v' => '2c',
            '-c' => $community,
            '-r' => $retry,
            '-t' => $timeout,
            $target,
            '', // uptime
            "$enterprise." . ($generic ?? 0) . ".$specific",
        ],
    };

    // https://net-snmp.sourceforge.io/tutorial/tutorial-5/commands/snmpset.html
    foreach ($variables as $oid => $value) {
        $cmdArgs[] = "$enterprise.$oid";
        $cmdArgs[] = match (true) {
            is_int($value)   => 'I',
            is_float($value) => 'D',
            default          => 's',
        };
        $cmdArgs[] = $value;
    }

    $snmptrap = path_resolve('snmptrap') ?? path_resolve('snmptrap.exe') ?? throw new \RuntimeException('not found executable snmptrap');
    $retval = process($snmptrap, $cmdArgs, '', $stdout, $stderr);
    if ($retval !== 0) {
        throw new \RuntimeException("snmptrap error: $stderr", $retval); // @codeCoverageIgnore
    }
}
