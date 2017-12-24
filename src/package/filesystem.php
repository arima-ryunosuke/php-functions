<?php
/**
 * ファイルシステムに関するユーティリティ
 *
 * @package filesystem
 */

/**
 * ファイルの拡張子を変更する。引数を省略すると拡張子を返す
 *
 * pathinfoに準拠。例えば「filename.hoge.fuga」のような形式は「fuga」が変換対象になる。
 *
 * Example:
 * ```php
 * assert(file_extension('filename.ext')        === 'ext');
 * assert(file_extension('filename.ext', 'txt') === 'filename.txt');
 * assert(file_extension('filename.ext', '')    === 'filename');
 * ```
 *
 * @param string $filename 調べるファイル名
 * @param string $extension 拡張子。nullや空文字なら拡張子削除
 * @return string 拡張子変換後のファイル名 or 拡張子
 */
function file_extension($filename, $extension = '')
{
    $pathinfo = pathinfo($filename);

    if (func_num_args() === 1) {
        return isset($pathinfo['extension']) ? $pathinfo['extension'] : null;
    }

    if (strlen($extension)) {
        $extension = '.' . ltrim($extension, '.');
    }
    $basename = $pathinfo['filename'] . $extension;

    if ($pathinfo['dirname'] === '.') {
        return $basename;
    }

    return $pathinfo['dirname'] . DIRECTORY_SEPARATOR . $basename;
}

/**
 * ディレクトリも掘る file_put_contents
 *
 * Example:
 * ```php
 * file_set_contents(sys_get_temp_dir() . '/not/filename.ext', 'hoge');
 * assert(file_get_contents(sys_get_temp_dir() . '/not/filename.ext') === 'hoge');
 * ```
 *
 * @param string $filename 書き込むファイル名
 * @param string $data 書き込む内容
 * @param int $umask ディレクトリを掘る際の umask
 * @return int 書き込まれたバイト数
 */
function file_set_contents($filename, $data, $umask = 0002)
{
    if (func_num_args() === 2) {
        $umask = umask();
    }

    if (!is_dir($dirname = dirname($filename))) {
        if (!@mkdir_p($dirname, $umask)) {
            throw new \RuntimeException("failed to mkdir($dirname)");
        }
    }
    return file_put_contents($filename, $data);
}

/**
 * ディレクトリを再帰的に掘る
 *
 * @param string $dirname ディレクトリ名
 * @param int $umask ディレクトリを掘る際の umask
 * @return bool 作成したら true
 */
function mkdir_p($dirname, $umask = 0002)
{
    if (func_num_args() === 1) {
        $umask = umask();
    }

    if (file_exists($dirname)) {
        return false;
    }

    return mkdir($dirname, 0777 & (~$umask), true);
}

/**
 * 中身があっても消せる rmdir
 *
 * Example:
 * ```php
 * mkdir(sys_get_temp_dir() . '/new/make/dir', 0777, true);
 * rm_rf(sys_get_temp_dir() . '/new');
 * assert(file_exists(sys_get_temp_dir() . '/new') === false);
 * ```
 *
 * @param string $dirname 削除するディレクトリ名
 * @param bool $self 自分自身も含めるか。false を与えると中身だけを消す
 * @return bool 成功した場合に TRUE を、失敗した場合に FALSE を返します
 */
function rm_rf($dirname, $self = true)
{
    if (!file_exists($dirname)) {
        return false;
    }

    $rdi = new \RecursiveDirectoryIterator($dirname, \FilesystemIterator::SKIP_DOTS);
    $rii = new \RecursiveIteratorIterator($rdi, \RecursiveIteratorIterator::CHILD_FIRST);

    foreach ($rii as $it) {
        if ($it->isDir()) {
            rmdir($it->getPathname());
        }
        else {
            unlink($it->getPathname());
        }
    }

    if ($self) {
        return rmdir($dirname);
    }
}
