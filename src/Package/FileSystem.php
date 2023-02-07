<?php

namespace ryunosuke\Functions\Package;

/**
 * ファイルシステム関連のユーティリティ
 */
class FileSystem implements Interfaces\FileSystem
{
    /**
     * 各種属性を指定してファイルのマッチングを行うクロージャを返す
     *
     * ※ 内部向け
     *
     * @param array $filter_condition マッチャーコンディション配列（ソースを参照）
     * @return \Closure ファイルマッチャー
     */
    public static function file_matcher(array $filter_condition)
    {
        $filter_condition += [
            // common
            'dotfile'    => null,  // switch startWith "."
            'unixpath'   => true,  // convert "\\" -> "/"
            'casefold'   => false, // ignore case
            // by getType (string or [string])
            'type'       => null,
            '!type'      => null,
            // by getPerms (int)
            'perms'      => null,
            '!perms'     => null,
            // by getMTime (int or [int, int])
            'mtime'      => null,
            '!mtime'     => null,
            // by getSize (int or [int, int])
            'size'       => null,
            '!size'      => null,
            // by getPathname (glob or regex)
            'path'       => null,
            '!path'      => null,
            // by getPath or getSubpath (glob or regex)
            'dir'        => null,
            '!dir'       => null,
            // by getFilename (glob or regex)
            'name'       => null,
            '!name'      => null,
            // by getExtension (string or [string])
            'extension'  => null,
            '!extension' => null,
            // by contents (string)
            'contains'   => null,
            '!contains'  => null,
            // by custom condition (callable)
            'filter'     => null,
            '!filter'    => null,
        ];

        foreach ([
            'mtime'  => fn(...$args) => Date::date_timestamp(...$args),
            '!mtime' => fn(...$args) => Date::date_timestamp(...$args),
            'size'   => fn(...$args) => Vars::si_unprefix(...$args),
            '!size'  => fn(...$args) => Vars::si_unprefix(...$args),
        ] as $key => $map) {
            if (isset($filter_condition[$key])) {
                $range = $filter_condition[$key];
                if (!is_array($range)) {
                    $range = array_fill_keys([0, 1], $range);
                }
                $range = array_map($map, $range);
                $filter_condition[$key] = static function ($value) use ($range) {
                    return (!isset($range[0]) || $value >= $range[0]) && (!isset($range[1]) || $value <= $range[1]);
                };
            }
        }

        foreach ([
            'type'       => null,
            '!type'      => null,
            'extension'  => null,
            '!extension' => null,
        ] as $key => $map) {
            if (isset($filter_condition[$key])) {
                $array = array_flip((array) $filter_condition[$key]);
                if ($filter_condition['casefold']) {
                    $array = array_change_key_case($array, CASE_LOWER);
                }
                $filter_condition[$key] = static function ($value) use ($array) {
                    return isset($array[$value]);
                };
            }
        }

        foreach ([
            'path'  => null,
            '!path' => null,
            'dir'   => null,
            '!dir'  => null,
            'name'  => null,
            '!name' => null,
        ] as $key => $convert) {
            if (isset($filter_condition[$key])) {
                $pattern = $filter_condition[$key];
                preg_match('##', ''); // clear preg_last_error
                @preg_match($pattern, '');
                if (preg_last_error() === PREG_NO_ERROR) {
                    $filter_condition[$key] = static function ($string) use ($pattern, $filter_condition) {
                        $string = $filter_condition['unixpath'] && DIRECTORY_SEPARATOR === '\\' ? str_replace('\\', '/', $string) : $string;
                        return !!preg_match($pattern, $string);
                    };
                }
                else {
                    $filter_condition[$key] = static function ($string) use ($pattern, $filter_condition) {
                        $string = $filter_condition['unixpath'] && DIRECTORY_SEPARATOR === '\\' ? str_replace('\\', '/', $string) : $string;
                        $flags = 0;
                        $flags |= $filter_condition['casefold'] ? FNM_CASEFOLD : 0;
                        return fnmatch($pattern, $string, $flags);
                    };
                }
            }
        }

        return function ($file) use ($filter_condition) {
            if (!$file instanceof \SplFileInfo) {
                $file = new \SplFileInfo($file);
            }

            if (isset($filter_condition['dotfile']) && !$filter_condition['dotfile'] === (strpos($file->getFilename(), '.') === 0)) {
                return false;
            }

            foreach (['type' => false, '!type' => true] as $key => $cond) {
                if (isset($filter_condition[$key]) && (!file_exists($file->getPathname()) || $cond === $filter_condition[$key]($file->getType()))) {
                    return false;
                }
            }
            foreach (['perms' => false, '!perms' => true] as $key => $cond) {
                if (isset($filter_condition[$key]) && (!file_exists($file->getPathname()) || $cond === !!($filter_condition[$key] & $file->getPerms()))) {
                    return false;
                }
            }
            foreach (['mtime' => false, '!mtime' => true] as $key => $cond) {
                if (isset($filter_condition[$key]) && (!file_exists($file->getPathname()) || $cond === $filter_condition[$key]($file->getMTime()))) {
                    return false;
                }
            }
            foreach (['size' => false, '!size' => true] as $key => $cond) {
                if (isset($filter_condition[$key]) && (!file_exists($file->getPathname()) || $cond === $filter_condition[$key]($file->getSize()))) {
                    return false;
                }
            }
            foreach (['path' => false, '!path' => true] as $key => $cond) {
                if (isset($filter_condition[$key]) && $cond === $filter_condition[$key]($file->getPathname())) {
                    return false;
                }
            }
            foreach (['dir' => false, '!dir' => true] as $key => $cond) {
                $dirname = $file instanceof \RecursiveDirectoryIterator ? $file->getSubPath() : $file->getPath();
                if (isset($filter_condition[$key]) && $cond === $filter_condition[$key]($dirname)) {
                    return false;
                }
            }
            foreach (['name' => false, '!name' => true] as $key => $cond) {
                if (isset($filter_condition[$key]) && $cond === $filter_condition[$key]($file->getFilename())) {
                    return false;
                }
            }
            foreach (['extension' => false, '!extension' => true] as $key => $cond) {
                if (isset($filter_condition[$key]) && $cond === $filter_condition[$key]($file->getExtension())) {
                    return false;
                }
            }
            foreach (['filter' => false, '!filter' => true] as $key => $cond) {
                if (isset($filter_condition[$key]) && $cond === !!$filter_condition[$key]($file)) {
                    return false;
                }
            }
            foreach (['contains' => false, '!contains' => true] as $key => $cond) {
                if (isset($filter_condition[$key]) && (!file_exists($file->getPathname()) || $cond === (FileSystem::file_pos($file->getPathname(), $filter_condition[$key]) !== false))) {
                    return false;
                }
            }

            return true;
        };
    }

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
     * that(file_list($tmp))->equalsCanonicalizing([
     *     "$tmp{$DS}a.txt",
     *     "$tmp{$DS}dir{$DS}b.txt",
     *     "$tmp{$DS}dir{$DS}dir{$DS}c.txt",
     * ]);
     * ```
     *
     * @param string $dirname 調べるディレクトリ名
     * @param array $filter_condition フィルタ条件
     * @return array|false ファイルの配列
     */
    public static function file_list($dirname, $filter_condition = [])
    {
        $dirname = FileSystem::path_normalize($dirname);
        if (!file_exists($dirname)) {
            return false;
        }

        $filter_condition += [
            'recursive' => true,
            'relative'  => false,
            '!type'     => 'dir',
        ];
        $match = FileSystem::file_matcher($filter_condition);

        $rdi = new \RecursiveDirectoryIterator($dirname, \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::KEY_AS_PATHNAME | \FilesystemIterator::CURRENT_AS_SELF);

        if ($filter_condition['recursive']) {
            $iterator = new \RecursiveIteratorIterator($rdi, \RecursiveIteratorIterator::CHILD_FIRST);
        }
        else {
            $iterator = $rdi;
        }

        $result = [];
        foreach ($iterator as $fullpath => $it) {
            if (!$match($it)) {
                continue;
            }

            $result[] = $filter_condition['relative'] ? $it->getSubPathName() : $fullpath;
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
     * that(file_tree($tmp))->is([
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
     * @param array $filter_condition フィルタ条件
     * @return array|false ツリー構造の配列
     */
    public static function file_tree($dirname, $filter_condition = [])
    {
        $dirname = FileSystem::path_normalize($dirname);
        if (!file_exists($dirname)) {
            return false;
        }

        $filter_condition += [
            '!type' => 'dir',
        ];
        $match = FileSystem::file_matcher($filter_condition);

        $basedir = basename($dirname);

        $result = [$basedir => []];
        $items = iterator_to_array(new \FilesystemIterator($dirname, \FilesystemIterator::SKIP_DOTS || \FilesystemIterator::CURRENT_AS_SELF));
        usort($items, function (\SplFileInfo $a, \SplFileInfo $b) {
            if ($a->isDir() xor $b->isDir()) {
                return $a->isDir() - $b->isDir();
            }
            return strcmp($a->getPathname(), $b->getPathname());
        });
        foreach ($items as $item) {
            if ($item->isDir()) {
                $result[$basedir] += FileSystem::file_tree($item->getPathname(), $filter_condition);
            }
            else {
                if ($match($item)) {
                    $result[$basedir][$item->getBasename()] = $item->getPathname();
                }
            }
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
     * that(file_suffix('filename.ext', '-min'))->isSame('filename-min.ext');
     * that(file_suffix('filename.ext1.ext2', '-min'))->isSame('filename-min.ext1.ext2');
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
     * that(file_extension('filename.ext'))->isSame('ext');
     * that(file_extension('filename.ext', 'txt'))->isSame('filename.txt');
     * that(file_extension('filename.ext', ''))->isSame('filename');
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
     * 指定ファイルを拡張子別に php の配列として読み込む
     *
     * 形式は拡張子で自動判別する。
     * その際、2重拡張子で hoge.sjis.csv のように指定するとそのファイルのエンコーディングを指定したことになる。
     *
     * Example:
     * ```php
     * // csv ファイルを読み込んで配列で返す
     * file_put_contents($csvfile = sys_get_temp_dir() . '/hoge.csv', 'a,b,c
     * 1,2,3
     * 4,5,6
     * 7,8,9
     * ');
     * that(file_get_arrays($csvfile))->isSame([
     *     ['a' => '1', 'b' => '2', 'c' => '3'],
     *     ['a' => '4', 'b' => '5', 'c' => '6'],
     *     ['a' => '7', 'b' => '8', 'c' => '9'],
     * ]);
     *
     * // sjis の json ファイルを読み込んで配列で返す
     * file_put_contents($jsonfile = sys_get_temp_dir() . '/hoge.sjis.json', '[
     * {"a": 1, "b": 2, "c": 3},
     * {"a": 4, "b": 5, "c": 6},
     * {"a": 7, "b": 8, "c": 9}
     * ]');
     * that(file_get_arrays($jsonfile))->isSame([
     *     ['a' => 1, 'b' => 2, 'c' => 3],
     *     ['a' => 4, 'b' => 5, 'c' => 6],
     *     ['a' => 7, 'b' => 8, 'c' => 9],
     * ]);
     * ```
     *
     * @param string $filename 読み込むファイル名
     * @param array $options 各種オプション
     * @return array レコード配列
     */
    public static function file_get_arrays($filename, $options = [])
    {
        static $supported_encodings = null;
        if ($supported_encodings === null) {
            $supported_encodings = array_combine(array_map('strtolower', mb_list_encodings()), mb_list_encodings());
        }

        if (!file_exists($filename)) {
            throw new \InvalidArgumentException("$filename is not exists");
        }

        $internal_encoding = mb_internal_encoding();
        $mb_convert_encoding = function ($encoding, $contents) use ($internal_encoding) {
            if ($encoding !== $internal_encoding) {
                $contents = mb_convert_encoding($contents, $internal_encoding, $encoding);
            }
            return $contents;
        };

        $pathinfo = pathinfo($filename);
        $encoding = pathinfo($pathinfo['filename'], PATHINFO_EXTENSION);
        $encoding = $supported_encodings[strtolower($encoding)] ?? $internal_encoding;
        $extension = $pathinfo['extension'] ?? '';

        switch (strtolower($extension)) {
            default:
                throw new \InvalidArgumentException("ext '$extension' is not supported.");
            case 'php':
                return (array) require $filename;
            case 'csv':
                return (array) Strings::csv_import($mb_convert_encoding($encoding, file_get_contents($filename)), $options + ['structure' => true]);
            case 'json':
            case 'json5':
                return (array) Strings::json_import($mb_convert_encoding($encoding, file_get_contents($filename)), $options);
            case 'jsonl':
            case 'jsonl5':
                return (array) array_map(fn($json) => Strings::json_import($json, $options), $mb_convert_encoding($encoding, array_filter(file($filename, FILE_IGNORE_NEW_LINES), 'strlen')));
            case 'yml':
            case 'yaml':
                return (array) yaml_parse($mb_convert_encoding($encoding, file_get_contents($filename)), 0, $ndocs, $options);
            case 'xml':
                throw new \DomainException("ext '$extension' is supported in the future.");
            case 'ltsv':
                return (array) array_map(fn($ltsv) => Strings::ltsv_import($ltsv, $options), $mb_convert_encoding($encoding, array_filter(file($filename, FILE_IGNORE_NEW_LINES), 'strlen')));
        }
    }

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

        $filename = FileSystem::path_normalize($filename);

        if (!is_dir($dirname = dirname($filename))) {
            if (!@FileSystem::mkdir_p($dirname, $umask)) {
                throw new \RuntimeException("failed to mkdir($dirname)");
            }
        }

        error_clear_last();
        $tempnam = @tempnam($dirname, 'tmp');
        if (strpos(error_get_last()['message'] ?? '', "file created in the system's temporary directory") !== false) {
            $result = file_put_contents($filename, $data);
            @chmod($filename, 0666 & ~$umask);
            return $result;
        }
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
     * file_rewrite_contents($testpath, fn($contents, $fp) => "pre-$contents-fix");
     * that($testpath)->fileEquals('pre-hoge-fix');
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
            $fp = fopen($filename, 'c+b') ?: Syntax::throws(new \UnexpectedValueException('failed to fopen.'));
            if ($operation) {
                flock($fp, $operation) ?: Syntax::throws(new \UnexpectedValueException('failed to flock.'));
            }

            // 読み込んで
            rewind($fp) ?: Syntax::throws(new \UnexpectedValueException('failed to rewind.'));
            $contents = false !== ($t = stream_get_contents($fp)) ? $t : Syntax::throws(new \UnexpectedValueException('failed to stream_get_contents.'));

            // 変更して
            rewind($fp) ?: Syntax::throws(new \UnexpectedValueException('failed to rewind.'));
            ftruncate($fp, 0) ?: Syntax::throws(new \UnexpectedValueException('failed to ftruncate.'));
            $contents = $callback($contents, $fp);

            // 書き込んで
            $return = ($r = fwrite($fp, $contents)) !== false ? $r : Syntax::throws(new \UnexpectedValueException('failed to fwrite.'));
            fflush($fp) ?: Syntax::throws(new \UnexpectedValueException('failed to fflush.'));

            // 閉じて
            if ($operation) {
                flock($fp, LOCK_UN) ?: Syntax::throws(new \UnexpectedValueException('failed to flock.'));
            }
            fclose($fp) ?: Syntax::throws(new \UnexpectedValueException('failed to fclose.'));

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
     * ツリー構造で file_set_contents する
     *
     * 値が配列の場合はディレクトリ、それ以外の場合はファイルとなる。
     * 値がクロージャーの場合はコールされる。
     * 返り値として書き込んだバイト数のフルパス配列を返す。
     *
     * Example:
     * ```php
     * // 一時ディレクトリにツリー構造でファイルを配置する
     * $root = sys_get_temp_dir();
     * file_set_tree($root, [
     *     'hoge.txt' => 'HOGE',
     *     'dir1' => [
     *         'fuga.txt' => 'FUGA',
     *         'dir2'     => [
     *             'piyo.txt' => 'PIYO',
     *         ],
     *     ],
     * ]);
     * that("$root/hoge.txt")->fileEquals('HOGE');
     * that("$root/dir1/fuga.txt")->fileEquals('FUGA');
     * that("$root/dir1/dir2/piyo.txt")->fileEquals('PIYO');
     * ```
     *
     * @param string $root ルートパス
     * @param array $contents_tree コンテンツツリー
     * @param int $umask umask
     * @return array 書き込まれたバイト数配列
     */
    public static function file_set_tree($root, $contents_tree, $umask = 0002)
    {
        if (func_num_args() === 2) {
            $umask = umask();
        }

        $result = [];
        foreach ($contents_tree as $basename => $entry) {
            $fullpath = $root . DIRECTORY_SEPARATOR . $basename;
            if ($entry instanceof \Closure) {
                $entry = $entry($fullpath, $root, $basename);
            }

            if (is_array($entry)) {
                FileSystem::mkdir_p($fullpath, $umask);
                $result += FileSystem::file_set_tree($fullpath, $entry, $umask);
            }
            else {
                $byte = FileSystem::file_set_contents($fullpath, $entry, $umask);
                $result[FileSystem::path_normalize($fullpath)] = $byte;
            }
        }
        return $result;
    }

    /**
     * 範囲指定でファイルを読んで位置を返す
     *
     * $needle に配列を与えると OR 的動作で一つでも見つかった時点の位置を返す。
     * このとき「どれが見つかったか？」は得られない（場合によっては不便なので将来の改修対象）。
     *
     * Example:
     * ```php
     * // 適当にファイルを用意
     * $testpath = sys_get_temp_dir() . '/file_pos.txt';
     * file_put_contents($testpath, "hoge\nfuga\npiyo\nfuga");
     * // fuga の位置を返す
     * that(file_pos($testpath, 'fuga'))->is(5);
     * // 2つ目の fuga の位置を返す
     * that(file_pos($testpath, 'fuga', 6))->is(15);
     * // 見つからない場合は false を返す
     * that(file_pos($testpath, 'hogera'))->is(false);
     * ```
     *
     * @param string $filename ファイル名
     * @param string|array $needle 探す文字列
     * @param int $start 読み込み位置
     * @param int|null $end 読み込むまでの位置。省略時は指定なし（最後まで）。負数は後ろからのインデックス
     * @param int|null $chunksize 読み込みチャンクサイズ。省略時は 4096 の倍数に正規化
     * @return int|false $needle の位置。見つからなかった場合は false
     */
    public static function file_pos($filename, $needle, $start = 0, $end = null, $chunksize = null)
    {
        if (!is_file($filename)) {
            throw new \InvalidArgumentException("'$filename' is not found.");
        }

        $needle = Vars::arrayval($needle, false);
        $maxlength = max(array_map('strlen', $needle));

        if ($start < 0) {
            $start += $filesize ?? $filesize = filesize($filename);
        }
        if ($end === null) {
            $end = $filesize ?? $filesize = filesize($filename);
        }
        if ($end < 0) {
            $end += $filesize ?? $filesize = filesize($filename);
        }
        if ($chunksize === null) {
            $chunksize = 4096 * ($maxlength % 4096 + 1);
        }

        assert(isset($filesize) || !isset($filesize));
        assert($chunksize >= $maxlength);

        $fp = fopen($filename, 'rb');
        try {
            fseek($fp, $start);
            while (!feof($fp)) {
                if ($start > $end) {
                    break;
                }
                $last = $part ?? '';
                $part = fread($fp, $chunksize);
                if (($p = Strings::strpos_array($part, $needle))) {
                    $min = min($p);
                    $result = $start + $min;
                    return $result + strlen($needle[array_flip($p)[$min]]) > $end ? false : $result;
                }
                if (($p = Strings::strpos_array($last . $part, $needle))) {
                    $min = min($p);
                    $result = $start + $min - strlen($last);
                    return $result + strlen($needle[array_flip($p)[$min]]) > $end ? false : $result;
                }
                $start += strlen($part);
            }
            return false;
        }
        finally {
            fclose($fp);
        }
    }

    /**
     * file の行範囲を指定できる板
     *
     * 原則 file をベースに作成しているが、一部独自仕様がある。
     *
     * - 結果配列は行番号がキーになる
     *   - あくまで行番号なので 1 オリジン
     *   - スキップされた行は歯抜けになる
     * - FILE_SKIP_EMPTY_LINES の動作が FILE_IGNORE_NEW_LINES ありきではない
     *   - file における FILE_SKIP_EMPTY_LINES の単独指定は意味を成さないっぽい
     *     - FILE_IGNORE_NEW_LINES しないと空文字ではなく改行文字が含まれるので空判定にならないようだ
     *   - この関数はその動作を撤廃しており、単独で FILE_SKIP_EMPTY_LINES を指定しても空行が飛ばされる動作になっている
     * - $end_line に負数を指定すると行番号の直指定となる
     *   - `file_slice($filename, 120, -150)` で 120行目から150行目までを読む
     *   - 負数なのは気持ち悪いが、範囲指定のハイフン（120-150）だと思えば割と自然
     *
     * 使用用途としては
     *
     * 1. 巨大ファイルの前半だけ読みたい
     * 2. 1行だけサクッと読みたい
     *
     * が挙げられる。
     *
     * 1 は自明（file は全行読む）だが、終端付近を読む場合は file の方が若干速い。
     * ただし、期待値としてはこの関数の方が格段に低い（file は下手すると何十倍も遅い）。
     *
     * 2 は典型的には「1行目だけ読みたい」場合、fopen+fgets+fclose(finally)という手順を踏む必要があり煩雑になる。
     * この関数を使えばサクッと取得することができる。
     *
     * Example:
     * ```php
     * // 適当にファイルを用意（奇数行は行番号、偶数行は空行）
     * $testpath = sys_get_temp_dir() . '/file_slice.txt';
     * file_put_contents($testpath, implode("\n", array_map(fn($n) => $n % 2 ? $n : "", range(1, 20))));
     * // 3行目から4行を返す
     * that(file_slice($testpath, 3, 4))->is([
     *     3 => "3\n",
     *     4 => "\n",
     *     5 => "5\n",
     *     6 => "\n",
     * ]);
     * // 3行目から6行目までを返す
     * that(file_slice($testpath, 3, -6))->is([
     *     3 => "3\n",
     *     4 => "\n",
     *     5 => "5\n",
     *     6 => "\n",
     * ]);
     * // 改行文字や空行を含めない（キーは保持される）
     * that(file_slice($testpath, 3, 4, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES))->is([
     *     3 => "3",
     *     5 => "5",
     * ]);
     * ```
     *
     * @param string $filename ファイル名
     * @param int $start_line 開始行。1 オリジン
     * @param ?int $length 終了行。null を指定すると最後まで読む。負数にすると行番号直指定になる
     * @param int $flags file と同じフラグ定数（FILE_IGNORE_NEW_LINES, etc）
     * @param ?resource $context file と同じ context 指定
     * @return array 部分行
     */
    public static function file_slice($filename, $start_line = 1, $length = null, $flags = 0, $context = null)
    {
        $FILE_USE_INCLUDE_PATH = !!($flags & FILE_USE_INCLUDE_PATH);
        $FILE_IGNORE_NEW_LINES = !!($flags & FILE_IGNORE_NEW_LINES);
        $FILE_SKIP_EMPTY_LINES = !!($flags & FILE_SKIP_EMPTY_LINES);

        assert($start_line > 0, '$start_line must be positive number. because it means line number.');

        if ($length === null) {
            $end_line = null;
        }
        elseif ($length > 0) {
            $end_line = $start_line + $length;
        }
        elseif ($length < 0) {
            $end_line = -$length + 1;
        }

        $fp = fopen($filename, 'r', $FILE_USE_INCLUDE_PATH, $context);
        try {
            $result = [];
            for ($i = 1; ($line = fgets($fp)) !== false; $i++) {
                if (isset($end_line) && $i >= $end_line) {
                    break;
                }
                if ($i >= $start_line) {
                    if ($FILE_IGNORE_NEW_LINES) {
                        $line = rtrim($line);
                    }
                    if ($FILE_SKIP_EMPTY_LINES && trim($line) === '') {
                        continue;
                    }
                    $result[$i] = $line;
                }
            }
            return $result;
        }
        finally {
            fclose($fp);
        }
    }

    /**
     * ファイルの mimetype を返す
     *
     * mime_content_type の http 対応版。
     * 変更点は下記。
     *
     * - http(s) に対応（HEAD メソッドで取得する）
     * - 失敗時に false ではなく null を返す
     *
     * Example:
     * ```php
     * that(file_mimetype(__FILE__))->is('text/x-php');
     * that(file_mimetype('http://httpbin.org/get?name=value'))->is('application/json');
     * ```
     *
     * @param string $filename ファイル名（URL）
     * @return string|null MIME タイプ
     */
    public static function file_mimetype($filename)
    {
        $scheme = parse_url($filename, PHP_URL_SCHEME) ?? null;
        switch (strtolower($scheme)) {
            default:
            case 'file':
                return mime_content_type($filename) ?: null;

            case 'http':
            case 'https':
                $r = $c = [];
                Network::http_head($filename, [], ['throw' => false], $r, $c);
                if ($c['http_code'] === 200) {
                    return $c['content_type'] ?? null;
                }
                trigger_error("HEAD $filename {$c['http_code']}", E_USER_WARNING);
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
     * $callback = fn($path) => realpath("$path/file.txt");
     * that(dirname_r("$tmp/a/b/c/d/e/f", $callback))->isSame(realpath("$tmp/a/b/file.txt"));
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
        return FileSystem::dirname_r($dirname, $callback);
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
     * that(dirmtime($dirname))->isBetween(time() - 2, time());
     * // ファイルを作って更新するとその時刻
     * touch("$dirname/tmp", time() + 10);
     * that(dirmtime($dirname))->isSame(time() + 10);
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
                $mtime = max($mtime, FileSystem::dirmtime($path->getPathname(), $recursive));
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
     * that(fnmatch_and(['*aaa*', '*bbb*'], 'aaaXbbbX'))->isTrue();
     * // aaa にはマッチするが bbb にはマッチしないので false
     * that(fnmatch_and(['*aaa*', '*bbb*'], 'aaaX'))->isFalse();
     * ```
     *
     * @param array|string $patterns パターン配列（単一文字列可）
     * @param string $string 調べる文字列
     * @param int $flags FNM_***
     * @return bool すべてにマッチしたら true
     */
    public static function fnmatch_and($patterns, $string, $flags = 0)
    {
        $patterns = is_iterable($patterns) ? $patterns : [$patterns];
        if (Vars::is_empty($patterns)) {
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
     * that(fnmatch_or(['*aaa*', '*bbb*'], 'aaaX'))->isTrue();
     * // どれともマッチしないので false
     * that(fnmatch_or(['*aaa*', '*bbb*'], 'cccX'))->isFalse();
     * ```
     *
     * @param array|string $patterns パターン配列（単一文字列可）
     * @param string $string 調べる文字列
     * @param int $flags FNM_***
     * @return bool どれかにマッチしたら true
     */
    public static function fnmatch_or($patterns, $string, $flags = 0)
    {
        $patterns = is_iterable($patterns) ? $patterns : [$patterns];
        if (Vars::is_empty($patterns)) {
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
     * that(path_is_absolute('/absolute/path'))->isTrue();
     * that(path_is_absolute('relative/path'))->isFalse();
     * // Windows 環境では下記も true になる
     * if (DIRECTORY_SEPARATOR === '\\') {
     *     that(path_is_absolute('\\absolute\\path'))->isTrue();
     *     that(path_is_absolute('C:\\absolute\\path'))->isTrue();
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
     * 出来上がったパスが絶対パスでない場合は PATH 環境変数を使用して解決を試みる。
     *
     * 歴史的な理由により最後の引数を配列にするとその候補と PATH からの解決を試みる。
     * 解決できなかった場合 null を返す。
     * 配列を指定しなかった場合はカレントディレクトリを結合して返す。
     *
     * Example:
     * ```php
     * $DS = DIRECTORY_SEPARATOR;
     * that(path_resolve('/absolute/path'))->isSame("{$DS}absolute{$DS}path");
     * that(path_resolve('absolute/path'))->isSame(getcwd() . "{$DS}absolute{$DS}path");
     * that(path_resolve('/absolute/path/through', '../current/./path'))->isSame("{$DS}absolute{$DS}path{$DS}current{$DS}path");
     *
     * # 最後の引数に配列を与えるとそのパスと PATH から解決を試みる（要するに which 的な動作になる）
     * if ($DS === '/') {
     *     that(path_resolve('php', []))->isSame(PHP_BINARY);
     * }
     * ```
     *
     * @param string|array ...$paths パス文字列（可変引数）
     * @return ?string 絶対パス
     */
    public static function path_resolve(...$paths)
    {
        $resolver = [];
        if (is_array($paths[count($paths) - 1] ?? '')) {
            $resolver = array_pop($paths);
            $resolver[] = getenv('PATH');
        }

        $DS = DIRECTORY_SEPARATOR;

        $path = implode($DS, $paths);

        if (!FileSystem::path_is_absolute($path)) {
            if ($resolver) {
                foreach ($resolver as $p) {
                    foreach (explode(PATH_SEPARATOR, $p) as $dir) {
                        if (file_exists("$dir/$path")) {
                            return FileSystem::path_normalize("$dir/$path");
                        }
                    }
                }
                return null;
            }
            else {
                $path = getcwd() . $DS . $path;
            }
        }

        return FileSystem::path_normalize($path);
    }

    /**
     * パスを相対パスに変換して正規化する
     *
     * $from から $to への相対パスを返す。
     *
     * Example:
     * ```php
     * $DS = DIRECTORY_SEPARATOR;
     * that(path_relative('/a/b/c/X', '/a/b/c/d/X'))->isSame("..{$DS}d{$DS}X");
     * that(path_relative('/a/b/c/d/X', '/a/b/c/X'))->isSame("..{$DS}..{$DS}X");
     * that(path_relative('/a/b/c/X', '/a/b/c/X'))->isSame("");
     * ```
     *
     * @param string $from 元パス
     * @param string $to 対象パス
     * @return string 相対パス
     */
    public static function path_relative($from, $to)
    {
        $DS = DIRECTORY_SEPARATOR;

        $fa = array_filter(explode($DS, FileSystem::path_resolve($from)), 'strlen');
        $ta = array_filter(explode($DS, FileSystem::path_resolve($to)), 'strlen');

        $compare = fn($a, $b) => $DS === '\\' ? strcasecmp($a, $b) : strcmp($a, $b);
        $ca = array_udiff_assoc($fa, $ta, $compare);
        $da = array_udiff_assoc($ta, $fa, $compare);

        return str_repeat("..$DS", count($ca)) . implode($DS, $da);
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
     * that(path_normalize('/path/to/something'))->isSame("{$DS}path{$DS}to{$DS}something");
     * that(path_normalize('/path/through/../something'))->isSame("{$DS}path{$DS}something");
     * that(path_normalize('./path/current/./through/../something'))->isSame("path{$DS}current{$DS}something");
     * ```
     *
     * @param string $path パス文字列
     * @return string 正規化されたパス
     */
    public static function path_normalize($path)
    {
        $DS = DIRECTORY_SEPARATOR;

        // スキームの保護
        $with_scheme = false;
        $scheme = parse_url($path, PHP_URL_SCHEME);
        if (!($scheme === null || $scheme === 'file') && substr($path, strlen($scheme), 3) === '://') {
            $path = substr($path, strlen($scheme) + 3);
            $DS = '/';
            $with_scheme = true;
        }

        $delimiter = '/';
        if ($DS === '\\') {
            $delimiter .= '\\\\';
        }

        $result = [];
        foreach (preg_split("#[$delimiter]+#u", $path) as $part) {
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
        if (count($result) > 2 && $result[count($result) - 1] === '') {
            array_pop($result);
        }

        $path = implode($DS, $result);

        if ($with_scheme) {
            $path = "$scheme://$path";
        }

        return $path;
    }

    /**
     * パスをパースする
     *
     * pathinfo の（ほぼ）上位互換で下記の差異がある。
     *
     * - パスは正規化される
     * - $flags 引数はない（指定した各部だけを返すことはできない）
     * - 要素が未設定になることはない（例えば extension は拡張子がなくても明示的に null が入る）
     *
     * 更に独自で下記のキーを返す。
     *
     * - dirlocalname: 親ディレクトリと localname の結合（≒フルパスから複数拡張子を除いたもの）
     * - localname: 複数拡張子を除いた filename
     * - extensions: 複数拡張子を配列で返す（拡張子がない場合は空配列）
     *
     * Example:
     * ```php
     * $DS = DIRECTORY_SEPARATOR;
     * that(path_parse('/path/to/file.min.css'))->isSame([
     *     'dirname'      => "{$DS}path{$DS}to",
     *     'basename'     => "file.min.css",
     *     'filename'     => "file.min",
     *     'extension'    => "css",
     *     // ここまでは（正規化はされるが） pathinfo と同じ
     *     // ここからは独自のキー
     *     'dirlocalname' => "{$DS}path{$DS}to{$DS}file",
     *     'localname'    => "file",
     *     'extensions'   => ["min", "css"],
     * ]);
     * ```
     *
     * @param string $path パス文字列
     * @return array パスパーツ
     */
    public static function path_parse($path)
    {
        // dirname や extension など、キーの有無が分岐するのは使いにくいことこの上ないのでまずすべて null で埋める
        $pathinfo = array_replace([
            'dirname'   => null,
            'basename'  => null,
            'filename'  => null,
            'extension' => null,
        ], pathinfo(FileSystem::path_normalize($path)));

        $localname = $pathinfo['filename'];
        $extensions = (array) $pathinfo['extension'];

        while ((($info = pathinfo($localname))['extension'] ?? null) !== null) {
            $localname = $info['filename'];
            array_unshift($extensions, $info['extension']);
        }

        return [
            'dirname'      => FileSystem::path_normalize($pathinfo['dirname'] ?? ''),
            'basename'     => $pathinfo['basename'],
            'filename'     => $pathinfo['filename'],
            'extension'    => $pathinfo['extension'],
            'dirlocalname' => FileSystem::path_normalize(($pathinfo['dirname'] ?? '') . "/$localname"),
            'localname'    => $localname,
            'extensions'   => $extensions,
        ];
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
     * that("$tmp/dst1/hoge.txt")->fileEquals('hoge');
     * that("$tmp/dst1/dir/fuga.txt")->fileEquals('fuga');
     * // "/" を付けると自身コピー
     * cp_rf("$tmp/src", "$tmp/dst2/");
     * that("$tmp/dst2/src/hoge.txt")->fileEquals('hoge');
     * that("$tmp/dst2/src/dir/fuga.txt")->fileEquals('fuga');
     *
     * // $src はファイルでもいい（$dst に "/" を付けるとそのディレクトリにコピーする）
     * cp_rf("$tmp/src/hoge.txt", "$tmp/dst3/");
     * that("$tmp/dst3/hoge.txt")->fileEquals('hoge');
     * // $dst に "/" を付けないとそのパスとしてコピー（copy と完全に同じ）
     * cp_rf("$tmp/src/hoge.txt", "$tmp/dst4");
     * that("$tmp/dst4")->fileEquals('hoge');
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
                FileSystem::mkdir_p($dst);
                return copy($src, $dst . basename($src));
            }
            else {
                FileSystem::mkdir_p(dirname($dst));
                return copy($src, $dst);
            }
        }

        if ($dirmode) {
            return FileSystem::cp_rf($src, $dst . basename($src));
        }

        FileSystem::mkdir_p($dst);

        foreach (glob("$src/*") as $file) {
            if (is_dir($file)) {
                FileSystem::cp_rf($file, "$dst/" . basename($file));
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
     * that(file_exists(sys_get_temp_dir() . '/new'))->isSame(false);
     * ```
     *
     * @param string $dirname 削除するディレクトリ名。glob パターンが使える
     * @param bool $self 自分自身も含めるか。false を与えると中身だけを消す
     * @return bool 成功した場合に TRUE を、失敗した場合に FALSE を返します
     */
    public static function rm_rf($dirname, $self = true)
    {
        $main = static function ($dirname, $self) {
            if (!file_exists($dirname)) {
                return false;
            }

            $rdi = new \RecursiveDirectoryIterator($dirname, \FilesystemIterator::SKIP_DOTS);
            $rii = new \RecursiveIteratorIterator($rdi, \RecursiveIteratorIterator::CHILD_FIRST);

            foreach ($rii as $it) {
                if ($it->isFile() || $it->isLink()) {
                    unlink($it->getPathname());
                }
                else {
                    rmdir($it->getPathname());
                }
            }

            return !$self || rmdir($dirname);
        };

        $result = true;
        $targets = glob($dirname, GLOB_BRACE | GLOB_NOCHECK | ($self ? 0 : GLOB_ONLYDIR));
        foreach ($targets as $target) {
            $result = $main($target, $self) && $result;
        }
        return $result;
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
     * @param ?string $dir 生成ディレクトリ。省略時は sys_get_temp_dir()
     * @return string 一時ファイル名
     */
    public static function tmpname($prefix = 'rft', $dir = null)
    {
        // デフォルト付きで tempnam を呼ぶ
        $dir = $dir ?: Utility::function_configure('cachedir');
        $tempfile = tempnam($dir, $prefix);

        // tempnam が何をしても false を返してくれないんだがどうしたら返してくれるんだろうか？
        if ($tempfile === false) {
            throw new \UnexpectedValueException("tmpname($dir, $prefix) failed.");// @codeCoverageIgnore
        }

        // 生成したファイルを覚えておいて最後に消す
        static $files = [];
        $files[$tempfile] = new class($tempfile) {
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
     * 初回読み込み時から変更のあったファイル配列を返す
     *
     * 初回呼び出し時は必ず空配列を返し、以後の呼び出しで変更のあったファイルを返す。
     * 削除されたファイルも変更とみなす。
     *
     * 用途的には「php で書かれたデーモンで、変更感知して自動で再起動する（systemd に任せる）」がある。
     *
     * Example:
     * ```php
     * // 別プロセスで3秒後に自分自身を触る
     * $p = process_async(PHP_BINARY, ['-r' => 'sleep(3);touch($argv[1]);', __FILE__]);
     *
     * $time = microtime(true);
     * foreach (range(1, 10) as $i) {
     *     // 何らかのデーモン（完全に wait する系ではなく時々処理が戻ってくる必要がある）
     *     sleep(1);
     *
     *     // 自身の変更を感知したら break なり exit なりで抜ける（大抵はそのまま終了する。起動は systemd に丸投げする）
     *     if (get_modified_files(__FILE__)) {
     *         break;
     *     }
     * }
     * // 全ループすると10秒かかるが、大体3秒程度で抜けているはず
     * that(microtime(true) - $time)->lt(3.9);
     * unset($p);
     * ```
     *
     * @param string|array $target_pattern 対象ファイルパターン（マッチしないものは無視される）
     * @param string|array $ignore_pattern 除外ファイルパターン（マッチしたものは無視される）
     * @return array 変更のあったファイル名配列
     */
    public static function get_modified_files($target_pattern = '*.php', $ignore_pattern = '*.phtml')
    {
        static $file_mtimes = [];

        $modified = [];
        foreach (get_included_files() as $filename) {
            $mtime = file_exists($filename) ? filemtime($filename) : time();

            // 対象外でも引数違いの呼び出しのために入れておかなければならない
            if (!FileSystem::fnmatch_or($target_pattern, $filename, FNM_NOESCAPE) || FileSystem::fnmatch_or($ignore_pattern, $filename, FNM_NOESCAPE)) {
                $file_mtimes[$filename] ??= $mtime;
                continue;
            }

            if (!isset($file_mtimes[$filename])) {
                $file_mtimes[$filename] = $mtime;
            }
            elseif ($mtime > $file_mtimes[$filename]) {
                $modified[] = $filename;
            }
        }

        return $modified;
    }

    /**
     * ファイルのように扱えるメモリ上のパスを返す
     *
     * 劣化 vfsStream のようなもの。
     * stream wrapper を用いて実装しており、そのプロトコルは初回呼び出し時に1度だけ登録される。
     * プロトコル名は決め打ちだが、 php.ini に "rfunc.memory_stream" というキーで文字列を指定するとそれが使用される。
     *
     * Example:
     * ```php
     * // ファイル名のように読み書きができるパスを返す（一時ファイルを使用するよりかなり高速に動作する）
     * $memory_path = memory_path('filename.txt');
     * // 呼んだだけでは何もしないので存在しない
     * that(file_exists($memory_path))->isSame(false);
     * // file_put_contents が使える
     * that(file_put_contents($memory_path, 'Hello, World'))->isSame(12);
     * // file_get_contents が使える
     * that(file_get_contents($memory_path))->isSame('Hello, World');
     * // 上記の操作で実体が存在している
     * that(file_exists($memory_path))->isSame(true);
     * // unlink が使える
     * that(unlink($memory_path))->isSame(true);
     * // unlink したので存在しない
     * that(file_exists($memory_path))->isSame(false);
     * ```
     *
     * @param string $path パス名（実質的に一意なファイル名）
     * @return string メモリ上のパス
     */
    public static function memory_path($path = '')
    {
        static $STREAM_NAME, $registered = false;
        if (!$registered) {
            $STREAM_NAME = $STREAM_NAME ?: Utility::function_configure('memory_stream');
            if (in_array($STREAM_NAME, stream_get_wrappers())) {
                throw new \DomainException("$STREAM_NAME is registered already.");
            }

            $registered = true;
            stream_wrapper_register($STREAM_NAME, get_class(new class() {
                private static $entries = [];

                private $entry;
                private $id;
                private $position;
                private $appendable;

                public $context;

                private static function id($path)
                {
                    $parts = parse_url($path) ?: [];
                    $id = ($parts['host'] ?? '') . ($parts['path'] ?? '');
                    $id = strtr($id, ['\\' => '/']);
                    return rtrim($id, '/');
                }

                private static function create($id, $mode)
                {
                    // @todo time 系は一応用意しているだけでほとんど未実装（read/write のたびに更新する？）
                    $now = time();
                    self::$entries[$id] = (object) [
                        'mode'    => $mode | (0777 & ~umask()),
                        'owner'   => function_exists('posix_getuid') ? posix_getuid() : 0,
                        'group'   => function_exists('posix_getgid') ? posix_getgid() : 0,
                        'atime'   => $now,
                        'mtime'   => $now,
                        'ctime'   => $now,
                        'content' => '',
                    ];
                }

                private static function stat($id)
                {
                    $that = self::$entries[$id];
                    return [
                        'dev'     => 0,
                        'ino'     => 0,
                        'mode'    => $that->mode,
                        'nlink'   => 0,
                        'uid'     => $that->owner,
                        'gid'     => $that->group,
                        'rdev'    => 0,
                        'size'    => array_reduce((array) $that->content, fn($carry, $item) => $carry + strlen($item), 0),
                        'atime'   => $that->atime,
                        'mtime'   => $that->mtime,
                        'ctime'   => $that->ctime,
                        'blksize' => -1,
                        'blocks'  => -1,
                    ];
                }

                /** @noinspection PhpUnusedParameterInspection */
                public function stream_set_option(int $option, int $arg1, int $arg2)
                {
                    return false;
                }

                public function stream_open(string $path, string $mode, int $options, &$opened_path): bool
                {
                    assert(is_int($options));
                    assert(is_null($opened_path) || !strlen($opened_path));
                    $this->id = self::id($path);

                    // t フラグはクソなので実装しない（デフォルトで b フラグとする）
                    if (strpos($mode, 'r') !== false) {
                        // 普通の fopen でファイルが存在しないとエラーになるので模倣する
                        if (!isset(self::$entries[$this->id])) {
                            throw new \InvalidArgumentException("'$path' is not exist.");
                        }
                        $this->position = 0;
                        $this->appendable = false;
                    }
                    elseif (strpos($mode, 'w') !== false) {
                        // ファイルポインタをファイルの先頭に置き、ファイルサイズをゼロにします。
                        // ファイルが存在しない場合には、作成を試みます。
                        self::create($this->id, 010_0000);
                        $this->position = 0;
                        $this->appendable = false;
                    }
                    elseif (strpos($mode, 'a') !== false) {
                        // ファイルポインタをファイルの終端に置きます。
                        // ファイルが存在しない場合には、作成を試みます。
                        if (!isset(self::$entries[$this->id])) {
                            self::create($this->id, 010_0000);
                        }
                        $this->position = 0;
                        $this->appendable = true;
                    }
                    elseif (strpos($mode, 'x') !== false) {
                        // ファイルポインタをファイルの先頭に置きます。
                        // ファイルが既に存在する場合には fopen() は失敗し、 E_WARNING レベルのエラーを発行します。
                        // ファイルが存在しない場合には新規作成を試みます。
                        if (isset(self::$entries[$this->id])) {
                            throw new \InvalidArgumentException("'$path' is exist already.");
                        }
                        self::create($this->id, 010_0000);
                        $this->position = 0;
                        $this->appendable = false;
                    }
                    elseif (strpos($mode, 'c') !== false) {
                        // ファイルが存在しない場合には新規作成を試みます。
                        // ファイルが既に存在する場合でもそれを ('w' のように) 切り詰めたりせず、 また ('x' のように) 関数のコールが失敗することもありません。
                        // ファイルポインタをファイルの先頭に置きます。
                        if (!isset(self::$entries[$this->id])) {
                            self::create($this->id, 010_0000);
                        }
                        $this->position = 0;
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
                    $result = substr($this->entry->content, $this->position, $count);
                    $this->position += strlen($result);
                    return $result;
                }

                public function stream_write(string $data): int
                {
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
                    $id = self::id($path);
                    switch ($option) {
                        case STREAM_META_TOUCH:
                            if (!isset(self::$entries[$id])) {
                                self::create($id, 010_0000);
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
                            self::$entries[$id]->mode &= 077_0000;
                            self::$entries[$id]->mode |= $var & ~umask();
                            self::$entries[$id]->ctime = time();
                            break;

                        /** @noinspection PhpMissingBreakStatementInspection */
                        case STREAM_META_OWNER_NAME:
                            $nam = function_exists('posix_getpwnam') ? posix_getpwnam($var) : [];
                            $var = $nam['uid'] ?? 0;
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
                    $id = self::id($path);
                    if (!isset(self::$entries[$id])) {
                        return false;
                    }
                    return self::stat($id);
                }

                public function rename(string $path_from, string $path_to): bool
                {
                    // rename は同じプロトコルじゃないと使えない制約があるのでプロトコルは見ないで OK
                    $id_from = self::id($path_from);
                    if (!isset(self::$entries[$id_from])) {
                        return false;
                    }
                    $id_to = self::id($path_to);
                    self::$entries[$id_to] = self::$entries[$id_from];
                    unset(self::$entries[$id_from]);
                    // https://qiita.com/hnw/items/3af76d3d7ec2cf52fff8
                    clearstatcache(true, $path_from);
                    return true;
                }

                public function unlink(string $path): bool
                {
                    $id = self::id($path);
                    if (!isset(self::$entries[$id])) {
                        return false;
                    }
                    unset(self::$entries[$id]);
                    // もしファイルを作成した場合、 たとえファイルを削除したとしても TRUE を返します。しかし、unlink() はキャッシュを自動的にクリアします。
                    clearstatcache(true, $path);
                    return true;
                }

                public function mkdir($path, $mode, $options)
                {
                    $id = self::id($path);
                    if (isset(self::$entries[$id])) {
                        return false;
                    }
                    $parts = explode('/', $id);
                    if (count($parts) > 1 && !($options & STREAM_MKDIR_RECURSIVE)) {
                        if (!isset(self::$entries[implode('/', array_slice($parts, 0, -1))])) {
                            return false;
                        }
                    }
                    $dirpath = '';
                    foreach ($parts as $part) {
                        $dirpath .= "$part/";
                        self::create(rtrim($dirpath, '/'), 004_0000 | $mode);
                    }
                    return true;
                }

                public function rmdir($path, $options)
                {
                    assert(is_int($options));
                    $id = self::id($path);
                    if (!isset(self::$entries[$id])) {
                        return false;
                    }
                    foreach (self::$entries as $eid => $entry) {
                        if (preg_match('#^' . preg_quote("$id/", '#') . '([^/]+)$#u', $eid)) {
                            return false;
                        }
                    }
                    unset(self::$entries[$id]);
                    clearstatcache(true, $path);
                    return true;
                }

                public function dir_opendir(string $path, int $options)
                {
                    assert(is_int($options));
                    $id = self::id($path);
                    if (!isset(self::$entries[$id])) {
                        return false;
                    }

                    $files = ['.', '..'];
                    foreach (self::$entries as $eid => $entry) {
                        if (preg_match('#^' . preg_quote("$id/", '#') . '([^/]+)$#u', $eid, $m)) {
                            $files[] = $m[1];
                        }
                    }

                    $this->entry = self::$entries[$id];
                    $this->entry->content = $files;
                    return true;
                }

                public function dir_readdir()
                {
                    $result = current($this->entry->content);
                    next($this->entry->content);
                    return $result;
                }

                public function dir_rewinddir()
                {
                    reset($this->entry->content);
                    return true;
                }

                public function dir_closedir()
                {
                    unset($this->entry);
                    return true;
                }
            }));
        }

        return "$STREAM_NAME://" . trim($path, '\\/');
    }
}
