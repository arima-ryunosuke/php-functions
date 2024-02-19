<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../filesystem/path_is_absolute.php';
require_once __DIR__ . '/../filesystem/path_normalize.php';
// @codeCoverageIgnoreEnd

/**
 * sys_get_temp_dir が返すディレクトリを変更する
 *
 * ただし、sys_get_temp_dir は一度でも呼ぶと内部的にキャッシュされるので、必ず呼ぶ前に設定しなければならない。
 * 相対パスを指定すると標準設定からの相対になる。
 *
 * $check_settled はデバッグ用なので運用では使わないこと。
 *
 * @see https://github.com/php/php-src/blob/af6c11c5f060870d052a2b765dc634d9e47d0f18/main/php_open_temporary_file.c
 *
 * Example:
 * ```php
 * // 標準一時ディレクトリ/systemname で一時ディレクトリを設定してかつ作成する
 * sys_set_temp_dir("systemname", true);
 * //that(sys_get_temp_dir())->is(...); // 上記が設定されている
 * ```
 *
 * @package ryunosuke\Functions\Package\info
 *
 * @param string $directory 一時ディレクトリ
 * @param bool $creates 設定すると同時に作成するか
 * @return bool 成功時に true
 */
function sys_set_temp_dir($directory, $creates = true, $check_settled = true)
{
    $envname = ['\\' => 'TMP', '/' => 'TMPDIR'][DIRECTORY_SEPARATOR];
    $current = getenv($envname);

    // sys_temp_dir が指定されているならそこからの相対とする
    $sys_temp_dir = ini_get('sys_temp_dir');
    $sys_temp_dir = strlen($sys_temp_dir) ? $sys_temp_dir : $current;
    if (strlen($sys_temp_dir) && !path_is_absolute($directory)) {
        $directory = $sys_temp_dir . DIRECTORY_SEPARATOR . $directory;
    }

    // 各プラットフォームの環境変数を変更して sys_get_temp_dir で確定させる（環境変数を変更したままは行儀が悪いので確定したら元に戻す）
    putenv("$envname=$directory");
    $tmpdir = sys_get_temp_dir();
    putenv("$envname=$current");

    // 設定できてないなら何かがおかしい
    if ($check_settled && $tmpdir !== path_normalize($directory)) {
        return false;
    }

    // 作成する場合は作ってその結果を返り値とする
    if ($creates) {
        @mkdir($tmpdir, 0777, true);
        return is_dir($tmpdir);
    }

    return true;
}
