<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 変数を extract して include する
 *
 * Example:
 * ```php
 * // このようなテンプレートファイルを用意すると
 * file_put_contents(sys_get_temp_dir() . '/template.php', '
 * This is plain text.
 * This is <?= $var ?>.
 * This is <?php echo strtoupper($var) ?>.
 * ');
 * // このようにレンダリングできる
 * that(ob_include(sys_get_temp_dir() . '/template.php', ['var' => 'hoge']))->isSame('
 * This is plain text.
 * This is hoge.
 * This is HOGE.
 * ');
 * ```
 *
 * @package ryunosuke\Functions\Package\outcontrol
 *
 * @param string $include_file include するファイル名
 * @param array $array extract される連想変数
 * @return string レンダリングされた文字列
 */
function ob_include($include_file, $array = [])
{
    /** @noinspection PhpMethodParametersCountMismatchInspection */
    return (static function () {
        ob_start();
        extract(func_get_arg(1));
        include func_get_arg(0);
        return ob_get_clean();
    })($include_file, $array);
}
