<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../exec/process.php';
require_once __DIR__ . '/../info/php_binary.php';
// @codeCoverageIgnoreEnd

/**
 * コード断片の opcode を返す
 *
 * php レベルでサクッと取りたいことはあるし、ini 設定がややややこしく、簡単に取れない場合があるので関数化した。
 * phpdbg 等ではなく opcache で出すため、与えたコードは実行されることに注意。
 *
 * @see https://www.npopov.com/2022/05/22/The-opcache-optimizer.html
 *
 * @package ryunosuke\Functions\Package\misc
 *
 * @param string $phpcode php コード
 * @param int $level opt_debug_level に渡される（URL 参照だが、正味使うのは 0x10000:最適化前, 0x20000:最適化後 くらいだろう）
 * @return string opcode
 */
function php_opcode($phpcode, $level = 0x20000)
{
    $level = dechex($level);

    // log_errors=0 でもいいけど、何かに使えるかもしれないしログは残しておく
    $errorlog = sys_get_temp_dir() . '/php-cli.log';
    touch($errorlog);
    $errorlog = realpath($errorlog);
    @unlink($errorlog);

    process(php_binary(), [
        '-d' => [
            "opcache.enable=1",                   // 必須
            "opcache.enable_cli=1",               // 必須
            "opcache.opt_debug_level=0x{$level}", // 必須
            "opcache.file_update_protection=0",   // 0 にしないと作成直後は opcache が無効になる
            "auto_prepend_file=",                 // 余計なファイルが実行されうる
            "auto_append_file=",                  // 余計なファイルが実行されうる
            "error_log=$errorlog",                // 標準エラーに出力されるので指定しないと混ざる
        ],
    ], "<?php\n$phpcode", $stdout, $stderr);

    return $stderr;
}
