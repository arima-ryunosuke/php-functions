<?php

namespace ryunosuke\Functions\Package;

/**
 * ファイルシステム関連のユーティリティ
 */
class FileSystem
{
    /**
     * ファイル一覧を配列で返す
     *
     * Example:
     * ```php
     * // 適当にファイルを用意
     * $DS = DIRECTORY_SEPARATOR;
     * $tmp = sys_get_temp_dir() . "{$DS}file_list";
     * rm_rf($tmp, false);
     * file_set_contents("$tmp/a.txt", 'a');
     * file_set_contents("$tmp/dir/b.txt", 'b');
     * file_set_contents("$tmp/dir/dir/c.txt", 'c');
     * // ファイル一覧が取得できる
     * assertEquals(file_list($tmp), [
     *     "$tmp{$DS}a.txt",
     *     "$tmp{$DS}dir{$DS}b.txt",
     *     "$tmp{$DS}dir{$DS}dir{$DS}c.txt",
     * ], '', 0, 10, true);
     * ```
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
     * Example:
     * ```php
     * // 適当にファイルを用意
     * $DS = DIRECTORY_SEPARATOR;
     * $tmp = sys_get_temp_dir() . "{$DS}file_tree";
     * rm_rf($tmp, false);
     * file_set_contents("$tmp/a.txt", 'a');
     * file_set_contents("$tmp/dir/b.txt", 'b');
     * file_set_contents("$tmp/dir/dir/c.txt", 'c');
     * // ファイルツリーが取得できる
     * assertEquals(file_tree($tmp), [
     *     'file_tree' => [
     *         'a.txt' => "$tmp{$DS}a.txt",
     *         'dir'   => [
     *             'b.txt' => "$tmp{$DS}dir{$DS}b.txt",
     *             'dir'   => [
     *                 'c.txt' => "$tmp{$DS}dir{$DS}dir{$DS}c.txt",
     *             ],
     *         ],
     *     ],
     * ]);
     * ```
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
        $items = iterator_to_array(new \FilesystemIterator($dirname, \FilesystemIterator::SKIP_DOTS));
        usort($items, function (\SplFileInfo $a, \SplFileInfo $b) {
            if ($a->isDir() xor $b->isDir()) {
                return $a->isDir() - $b->isDir();
            }
            return strcmp($a->getPathname(), $b->getPathname());
        });
        foreach ($items as $item) {
            if (!isset($result[$basedir])) {
                $result[$basedir] = [];
            }
            if ($item->isDir()) {
                $result[$basedir] += (file_tree)($item->getPathname(), $filter_condition);
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
        return $result;
    }

    /**
     * ファイル名にサフィックスを付与する
     *
     * pathinfoに非準拠。例えば「filename.hoge.fuga」のような形式は「filename」が変換対象になる。
     *
     * Example:
     * ```php
     * assertSame(file_suffix('filename.ext', '-min'), 'filename-min.ext');
     * assertSame(file_suffix('filename.ext1.ext2', '-min'), 'filename-min.ext1.ext2');
     * ```
     *
     * @param string $filename パス・ファイル名
     * @param string $suffix 付与するサフィックス
     * @return string サフィックスが付与されたパス名
     */
    public static function file_suffix($filename, $suffix)
    {
        $pathinfo = pathinfo($filename);
        $dirname = $pathinfo['dirname'];

        $exts = [];
        while (isset($pathinfo['extension'])) {
            $exts[] = '.' . $pathinfo['extension'];
            $pathinfo = pathinfo($pathinfo['filename']);
        }

        $basename = $pathinfo['filename'] . $suffix . implode('', array_reverse($exts));

        if ($dirname === '.') {
            return $basename;
        }

        return $dirname . DIRECTORY_SEPARATOR . $basename;
    }

    /**
     * ファイルの拡張子を変更する。引数を省略すると拡張子を返す
     *
     * pathinfo に準拠。例えば「filename.hoge.fuga」のような形式は「fuga」が変換対象になる。
     *
     * Example:
     * ```php
     * assertSame(file_extension('filename.ext'), 'ext');
     * assertSame(file_extension('filename.ext', 'txt'), 'filename.txt');
     * assertSame(file_extension('filename.ext', ''), 'filename');
     * ```
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
     * 書き込みは一時ファイルと rename を使用してアトミックに行われる。
     *
     * Example:
     * ```php
     * file_set_contents(sys_get_temp_dir() . '/not/filename.ext', 'hoge');
     * assertSame(file_get_contents(sys_get_temp_dir() . '/not/filename.ext'), 'hoge');
     * ```
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

        $filename = (path_normalize)($filename);

        if (!is_dir($dirname = dirname($filename))) {
            if (!@(mkdir_p)($dirname, $umask)) {
                throw new \RuntimeException("failed to mkdir($dirname)");
            }
        }

        $tempnam = tempnam($dirname, 'tmp');
        if (($result = file_put_contents($tempnam, $data)) !== false) {
            if (rename($tempnam, $filename)) {
                @chmod($filename, 0666 & ~$umask);
                return $result;
            }
            unlink($tempnam);
        }
        return false;
    }

    /**
     * ファイルを読み込んで内容をコールバックに渡して書き込む
     *
     * Example:
     * ```php
     * // 適当にファイルを用意
     * $testpath = sys_get_temp_dir() . '/rewrite.txt';
     * file_put_contents($testpath, 'hoge');
     * // 前後に 'pre-', '-fix' を付与する
     * file_rewrite_contents($testpath, function($contents, $fp){ return "pre-$contents-fix"; });
     * assertStringEqualsFile($testpath, 'pre-hoge-fix');
     * ```
     *
     * @param string $filename 読み書きするファイル名
     * @param callable $callback 書き込む内容。引数で $contents, $fp が渡ってくる
     * @param int $operation ロック定数（LOCL_SH, LOCK_EX, LOCK_NB）
     * @return int 書き込まれたバイト数
     */
    public static function file_rewrite_contents($filename, $callback, $operation = 0)
    {
        /** @var resource $fp */
        try {
            // 開いて
            $fp = fopen($filename, 'c+b') ?: (throws)(new \UnexpectedValueException('failed to fopen.'));
            if ($operation) {
                flock($fp, $operation) ?: (throws)(new \UnexpectedValueException('failed to flock.'));
            }

            // 読み込んで
            rewind($fp) ?: (throws)(new \UnexpectedValueException('failed to rewind.'));
            $contents = false !== ($t = stream_get_contents($fp)) ? $t : (throws)(new \UnexpectedValueException('failed to stream_get_contents.'));

            // 変更して
            rewind($fp) ?: (throws)(new \UnexpectedValueException('failed to rewind.'));
            ftruncate($fp, 0) ?: (throws)(new \UnexpectedValueException('failed to ftruncate.'));
            $contents = $callback($contents, $fp);

            // 書き込んで
            $return = ($r = fwrite($fp, $contents)) !== false ? $r : (throws)(new \UnexpectedValueException('failed to fwrite.'));
            fflush($fp) ?: (throws)(new \UnexpectedValueException('failed to fflush.'));

            // 閉じて
            if ($operation) {
                flock($fp, LOCK_UN) ?: (throws)(new \UnexpectedValueException('failed to flock.'));
            }
            fclose($fp) ?: (throws)(new \UnexpectedValueException('failed to fclose.'));

            // 返す
            return $return;
        }
        catch (\Exception $ex) {
            if (isset($fp)) {
                if ($operation) {
                    flock($fp, LOCK_UN);
                }
                fclose($fp);
            }
            throw $ex;
        }
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
     * ```php
     * // //tmp/a/b/file.txt を作っておく
     * $tmp = sys_get_temp_dir();
     * file_set_contents("$tmp/a/b/file.txt", 'hoge');
     * // /a/b/c/d/e/f から開始して「どこかの階層の file.txt を探したい」という状況を想定
     * $callback = function($path){return realpath("$path/file.txt");};
     * assertSame(dirname_r("$tmp/a/b/c/d/e/f", $callback), realpath("$tmp/a/b/file.txt"));
     * ```
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
        return (dirname_r)($dirname, $callback);
    }

    /**
     * ディレクトリの最終更新日時を返す
     *
     * 「ディレクトリの最終更新日時」とは filemtime で得られる結果ではなく、「配下のファイル群で最も新しい日時」を表す。
     * ディレクトリの mtime も検出に含まれるので、ファイルを削除した場合も検知できる。
     *
     * ファイル名を与えると例外を投げる。
     * 空ディレクトリの場合は自身の mtime を返す。
     *
     * Example:
     * ```php
     * $dirname = sys_get_temp_dir() . '/mtime';
     * rm_rf($dirname);
     * mkdir($dirname);
     *
     * // この時点では現在日時（単純に自身の更新日時）
     * assertSame(dirmtime($dirname), time());
     * // ファイルを作って更新するとその時刻
     * touch("$dirname/tmp", time() + 10);
     * assertSame(dirmtime($dirname), time() + 10);
     * ```
     *
     * @param string $dirname ディレクトリ名
     * @param bool $recursive 再帰フラグ
     * @return int 最終更新日時
     */
    public static function dirmtime($dirname, $recursive = true)
    {
        if (!is_dir($dirname)) {
            throw new \InvalidArgumentException("'$dirname' is not directory.");
        }

        $rdi = new \RecursiveDirectoryIterator($dirname, \FilesystemIterator::SKIP_DOTS);
        $dirtime = filemtime($dirname);
        foreach ($rdi as $path) {
            /** @var \SplFileInfo $path */
            $mtime = $path->getMTime();
            if ($path->isDir() && $recursive) {
                $mtime = max($mtime, (dirmtime)($path->getPathname(), $recursive));
            }
            if ($dirtime < $mtime) {
                $dirtime = $mtime;
            }
        }
        return $dirtime;
    }

    /**
     * fnmatch の AND 版
     *
     * $patterns のうちどれか一つでもマッチしなかったら false を返す。
     * $patterns が空だと例外を投げる。
     *
     * Example:
     * ```php
     * // すべてにマッチするので true
     * assertTrue(fnmatch_and(['*aaa*', '*bbb*'], 'aaaXbbbX'));
     * // aaa にはマッチするが bbb にはマッチしないので false
     * assertFalse(fnmatch_and(['*aaa*', '*bbb*'], 'aaaX'));
     * ```
     *
     * @param array|string $patterns パターン配列（単一文字列可）
     * @param string $string 調べる文字列
     * @param int $flags FNM_***
     * @return bool すべてにマッチしたら true
     */
    public static function fnmatch_and($patterns, $string, $flags = 0)
    {
        $patterns = (is_iterable)($patterns) ? $patterns : [$patterns];
        if ((is_empty)($patterns)) {
            throw new \InvalidArgumentException('$patterns must be not empty.');
        }

        foreach ($patterns as $pattern) {
            if (!fnmatch($pattern, $string, $flags)) {
                return false;
            }
        }
        return true;
    }

    /**
     * fnmatch の OR 版
     *
     * $patterns のうちどれか一つでもマッチしたら true を返す。
     * $patterns が空だと例外を投げる。
     *
     * Example:
     * ```php
     * // aaa にマッチするので true
     * assertTrue(fnmatch_or(['*aaa*', '*bbb*'], 'aaaX'));
     * // どれともマッチしないので false
     * assertFalse(fnmatch_or(['*aaa*', '*bbb*'], 'cccX'));
     * ```
     *
     * @param array|string $patterns パターン配列（単一文字列可）
     * @param string $string 調べる文字列
     * @param int $flags FNM_***
     * @return bool どれかにマッチしたら true
     */
    public static function fnmatch_or($patterns, $string, $flags = 0)
    {
        $patterns = (is_iterable)($patterns) ? $patterns : [$patterns];
        if ((is_empty)($patterns)) {
            throw new \InvalidArgumentException('$patterns must be not empty.');
        }

        foreach ($patterns as $pattern) {
            if (fnmatch($pattern, $string, $flags)) {
                return true;
            }
        }
        return false;
    }

    /**
     * パスが絶対パスか判定する
     *
     * Example:
     * ```php
     * assertTrue(path_is_absolute('/absolute/path'));
     * assertFalse(path_is_absolute('relative/path'));
     * // Windows 環境では下記も true になる
     * if (DIRECTORY_SEPARATOR === '\\') {
     *     assertTrue(path_is_absolute('\\absolute\\path'));
     *     assertTrue(path_is_absolute('C:\\absolute\\path'));
     * }
     * ```
     *
     * @param string $path パス文字列
     * @return bool 絶対パスなら true
     */
    public static function path_is_absolute($path)
    {
        // スキームが付いている場合は path 部分で判定
        $parts = parse_url($path);
        if (isset($parts['scheme'], $parts['path'])) {
            $path = $parts['path'];
        }
        elseif (isset($parts['scheme'], $parts['host'])) {
            $path = $parts['host'];
        }

        if (substr($path, 0, 1) === '/') {
            return true;
        }

        if (DIRECTORY_SEPARATOR === '\\') {
            if (preg_match('#^([a-z]+:(\\\\|/|$)|\\\\)#i', $path) !== 0) {
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
     * ```php
     * $DS = DIRECTORY_SEPARATOR;
     * assertSame(path_resolve('/absolute/path'), "{$DS}absolute{$DS}path");
     * assertSame(path_resolve('absolute/path'), getcwd() . "{$DS}absolute{$DS}path");
     * assertSame(path_resolve('/absolute/path/through', '../current/./path'), "{$DS}absolute{$DS}path{$DS}current{$DS}path");
     * ```
     *
     * @param array $paths パス文字列（可変引数）
     * @return string 絶対パス
     */
    public static function path_resolve(...$paths)
    {
        $DS = DIRECTORY_SEPARATOR;

        $path = implode($DS, $paths);

        if (!(path_is_absolute)($path)) {
            $path = getcwd() . $DS . $path;
        }

        return (path_normalize)($path);
    }

    /**
     * パスを正規化する
     *
     * 具体的には ./ や ../ を取り除いたり連続したディレクトリ区切りをまとめたりする。
     * realpath ではない。のでシンボリックリンクの解決などはしない。その代わりファイルが存在しなくても使用することができる。
     *
     * Example:
     * ```php
     * $DS = DIRECTORY_SEPARATOR;
     * assertSame(path_normalize('/path/to/something'), "{$DS}path{$DS}to{$DS}something");
     * assertSame(path_normalize('/path/through/../something'), "{$DS}path{$DS}something");
     * assertSame(path_normalize('./path/current/./through/../something'), "path{$DS}current{$DS}something");
     * ```
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
     * ディレクトリのコピー
     *
     * $dst に / を付けると「$dst に自身をコピー」する。付けないと「$dst に中身をコピー」するという動作になる。
     *
     * ディレクトリではなくファイルを与えても動作する（copy とほぼ同じ動作になるが、対象にディレクトリを指定できる点が異なる）。
     *
     * Example:
     * ```php
     * // /tmp/src/hoge.txt, /tmp/src/dir/fuga.txt を作っておく
     * $tmp = sys_get_temp_dir();
     * file_set_contents("$tmp/src/hoge.txt", 'hoge');
     * file_set_contents("$tmp/src/dir/fuga.txt", 'fuga');
     *
     * // "/" を付けないと中身コピー
     * cp_rf("$tmp/src", "$tmp/dst1");
     * assertStringEqualsFile("$tmp/dst1/hoge.txt", 'hoge');
     * assertStringEqualsFile("$tmp/dst1/dir/fuga.txt", 'fuga');
     * // "/" を付けると自身コピー
     * cp_rf("$tmp/src", "$tmp/dst2/");
     * assertStringEqualsFile("$tmp/dst2/src/hoge.txt", 'hoge');
     * assertStringEqualsFile("$tmp/dst2/src/dir/fuga.txt", 'fuga');
     *
     * // $src はファイルでもいい（$dst に "/" を付けるとそのディレクトリにコピーする）
     * cp_rf("$tmp/src/hoge.txt", "$tmp/dst3/");
     * assertStringEqualsFile("$tmp/dst3/hoge.txt", 'hoge');
     * // $dst に "/" を付けないとそのパスとしてコピー（copy と完全に同じ）
     * cp_rf("$tmp/src/hoge.txt", "$tmp/dst4");
     * assertStringEqualsFile("$tmp/dst4", 'hoge');
     * ```
     *
     * @param string $src コピー元パス
     * @param string $dst コピー先パス。末尾/でディレクトリであることを明示できる
     * @return bool 成功した場合に TRUE を、失敗した場合に FALSE を返します
     */
    public static function cp_rf($src, $dst)
    {
        $dss = '/' . (DIRECTORY_SEPARATOR === '\\' ? '\\\\' : '');
        $dirmode = preg_match("#[$dss]$#u", $dst);

        // ディレクトリでないなら copy へ移譲
        if (!is_dir($src)) {
            if ($dirmode) {
                (mkdir_p)($dst);
                return copy($src, $dst . basename($src));
            }
            else {
                (mkdir_p)(dirname($dst));
                return copy($src, $dst);
            }
        }

        if ($dirmode) {
            return (cp_rf)($src, $dst . basename($src));
        }

        (mkdir_p)($dst);

        foreach (glob("$src/*") as $file) {
            if (is_dir($file)) {
                (cp_rf)($file, "$dst/" . basename($file));
            }
            else {
                copy($file, "$dst/" . basename($file));
            }
        }
        return file_exists($dst);
    }

    /**
     * 中身があっても消せる rmdir
     *
     * Example:
     * ```php
     * mkdir(sys_get_temp_dir() . '/new/make/dir', 0777, true);
     * rm_rf(sys_get_temp_dir() . '/new');
     * assertSame(file_exists(sys_get_temp_dir() . '/new'), false);
     * ```
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
     *
     * - 引数が逆
     * - 終了時に削除される
     * - 失敗時に false を返すのではなく例外を投げる
     *
     * @param string $prefix ファイル名プレフィックス
     * @param string $dir 生成ディレクトリ。省略時は sys_get_temp_dir()
     * @return string 一時ファイル名
     */
    public static function tmpname($prefix = 'rft', $dir = null)
    {
        // デフォルト付きで tempnam を呼ぶ
        $dir = $dir ?: (cachedir)();
        $tempfile = tempnam($dir, $prefix);

        // tempnam が何をしても false を返してくれないんだがどうしたら返してくれるんだろうか？
        if ($tempfile === false) {
            throw new \UnexpectedValueException("tmpname($dir, $prefix) failed.");// @codeCoverageIgnore
        }

        // 生成したファイルを覚えておいて最後に消す
        static $files = [];
        $files[$tempfile] = new class($tempfile)
        {
            private $tempfile;

            public function __construct($tempfile) { $this->tempfile = $tempfile; }

            public function __destruct() { return $this(); }

            public function __invoke()
            {
                // 明示的に消されたかもしれないので file_exists してから消す
                if (file_exists($this->tempfile)) {
                    // レースコンディションのため @ を付ける
                    @unlink($this->tempfile);
                }
            }
        };

        return $tempfile;
    }

    /**
     * ファイルのように扱えるメモリ上のパスを返す
     *
     * 劣化 vfsStream のようなもの。
     * stream wrapper を用いて実装しており、そのプロトコルは初回呼び出し時に1度だけ登録される。
     * プロトコル名は決め打ちだが、 php.ini に "rfunc.memory_stream" というキーで文字列を指定するとそれが使用される。
     *
     * ファイル操作はある程度できるが、ディレクトリ操作は未対応（そこまでしたいなら vfsStream とか /dev/shm とかを使えば良い）。
     *
     * Example:
     * ```php
     * // ファイル名のように読み書きができるパスを返す（一時ファイルを使用するよりかなり高速に動作する）
     * $memory_path = memory_path('filename.txt');
     * // 呼んだだけでは何もしないので存在しない
     * assertSame(file_exists($memory_path), false);
     * // file_put_contents が使える
     * assertSame(file_put_contents($memory_path, 'Hello, World'), 12);
     * // file_get_contents が使える
     * assertSame(file_get_contents($memory_path), 'Hello, World');
     * // 上記の操作で実体が存在している
     * assertSame(file_exists($memory_path), true);
     * // unlink が使える
     * assertSame(unlink($memory_path), true);
     * // unlink したので存在しない
     * assertSame(file_exists($memory_path), false);
     * ```
     *
     * @param string $path パス名（実質的に一意なファイル名）
     * @return string メモリ上のパス
     */
    public static function memory_path($path)
    {
        static $STREAM_NAME, $registered = false;
        if (!$registered) {
            $STREAM_NAME = $STREAM_NAME ?: get_cfg_var('rfunc.memory_stream') ?: 'MemoryStreamV010000';
            if (in_array($STREAM_NAME, stream_get_wrappers())) {
                throw new \DomainException("$STREAM_NAME is registered already.");
            }

            $registered = true;
            stream_wrapper_register($STREAM_NAME, get_class(new class()
            {
                private static $entries = [];

                private $entry;
                private $id;
                private $position;
                private $readable;
                private $writable;
                private $appendable;

                public $context;

                private static function create()
                {
                    // @todo time 系は一応用意しているだけでほとんど未実装（read/write のたびに更新する？）
                    $now = time();
                    return (object) [
                        'permission' => 0777 & ~umask(),
                        'owner'      => function_exists('posix_getuid') ? posix_getuid() : 0,
                        'group'      => function_exists('posix_getgid') ? posix_getgid() : 0,
                        'atime'      => $now,
                        'mtime'      => $now,
                        'ctime'      => $now,
                        'content'    => '',
                    ];
                }

                private static function stat($id)
                {
                    $that = self::$entries[$id];
                    return [
                        'dev'     => 0,
                        'ino'     => 0,
                        'mode'    => $that->permission,
                        'nlink'   => 0,
                        'uid'     => $that->owner,
                        'gid'     => $that->group,
                        'rdev'    => 0,
                        'size'    => strlen($that->content),
                        'atime'   => $that->atime,
                        'mtime'   => $that->mtime,
                        'ctime'   => $that->ctime,
                        'blksize' => -1,
                        'blocks'  => -1,
                    ];
                }

                public function __call($name, $arguments)
                {
                    // 対応して無くても標準では警告止まりなので例外に変える
                    throw new \DomainException("$name is not supported.");
                }

                public function stream_open(string $path, string $mode, int $options, &$opened_path): bool
                {
                    assert(is_int($options));
                    assert(!strlen($opened_path));
                    $this->id = parse_url($path, PHP_URL_HOST);

                    // t フラグはクソなので実装しない（デフォルトで b フラグとする）
                    if (strpos($mode, 'r') !== false) {
                        // 普通の fopen でファイルが存在しないとエラーになるので模倣する
                        if (!isset(self::$entries[$this->id])) {
                            throw new \InvalidArgumentException("'$path' is not exist.");
                        }
                        $this->position = 0;
                        $this->readable = true;
                        $this->writable = strpos($mode, '+') !== false;
                        $this->appendable = false;
                    }
                    elseif (strpos($mode, 'w') !== false) {
                        // ファイルポインタをファイルの先頭に置き、ファイルサイズをゼロにします。
                        // ファイルが存在しない場合には、作成を試みます。
                        self::$entries[$this->id] = self::create();
                        $this->position = 0;
                        $this->readable = strpos($mode, '+') !== false;
                        $this->writable = true;
                        $this->appendable = false;
                    }
                    elseif (strpos($mode, 'a') !== false) {
                        // ファイルポインタをファイルの終端に置きます。
                        // ファイルが存在しない場合には、作成を試みます。
                        if (!isset(self::$entries[$this->id])) {
                            self::$entries[$this->id] = self::create();
                        }
                        $this->position = 0;
                        $this->readable = strpos($mode, '+') !== false;
                        $this->writable = true;
                        $this->appendable = true;
                    }
                    elseif (strpos($mode, 'x') !== false) {
                        // ファイルポインタをファイルの先頭に置きます。
                        // ファイルが既に存在する場合には fopen() は失敗し、 E_WARNING レベルのエラーを発行します。
                        // ファイルが存在しない場合には新規作成を試みます。
                        if (isset(self::$entries[$this->id])) {
                            throw new \InvalidArgumentException("'$path' is exist already.");
                        }
                        self::$entries[$this->id] = self::create();
                        $this->position = 0;
                        $this->readable = strpos($mode, '+') !== false;
                        $this->writable = true;
                        $this->appendable = false;
                    }
                    elseif (strpos($mode, 'c') !== false) {
                        // ファイルが存在しない場合には新規作成を試みます。
                        // ファイルが既に存在する場合でもそれを ('w' のように) 切り詰めたりせず、 また ('x' のように) 関数のコールが失敗することもありません。
                        // ファイルポインタをファイルの先頭に置きます。
                        if (!isset(self::$entries[$this->id])) {
                            self::$entries[$this->id] = self::create();
                        }
                        $this->position = 0;
                        $this->readable = strpos($mode, '+') !== false;
                        $this->writable = true;
                        $this->appendable = false;
                    }

                    $this->entry = self::$entries[$this->id];

                    return true;
                }

                public function stream_close()
                {
                }

                public function stream_lock(int $operation): bool
                {
                    assert(is_int($operation));
                    // メモリアクセスは競合しないので常に true を返す
                    return true;
                }

                public function stream_flush(): bool
                {
                    // バッファしないので常に true を返す
                    return true;
                }

                public function stream_eof(): bool
                {
                    return $this->position >= strlen($this->entry->content);
                }

                public function stream_read(int $count): string
                {
                    if (!$this->readable) {
                        return '';
                    }
                    $result = substr($this->entry->content, $this->position, $count);
                    $this->position += strlen($result);
                    return $result;
                }

                public function stream_write(string $data): int
                {
                    if (!$this->writable) {
                        return 0;
                    }
                    $datalen = strlen($data);
                    $posision = $this->position;
                    // このモードは、fseek() では何の効果もありません。書き込みは、常に追記となります。
                    if ($this->appendable) {
                        $posision = strlen($this->entry->content);
                    }
                    // 一般的に、ファイルの終端より先の位置に移動することも許されています。
                    // そこにデータを書き込んだ場合、ファイルの終端からシーク位置までの範囲を読み込むと 値 0 が埋められたバイトを返します。
                    $current = str_pad($this->entry->content, $posision, "\0", STR_PAD_RIGHT);
                    $this->entry->content = substr_replace($current, $data, $posision, $datalen);
                    $this->position += $datalen;
                    return $datalen;
                }

                public function stream_truncate(int $new_size): bool
                {
                    if (!$this->writable) {
                        return false;
                    }
                    $current = substr($this->entry->content, 0, $new_size);
                    $this->entry->content = str_pad($current, $new_size, "\0", STR_PAD_RIGHT);
                    return true;
                }

                public function stream_tell(): int
                {
                    return $this->position;
                }

                public function stream_seek(int $offset, int $whence = SEEK_SET): bool
                {
                    $strlen = strlen($this->entry->content);
                    switch ($whence) {
                        case SEEK_SET:
                            if ($offset < 0) {
                                return false;
                            }
                            $this->position = $offset;
                            break;

                        // stream_tell を定義していると SEEK_CUR が呼ばれない？（計算されて SEEK_SET に移譲されているような気がする）
                        // @codeCoverageIgnoreStart
                        case SEEK_CUR:
                            $this->position += $offset;
                            break;
                        // @codeCoverageIgnoreEnd

                        case SEEK_END:
                            $this->position = $strlen + $offset;
                            break;
                    }
                    // ファイルの終端から数えた位置に移動するには、負の値を offset に渡して whence を SEEK_END に設定しなければなりません。
                    if ($this->position < 0) {
                        $this->position = $strlen + $this->position;
                        if ($this->position < 0) {
                            $this->position = 0;
                            return false;
                        }
                    }
                    return true;
                }

                public function stream_stat()
                {
                    return self::stat($this->id);
                }

                public function stream_metadata($path, $option, $var)
                {
                    $id = parse_url($path, PHP_URL_HOST);
                    switch ($option) {
                        case STREAM_META_TOUCH:
                            if (!isset(self::$entries[$id])) {
                                self::$entries[$id] = self::create();
                            }
                            $mtime = $var[0] ?? time();
                            $atime = $var[1] ?? $mtime;
                            self::$entries[$id]->mtime = $mtime;
                            self::$entries[$id]->atime = $atime;
                            break;

                        case STREAM_META_ACCESS:
                            if (!isset(self::$entries[$id])) {
                                return false;
                            }
                            self::$entries[$id]->permission = $var;
                            self::$entries[$id]->ctime = time();
                            break;

                        /** @noinspection PhpMissingBreakStatementInspection */
                        case STREAM_META_OWNER_NAME:
                            $var = function_exists('posix_getpwnam') ? posix_getpwnam($var)['uid'] : 0;
                        case STREAM_META_OWNER:
                            if (!isset(self::$entries[$id])) {
                                return false;
                            }
                            self::$entries[$id]->owner = $var;
                            self::$entries[$id]->ctime = time();
                            break;

                        /** @noinspection PhpMissingBreakStatementInspection */
                        case STREAM_META_GROUP_NAME:
                            $var = function_exists('posix_getgrnam') ? posix_getgrnam($var)['gid'] : 0;
                        case STREAM_META_GROUP:
                            if (!isset(self::$entries[$id])) {
                                return false;
                            }
                            self::$entries[$id]->group = $var;
                            self::$entries[$id]->ctime = time();
                            break;
                    }
                    // https://qiita.com/hnw/items/3af76d3d7ec2cf52fff8
                    clearstatcache(true, $path);
                    return true;
                }

                public function url_stat(string $path, int $flags)
                {
                    assert(is_int($flags));
                    $id = parse_url($path, PHP_URL_HOST);
                    if (!isset(self::$entries[$id])) {
                        return false;
                    }
                    return self::stat($id);
                }

                public function rename(string $path_from, string $path_to): bool
                {
                    // rename は同じプロトコルじゃないと使えない制約があるのでプロトコルは見ないで OK
                    $id_from = parse_url($path_from, PHP_URL_HOST);
                    if (!isset(self::$entries[$id_from])) {
                        return false;
                    }
                    $id_to = parse_url($path_to, PHP_URL_HOST);
                    self::$entries[$id_to] = self::$entries[$id_from];
                    unset(self::$entries[$id_from]);
                    // https://qiita.com/hnw/items/3af76d3d7ec2cf52fff8
                    clearstatcache(true, $path_from);
                    return true;
                }

                public function unlink(string $path): bool
                {
                    $id = parse_url($path, PHP_URL_HOST);
                    if (!isset(self::$entries[$id])) {
                        return false;
                    }
                    unset(self::$entries[$id]);
                    // もしファイルを作成した場合、 たとえファイルを削除したとしても TRUE を返します。しかし、unlink() はキャッシュを自動的にクリアします。
                    clearstatcache(true, $path);
                    return true;
                }
            }));
        }

        return "$STREAM_NAME://$path";
    }
}
