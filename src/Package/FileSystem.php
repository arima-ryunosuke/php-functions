<?php

namespace ryunosuke\Functions\Package;

class FileSystem
{
    /**
     * ファイル一覧を配列で返す
     *
     * @package FileSystem
     *
     * @param string $dirname 調べるディレクトリ名
     * @param \Closure|array $filter_condition フィルタ条件
     * @return array|false ファイルの配列
     */
    public static function file_list($dirname, $filter_condition = null)
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
     * @package FileSystem
     *
     * @param string $dirname 調べるディレクトリ名
     * @param \Closure|array $filter_condition フィルタ条件
     * @return array|false ツリー構造の配列
     */
    public static function file_tree($dirname, $filter_condition = null)
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
                $result[$basedir] += call_user_func(file_tree, $item->getPathname(), $filter_condition);
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
            $result[$basedir] = call_user_func(array_order, $result[$basedir], ['is_array', call_user_func(return_arg, 1)], true);
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
     * @package FileSystem
     *
     * @param string $filename 調べるファイル名
     * @param string $extension 拡張子。nullや空文字なら拡張子削除
     * @return string 拡張子変換後のファイル名 or 拡張子
     */
    public static function file_extension($filename, $extension = '')
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
     * @package FileSystem
     *
     * @param string $filename 書き込むファイル名
     * @param string $data 書き込む内容
     * @param int $umask ディレクトリを掘る際の umask
     * @return int 書き込まれたバイト数
     */
    public static function file_set_contents($filename, $data, $umask = 0002)
    {
        if (func_num_args() === 2) {
            $umask = umask();
        }

        if (!is_dir($dirname = dirname($filename))) {
            if (!@call_user_func(mkdir_p, $dirname, $umask)) {
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
     * @package FileSystem
     *
     * @param string $dirname ディレクトリ名
     * @param int $umask ディレクトリを掘る際の umask
     * @return bool 作成したら true
     */
    public static function mkdir_p($dirname, $umask = 0002)
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
     * コールバックが true 相当を返すまで親ディレクトリを辿り続ける
     *
     * コールバックには親ディレクトリが引数として渡ってくる。
     *
     * Example:
     * <code>
     * // //tmp/a/b/file.txt を作っておく
     * $tmp = sys_get_temp_dir();
     * file_set_contents("$tmp/a/b/file.txt", 'hoge');
     * // /a/b/c/d/e/f から開始して「どこかの階層の file.txt を探したい」という状況を想定
     * $callback = function($path){return realpath("$path/file.txt");};
     * assert(dirname_r("$tmp/a/b/c/d/e/f", $callback) === realpath("$tmp/a/b/file.txt"));
     * </code>
     *
     * @package FileSystem
     *
     * @param string $path パス名
     * @param callable $callback コールバック
     * @return mixed $callback の返り値。頂上まで辿ったら false
     */
    public static function dirname_r($path, $callback)
    {
        $return = $callback($path);
        if ($return) {
            return $return;
        }

        $dirname = dirname($path);
        if ($dirname === $path) {
            return false;
        }
        return call_user_func(dirname_r, $dirname, $callback);
    }

    /**
     * パスが絶対パスか判定する
     *
     * Example:
     * <code>
     * assert(path_is_absolute('/absolute/path') === true);
     * assert(path_is_absolute('relative/path')  === false);
     * // Windows 環境では下記も true になる
     * if (DIRECTORY_SEPARATOR === '\\') {
     *     assert(path_is_absolute('\\absolute\\path')    === true);
     *     assert(path_is_absolute('C:\\absolute\\path')  === true);
     * }
     * </code>
     *
     * @package FileSystem
     *
     * @param string $path パス文字列
     * @return bool 絶対パスなら true
     */
    public static function path_is_absolute($path)
    {
        if (substr($path, 0, 1) == '/') {
            return true;
        }

        if (DIRECTORY_SEPARATOR === '\\') {
            if (preg_match('#^([a-z]+:(\\\\|\\/|$)|\\\\)#i', $path) !== 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * パスを絶対パスに変換して正規化する
     *
     * 可変引数で与えられた文字列群を結合して絶対パス化して返す。
     * 出来上がったパスが絶対パスでない場合はカレントディレクトリを結合して返す。
     *
     * Example:
     * <code>
     * $DS = DIRECTORY_SEPARATOR;
     * assert(path_resolve('/absolute/path') === "{$DS}absolute{$DS}path");
     * assert(path_resolve('absolute/path')  === getcwd() . "{$DS}absolute{$DS}path");
     * assert(path_resolve('/absolute/path/through', '../current/./path') === "{$DS}absolute{$DS}path{$DS}current{$DS}path");
     * </code>
     *
     * @package FileSystem
     *
     * @param array $paths パス文字列（可変引数）
     * @return string 絶対パス
     */
    public static function path_resolve(...$paths)
    {
        $DS = DIRECTORY_SEPARATOR;

        $path = implode($DS, $paths);

        if (!call_user_func(path_is_absolute, $path)) {
            $path = getcwd() . $DS . $path;
        }

        return call_user_func(path_normalize, $path);
    }

    /**
     * パスを正規化する
     *
     * 具体的には ./ や ../ を取り除いたり連続したディレクトリ区切りをまとめたりする。
     * realpath ではない。のでシンボリックリンクの解決などはしない。その代わりファイルが存在しなくても使用することができる。
     *
     * Example:
     * <code>
     * $DS = DIRECTORY_SEPARATOR;
     * assert(path_normalize('/path/to/something')                    === "{$DS}path{$DS}to{$DS}something");
     * assert(path_normalize('/path/through/../something')            === "{$DS}path{$DS}something");
     * assert(path_normalize('./path/current/./through/../something') === "path{$DS}current{$DS}something");
     * </code>
     *
     * @package FileSystem
     *
     * @param string $path パス文字列
     * @return string 正規化されたパス
     */
    public static function path_normalize($path)
    {
        $ds = '/';
        if (DIRECTORY_SEPARATOR === '\\') {
            $ds .= '\\\\';
        }

        $result = [];
        foreach (preg_split("#[$ds]#u", $path) as $n => $part) {
            if ($n > 0 && $part === '') {
                continue;
            }
            if ($part === '.') {
                continue;
            }
            if ($part === '..') {
                if (empty($result)) {
                    throw new \InvalidArgumentException("'$path' is invalid as path string.");
                }
                array_pop($result);
                continue;
            }
            $result[] = $part;
        }
        return implode(DIRECTORY_SEPARATOR, $result);
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
     * @package FileSystem
     *
     * @param string $dirname 削除するディレクトリ名
     * @param bool $self 自分自身も含めるか。false を与えると中身だけを消す
     * @return bool 成功した場合に TRUE を、失敗した場合に FALSE を返します
     */
    public static function rm_rf($dirname, $self = true)
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
     * @package FileSystem
     *
     * @param string $prefix ファイル名プレフィックス
     * @param string $dir 生成ディレクトリ。省略時は sys_get_temp_dir()
     * @return string 一時ファイル名
     */
    public static function tmpname($prefix = 'rft', $dir = null)
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
}
