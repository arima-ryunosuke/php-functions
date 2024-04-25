<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../filesystem/mkdir_p.php';
require_once __DIR__ . '/../filesystem/path_normalize.php';
// @codeCoverageIgnoreEnd

/**
 * ディレクトリも掘る file_put_contents
 *
 * 書き込みは一時ファイルと rename を使用してアトミックに行われる。
 *
 * Example:
 * ```php
 * file_set_contents(sys_get_temp_dir() . '/not/filename.ext', 'hoge');
 * that(file_get_contents(sys_get_temp_dir() . '/not/filename.ext'))->isSame('hoge');
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $filename 書き込むファイル名
 * @param string $data 書き込む内容
 * @param int $umask ディレクトリを掘る際の umask
 * @return ?int 書き込まれたバイト数
 */
function file_set_contents($filename, $data, $umask = 0002)
{
    if (func_num_args() === 2) {
        $umask = umask();
    }

    $filename = path_normalize($filename);

    if (!is_dir($dirname = dirname($filename))) {
        if (!@mkdir_p($dirname, $umask)) {
            throw new \RuntimeException("failed to mkdir($dirname)");
        }
    }

    error_clear_last();
    $tempnam = @tempnam($dirname, 'tmp');
    if (strpos(error_get_last()['message'] ?? '', "file created in the system's temporary directory") !== false) {
        $result = file_put_contents($filename, $data);
        @chmod($filename, 0666 & ~$umask);
        return $result === false ? null : $result;
    }
    if (($result = file_put_contents($tempnam, $data)) !== false) {
        if (rename($tempnam, $filename)) {
            @chmod($filename, 0666 & ~$umask);
            return $result === false ? null : $result;
        }
        unlink($tempnam);
    }
    return null;
}
