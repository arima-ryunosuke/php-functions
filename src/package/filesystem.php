<?php
/**
 * ファイルシステムに関するユーティリティ
 *
 * @package filesystem
 */

/**
 * ファイル一覧を配列で返す
 *
 * @param string $dirname 調べるディレクトリ名
 * @param \Closure|array $filter_condition フィルタ条件
 * @return array|false ファイルの配列
 */
function file_list($dirname, $filter_condition = null)
{
    $dirname = realpath($dirname);
    if (!file_exists($dirname)) {
        return false;
    }

    $rdi = new \RecursiveDirectoryIterator($dirname, \FilesystemIterator::SKIP_DOTS);
    $rii = new \RecursiveIteratorIterator($rdi, \RecursiveIteratorIterator::CHILD_FIRST);

    $result = [];
    foreach ($rii as $it) {
        if (!$it->isDir()) {
            if ($filter_condition === null || $filter_condition($it->getPathname())) {
                $result[] = $it->getPathname();
            }
        }
    }
    return $result;
}

/**
 * ディレクトリ階層をツリー構造で返す
 *
 * @param string $dirname 調べるディレクトリ名
 * @param \Closure|array $filter_condition フィルタ条件
 * @return array|false ツリー構造の配列
 */
function file_tree($dirname, $filter_condition = null)
{
    $dirname = realpath($dirname);
    if (!file_exists($dirname)) {
        return false;
    }

    $basedir = basename($dirname);

    $result = [];
    foreach (new \FilesystemIterator($dirname, \FilesystemIterator::SKIP_DOTS) as $item) {
        if (!isset($result[$basedir])) {
            $result[$basedir] = [];
        }
        if ($item->isDir()) {
            $result[$basedir] += file_tree($item->getPathname(), $filter_condition);
        }
        else {
            if ($filter_condition === null || $filter_condition($item->getPathname())) {
                $result[$basedir][$item->getBasename()] = $item->getPathname();
            }
        }
    }
    // フィルタで全除去されると空エントリになるので明示的に削除
    if (!$result[$basedir]) {
        unset($result[$basedir]);
    }
    // ファイルの方が強いファイル名順
    else {
        $result[$basedir] = array_order($result[$basedir], ['is_array', return_arg(1)], true);
    }
    return $result;
}

/**
 * ファイルの拡張子を変更する。引数を省略すると拡張子を返す
 *
 * pathinfoに準拠。例えば「filename.hoge.fuga」のような形式は「fuga」が変換対象になる。
 *
 * Example:
 * <code>
 * assert(file_extension('filename.ext')        === 'ext');
 * assert(file_extension('filename.ext', 'txt') === 'filename.txt');
 * assert(file_extension('filename.ext', '')    === 'filename');
 * </code>
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
 * <code>
 * file_set_contents(sys_get_temp_dir() . '/not/filename.ext', 'hoge');
 * assert(file_get_contents(sys_get_temp_dir() . '/not/filename.ext') === 'hoge');
 * </code>
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
 * 既に存在する場合は何もしない（エラーも出さない）。
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
 * <code>
 * mkdir(sys_get_temp_dir() . '/new/make/dir', 0777, true);
 * rm_rf(sys_get_temp_dir() . '/new');
 * assert(file_exists(sys_get_temp_dir() . '/new') === false);
 * </code>
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

/**
 * 終了時に削除される一時ファイル名を生成する
 *
 * tempnam とほぼ同じで違いは下記。
 * - 引数が逆
 * - 終了時に削除される
 * - 失敗時に false を返すのではなく例外を投げる
 *
 * @param string $prefix ファイル名プレフィックス
 * @param string $dir 生成ディレクトリ。省略時は sys_get_temp_dir()
 * @return string 一時ファイル名
 */
function tmpname($prefix = 'rft', $dir = null)
{
    // デフォルト付きで tempnam を呼ぶ
    $dir = $dir ?: sys_get_temp_dir();
    $tempfile = tempnam($dir, $prefix);

    // tempnam が何をしても false を返してくれないんだがどうしたら返してくれるんだろうか？
    if ($tempfile === false) {
        throw new \UnexpectedValueException("tmpname($dir, $prefix) failed.");// @codeCoverageIgnore
    }

    // 生成したファイルを覚えておいて最後に消す
    static $files = [];
    $files[] = $tempfile;
    // ただし、 shutdown_function にあまり大量に追加したくないので初回のみ登録する（$files は参照で渡す）
    if (count($files) === 1) {
        register_shutdown_function(function () use (&$files) {
            // @codeCoverageIgnoreStart
            foreach ($files as $file) {
                // 明示的に消されたかもしれないので file_exists してから消す
                if (file_exists($file)) {
                    // レースコンディションのため @ を付ける
                    @unlink($file);
                }
            }
            // @codeCoverageIgnoreEnd
        });
    }

    return $tempfile;
}
