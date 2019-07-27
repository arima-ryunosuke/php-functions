<?php

namespace ryunosuke\Functions\Package;

/**
 * 汎用的なユーティリティ
 */
class Utility
{
    /**
     * $_FILES の構造を組み替えて $_POST などと同じにする
     *
     * $_FILES の配列構造はバグとしか思えないのでそれを是正する関数。
     * 第1引数 $files は指定可能だが、大抵は $_FILES であり、指定するのはテスト用。
     *
     * サンプルを書くと長くなるので例は{@source \ryunosuke\Test\Package\UtilityTest::test_get_uploaded_files() テストファイル}を参照。
     *
     * @param array $files $_FILES の同じ構造の配列。省略時は $_FILES
     * @return array $_FILES を $_POST などと同じ構造にした配列
     */
    public static function get_uploaded_files($files = null)
    {
        $result = [];
        foreach (($files ?: $_FILES) as $name => $file) {
            if (is_array($file['name'])) {
                $file = (get_uploaded_files)((array_each)($file['name'], function (&$carry, $dummy, $subkey) use ($file) {
                    $carry[$subkey] = (array_lookup)($file, $subkey);
                }, []));
            }
            $result[$name] = $file;
        }
        return $result;
    }

    /**
     * 本ライブラリで使用するキャッシュディレクトリを設定する
     *
     * @param string|null $dirname キャッシュディレクトリ。省略時は返すのみ
     * @return string 設定前のキャッシュディレクトリ
     */
    public static function cachedir($dirname = null)
    {
        static $cachedir;
        if ($dirname === null) {
            return $cachedir = $cachedir ?? sys_get_temp_dir();
        }

        if (!file_exists($dirname)) {
            @mkdir($dirname, 0777 & (~umask()), true);
        }
        $result = $cachedir;
        $cachedir = realpath($dirname);
        return $result;
    }

    /**
     * シンプルにキャッシュする
     *
     * この関数は get/set/delete を兼ねる。
     * キャッシュがある場合はそれを返し、ない場合は $provider を呼び出してその結果をキャッシュしつつそれを返す。
     *
     * $provider に null を与えるとキャッシュの削除となる。
     *
     * Example:
     * ```php
     * $provider = function(){return rand();};
     * // 乱数を返す処理だが、キャッシュされるので同じ値になる
     * $rand1 = cache('rand', $provider);
     * $rand2 = cache('rand', $provider);
     * assertSame($rand1, $rand2);
     * // $provider に null を与えると削除される
     * cache('rand', null);
     * $rand3 = cache('rand', $provider);
     * assertNotSame($rand1, $rand3);
     * ```
     *
     * @param string $key キャッシュのキー
     * @param callable $provider キャッシュがない場合にコールされる callable
     * @param string $namespace 名前空間
     * @return mixed キャッシュ
     */
    public static function cache($key, $provider, $namespace = null)
    {
        static $cacheobject;
        $cacheobject = $cacheobject ?? new class((cachedir)())
            {
                const CACHE_EXT = '.php-cache';

                /** @var string キャッシュディレクトリ */
                private $cachedir;

                /** @var array 内部キャッシュ */
                private $cache;

                /** @var array 変更感知配列 */
                private $changed;

                public function __construct($cachedir)
                {
                    $this->cachedir = $cachedir;
                    $this->cache = [];
                    $this->changed = [];
                }

                public function __destruct()
                {
                    // 変更されているもののみ保存
                    foreach ($this->changed as $namespace => $dummy) {
                        $filepath = $this->cachedir . '/' . rawurlencode($namespace) . self::CACHE_EXT;
                        $content = "<?php\nreturn " . var_export($this->cache[$namespace], true) . ";\n";

                        $temppath = tempnam(sys_get_temp_dir(), 'cache');
                        if (file_put_contents($temppath, $content) !== false) {
                            @chmod($temppath, 0644);
                            if (!@rename($temppath, $filepath)) {
                                @unlink($temppath);
                            }
                        }
                    }
                }

                public function has($namespace, $key)
                {
                    // ファイルから読み込む必要があるので get しておく
                    $this->get($namespace, $key);
                    return array_key_exists($key, $this->cache[$namespace]);
                }

                public function get($namespace, $key)
                {
                    // 名前空間自体がないなら作る or 読む
                    if (!isset($this->cache[$namespace])) {
                        $nsarray = [];
                        $cachpath = $this->cachedir . '/' . rawurldecode($namespace) . self::CACHE_EXT;
                        if (file_exists($cachpath)) {
                            $nsarray = require $cachpath;
                        }
                        $this->cache[$namespace] = $nsarray;
                    }

                    return $this->cache[$namespace][$key] ?? null;
                }

                public function set($namespace, $key, $value)
                {
                    // 新しい値が来たら変更フラグを立てる
                    if (!isset($this->cache[$namespace]) || !array_key_exists($key, $this->cache[$namespace]) || $this->cache[$namespace][$key] !== $value) {
                        $this->changed[$namespace] = true;
                    }

                    $this->cache[$namespace][$key] = $value;
                }

                public function delete($namespace, $key)
                {
                    $this->changed[$namespace] = true;
                    unset($this->cache[$namespace][$key]);
                }

                public function clear()
                {
                    // インメモリ情報をクリアして・・・
                    $this->cache = [];
                    $this->changed = [];

                    // ファイルも消す
                    foreach (glob($this->cachedir . '/*' . self::CACHE_EXT) as $file) {
                        unlink($file);
                    }
                }
            };

        // flush (for test)
        if ($key === null) {
            $cacheobject = null;
            return;
        }

        $namespace = $namespace ?? __FILE__;

        $exist = $cacheobject->has($namespace, $key);
        if ($provider === null) {
            $cacheobject->delete($namespace, $key);
            return $exist;
        }
        if (!$exist) {
            $cacheobject->set($namespace, $key, $provider());
        }
        return $cacheobject->get($namespace, $key);
    }

    /**
     * リソースが ansi color に対応しているか返す
     *
     * パイプしたりリダイレクトしていると false を返す。
     *
     * @see https://github.com/symfony/console/blob/v4.2.8/Output/StreamOutput.php#L98
     *
     * @param resource $stream 調べるリソース
     * @return bool ansi color に対応しているなら true
     */
    public static function is_ansi($stream)
    {
        // テスト用に隠し引数で DS を取っておく
        $DIRECTORY_SEPARATOR = DIRECTORY_SEPARATOR;
        assert(!!$DIRECTORY_SEPARATOR = func_num_args() > 1 ? func_get_arg(1) : $DIRECTORY_SEPARATOR);

        if ('Hyper' === getenv('TERM_PROGRAM')) {
            return true;
        }

        if ($DIRECTORY_SEPARATOR === '\\') {
            return (\function_exists('sapi_windows_vt100_support') && @sapi_windows_vt100_support($stream))
                || false !== getenv('ANSICON')
                || 'ON' === getenv('ConEmuANSI')
                || 'xterm' === getenv('TERM');
        }

        if (\function_exists('stream_isatty')) {
            return @stream_isatty($stream); // @codeCoverageIgnore
        }

        if (\function_exists('posix_isatty')) {
            return @posix_isatty($stream); // @codeCoverageIgnore
        }

        $stat = @fstat($stream);
        // Check if formatted mode is S_IFCHR
        return $stat ? 0020000 === ($stat['mode'] & 0170000) : false;
    }

    /**
     * 文字列に ANSI Color エスケープシーケンスを埋め込む
     *
     * - "blue" のような小文字色名は文字色
     * - "BLUE" のような大文字色名は背景色
     * - "bold" のようなスタイル名は装飾
     *
     * となる。その区切り文字は現在のところ厳密に定めていない（`fore+back|bold` のような形式で定めることも考えたけどメリットがない）。
     * つまり、アルファベット以外で分割するので、
     *
     * - `blue|WHITE@bold`: 文字青・背景白・太字
     * - `blue WHITE bold underscore`: 文字青・背景白・太字・下線
     * - `italic|bold,blue+WHITE  `: 文字青・背景白・太字・斜体
     *
     * という動作になる（記号で区切られていれば形式はどうでも良いということ）。
     * ただ、この指定方法は変更が入る可能性が高いのでスペースあたりで区切っておくのがもっとも無難。
     *
     * @param string $string 対象文字列
     * @param string $color 色とスタイル文字列
     * @return string エスケープシーケンス付きの文字列
     */
    public static function ansi_colorize($string, $color)
    {
        // see https://en.wikipedia.org/wiki/ANSI_escape_code#SGR_parameters
        // see https://misc.flogisoft.com/bash/tip_colors_and_formatting
        $ansicodes = [
            // forecolor
            'default'    => [39, 39],
            'black'      => [30, 39],
            'red'        => [31, 39],
            'green'      => [32, 39],
            'yellow'     => [33, 39],
            'blue'       => [34, 39],
            'magenta'    => [35, 39],
            'cyan'       => [36, 39],
            'white'      => [97, 39],
            'gray'       => [90, 39],
            // backcolor
            'DEFAULT'    => [49, 49],
            'BLACK'      => [40, 49],
            'RED'        => [41, 49],
            'GREEN'      => [42, 49],
            'YELLOW'     => [43, 49],
            'BLUE'       => [44, 49],
            'MAGENTA'    => [45, 49],
            'CYAN'       => [46, 49],
            'WHITE'      => [47, 49],
            'GRAY'       => [100, 49],
            // style
            'bold'       => [1, 22],
            'faint'      => [2, 22], // not working ?
            'italic'     => [3, 23],
            'underscore' => [4, 24],
            'blink'      => [5, 25],
            'reverse'    => [7, 27],
            'conceal'    => [8, 28],
        ];

        $names = array_flip(preg_split('#[^a-z]#i', $color));
        $styles = array_intersect_key($ansicodes, $names);
        $setters = implode(';', array_column($styles, 0));
        $unsetters = implode(';', array_column($styles, 1));
        return "\033[{$setters}m{$string}\033[{$unsetters}m";
    }

    /**
     * proc_open ～ proc_close の一連の処理を行う
     *
     * 標準入出力は受け渡しできるが、決め打ち実装なのでいわゆる対話型なプロセスは起動できない。
     *
     * Example:
     * ```php
     * // サンプル実行用ファイルを用意
     * $phpfile = sys_get_temp_dir() . '/rf-sample.php';
     * file_put_contents($phpfile, "<?php
     *     fwrite(STDOUT, fgets(STDIN));
     *     fwrite(STDERR, 'err');
     *     exit((int) ini_get('max_file_uploads'));
     * ");
     * // 引数と標準入出力エラーを使った単純な例
     * $rc = process(PHP_BINARY, [
     *     '-d' => 'max_file_uploads=123',
     *     $phpfile,
     * ], 'out', $stdout, $stderr);
     * assertSame($rc, 123); // -d で与えた max_file_uploads で exit してるので 123
     * assertSame($stdout, 'out'); // 標準出力に標準入力を書き込んでいるので "out" が格納される
     * assertSame($stderr, 'err'); // 標準エラーに書き込んでいるので "err" が格納される
     * ```
     *
     * @param string $command 実行コマンド。escapeshellcmd される
     * @param array|string $args コマンドライン引数。文字列はそのまま結合される。配列は escapeshellarg された上でキーと結合される
     * @param string $stdin 標準入力
     * @param string $stdout 標準出力（参照渡しで格納される）
     * @param string $stderr 標準エラー（参照渡しで格納される）
     * @param string $cwd 作業ディレクトリ
     * @param array $env 環境変数
     * @return int リターンコード
     */
    public static function process($command, $args = [], $stdin = '', &$stdout = '', &$stderr = '', $cwd = null, array $env = null)
    {
        $ecommand = escapeshellcmd($command);

        if (is_array($args)) {
            $args = (array_sprintf)($args, function ($v, $k) {
                $ev = escapeshellarg($v);
                return is_int($k) ? $ev : "$k $ev";
            }, ' ');
        }

        $proc = proc_open("$ecommand $args", [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ], $pipes, $cwd, $env);

        if ($proc === false) {
            // どうしたら失敗するのかわからない
            throw new \RuntimeException("$command start failed."); // @codeCoverageIgnore
        }

        fwrite($pipes[0], $stdin);
        fclose($pipes[0]);

        stream_set_blocking($pipes[1], false);
        stream_set_blocking($pipes[2], false);

        $stdout = $stderr = '';
        while (feof($pipes[1]) === false || feof($pipes[2]) === false) {
            $read = [$pipes[1], $pipes[2]];
            $write = $except = null;
            if (stream_select($read, $write, $except, 1) === false) {
                // （システムコールが別のシグナルによって中断された場合などに起こりえます）
                // @codeCoverageIgnoreStart
                fclose($pipes[1]);
                fclose($pipes[2]);
                proc_close($proc);
                throw new \RuntimeException('stream_select failed.');
                // @codeCoverageIgnoreEnd
            }
            foreach ($read as $fp) {
                if ($fp === $pipes[1]) {
                    $stdout .= fread($fp, 1024);
                }
                elseif ($fp === $pipes[2]) {
                    $stderr .= fread($fp, 1024);
                }
            }
        }

        fclose($pipes[1]);
        fclose($pipes[2]);
        $rc = proc_close($proc);
        if ($rc === -1) {
            // どうしたら失敗するのかわからない
            throw new \RuntimeException("$command exit failed."); // @codeCoverageIgnore
        }
        return $rc;
    }

    /**
     * コマンドライン引数をパースして引数とオプションを返す
     *
     * 少しリッチな {@link http://php.net/manual/function.getopt.php getopt} として使える（shell 由来のオプション構文(a:b::)はどうも馴染みにくい）。
     * ただし「値が必須なオプション」はサポートしない。
     * もっとも、オプションとして空文字が来ることはほぼ無いのでデフォルト値を空文字にすることで対応可能。
     *
     * $rule に従って `--noval filename --opt optval` のような文字列・配列をパースする。
     * $rule 配列の仕様は下記。
     *
     * - キーは「オプション名」を指定する。ただし・・・
     *     - 数値キーは「引数」を意味する
     *     - スペースの後に「ショート名」を与えられる
     * - 値は「デフォルト値」を指定する。ただし・・・
     *     - `[]` は「複数値オプション」を意味する（配列にしない限り同オプションの多重指定は許されない）
     *     - `null` は「値なしオプション」を意味する（スイッチングオプション）
     * - 空文字キーは解釈自体のオプションを与える
     *     - 今のところ throw のみの実装。配列ではなく bool を与えられる
     *
     * 上記の仕様でパースして「引数は数値連番、オプションはオプション名をキーとした配列」を返す。
     * なお、いわゆる「引数」はどこに来ても良い（前オプション、後オプションの区別がない）。
     *
     * $argv には配列や文字列が与えられるが、ほとんどテスト用に近く、普通は未指定で $argv を使うはず。
     *
     * Example:
     * ```php
     * // いくつか織り交ぜたスタンダードな例
     * $rule = [
     *     'opt'       => 'def',    // 基本的には「デフォルト値」を表す
     *     'longopt l' => '',       // スペース区切りで「ショート名」を意味する
     *     1           => 'defarg', // 数値キーは「引数」を意味する
     * ];
     * assertSame(arguments($rule, '--opt optval arg1 -l longval'), [
     *     'opt'     => 'optval',  // optval と指定している
     *     'longopt' => 'longval', // ショート名指定でも本来の名前で返ってくる
     *     'arg1',   // いわゆるコマンドライン引数（optval は opt に飲まれるので含まれない）
     *     'defarg', // いわゆるコマンドライン引数（与えられていないが、ルールの 1 => 'defarg' が活きている）
     * ]);
     *
     * // 「値なしオプション」と「複数値オプション」の例
     * $rule = [
     *     'noval1 l'  => null, // null は「値なしオプション」を意味する（指定されていれば true されていなければ false を返す）
     *     'noval2 m'  => null, // 同上
     *     'noval3 n'  => null, // 同上
     *     'opts o' => [],      // 配列を与えると「複数値オプション」を表す
     * ];
     * assertSame(arguments($rule, '--opts o1 -ln arg1 -o o2 arg2 --opts o3'), [
     *     'noval1' => true,  // -ln で同時指定されているので true
     *     'noval2' => false, // -ln で同時指定されてないので false
     *     'noval3' => true,  // -ln の同時指定されているので true
     *     'opts'   => ['o1', 'o2', 'o3'], // ロング、ショート混在でも OK
     *     'arg1', // 一見 -ln のオプション値に見えるが、 noval は値なしなので引数として得られる
     *     'arg2', // 前オプション、後オプションの区別はないのでどこに居ようと引数として得られる
     * ]);
     *
     * // 空文字で解釈自体のオプションを与える
     * $rule = [
     *     ''  => false, // 定義されていないオプションが来ても例外を投げずに引数として処理する
     * ];
     * assertSame(arguments($rule, '--long A -short B'), [
     *     '--long', // 明らかにオプション指定に見えるが、 long というオプションは定義されていないので引数として解釈される
     *     'A',      // 同上。long のオプション値に見えるが、ただの引数
     *     '-short', // 同上。short というオプションは定義されていない
     *     'B',      // 同上。short のオプション値に見えるが、ただの引数
     * ]);
     * ```
     *
     * @param array $rule オプションルール
     * @param array|string|null $argv パースするコマンドライン引数。未指定時は $argv が使用される
     * @return array コマンドライン引数＋オプション
     */
    public static function arguments($rule, $argv = null)
    {
        $opt = (array_unset)($rule, '', []);
        if (is_bool($opt)) {
            $opt = ['thrown' => $opt];
        }
        $opt += [
            'thrown' => true,
        ];

        if ($argv === null) {
            $argv = array_slice($_SERVER['argv'], 1); // @codeCoverageIgnore
        }
        if (is_string($argv)) {
            $argv = (quoteexplode)([" ", "\t"], $argv);
            $argv = array_filter($argv, 'strlen');
        }
        $argv = array_values($argv);

        $shortmap = [];
        $argsdefaults = [];
        $optsdefaults = [];
        foreach ($rule as $name => $default) {
            if (is_int($name)) {
                $argsdefaults[$name] = $default;
                continue;
            }
            list($longname, $shortname) = preg_split('#\s+#u', $name, -1, PREG_SPLIT_NO_EMPTY) + [1 => null];
            if ($shortname !== null) {
                if (array_key_exists($shortname, $shortmap)) {
                    throw new \InvalidArgumentException("duplicated short option name '$shortname'");
                }
                $shortmap[$shortname] = $longname;
            }
            if (array_key_exists($longname, $optsdefaults)) {
                throw new \InvalidArgumentException("duplicated option name '$shortname'");
            }
            $optsdefaults[$longname] = $default;
        }

        $n = 0;
        $already = [];
        $result = array_map(function ($v) { return $v === null ? false : $v; }, $optsdefaults);
        while (($token = array_shift($argv)) !== null) {
            if (strlen($token) >= 2 && $token[0] === '-') {
                if ($token[1] === '-') {
                    $optname = substr($token, 2);
                    if (!$opt['thrown'] && !array_key_exists($optname, $optsdefaults)) {
                        $result[$n++] = $token;
                        continue;
                    }
                }
                else {
                    $shortname = substr($token, 1);
                    if (!$opt['thrown'] && !isset($shortmap[$shortname])) {
                        $result[$n++] = $token;
                        continue;
                    }
                    if (strlen($shortname) > 1) {
                        array_unshift($argv, '-' . substr($shortname, 1));
                        $shortname = substr($shortname, 0, 1);
                    }
                    if (!isset($shortmap[$shortname])) {
                        throw new \InvalidArgumentException("undefined short option name '$shortname'.");
                    }
                    $optname = $shortmap[$shortname];
                }

                if (!array_key_exists($optname, $optsdefaults)) {
                    throw new \InvalidArgumentException("undefined option name '$optname'.");
                }
                if (isset($already[$optname]) && !is_array($result[$optname])) {
                    throw new \InvalidArgumentException("'$optname' is specified already.");
                }
                $already[$optname] = true;

                if ($optsdefaults[$optname] === null) {
                    $result[$optname] = true;
                }
                else {
                    if (!isset($argv[0]) || strpos($argv[0], '-') === 0) {
                        throw new \InvalidArgumentException("'$optname' requires value.");
                    }
                    if (is_array($result[$optname])) {
                        $result[$optname][] = array_shift($argv);
                    }
                    else {
                        $result[$optname] = array_shift($argv);
                    }
                }
            }
            else {
                $result[$n++] = $token;
            }
        }

        array_walk_recursive($result, function (&$v) {
            if (is_string($v)) {
                $v = trim(str_replace('\\"', '"', $v), '"');
            }
        });
        return $result + $argsdefaults;
    }

    /**
     * スタックトレースを文字列で返す
     *
     * `(new \Exception())->getTraceAsString()` と実質的な役割は同じ。
     * ただし、 getTraceAsString は引数が Array になったりクラス名しか取れなかったり微妙に使い勝手が悪いのでもうちょっと情報量を増やしたもの。
     *
     * 第1引数 $traces はトレース的配列を受け取る（`(new \Exception())->getTrace()` とか）。
     * 未指定時は debug_backtrace() で採取する。
     *
     * 第2引数 $option は文字列化する際の設定を指定する。
     * 情報量が増える分、機密も含まれる可能性があるため、 mask オプションで塗りつぶすキーや引数名を指定できる（クロージャの引数までは手出ししないため留意）。
     * limit と format は比較的指定頻度が高いかつ互換性維持のため配列オプションではなく直に渡すことが可能になっている。
     *
     * @param array $traces debug_backtrace 的な配列
     * @param int|string|array $option オプション
     * @return string|array トレース文字列（delimiter オプションに null を渡すと配列で返す）
     */
    public static function stacktrace($traces = null, $option = [])
    {
        if (is_int($option)) {
            $option = ['limit' => $option];
        }
        elseif (is_string($option)) {
            $option = ['format' => $option];
        }

        $option += [
            'format'    => '%s:%s %s', // 文字列化するときの sprintf フォーマット
            'args'      => true,       // 引数情報を埋め込むか否か
            'limit'     => 16,         // 配列や文字列を千切る長さ
            'delimiter' => "\n",       // スタックトレースの区切り文字（null で配列になる）
            'mask'      => ['#^password#', '#^secret#', '#^credential#', '#^credit#'],
        ];
        $limit = $option['limit'];
        $maskregexs = (array) $option['mask'];
        $mask = static function ($key, $value) use ($maskregexs) {
            if (!is_string($value)) {
                return $value;
            }
            foreach ($maskregexs as $regex) {
                if (preg_match($regex, $key)) {
                    return str_repeat('*', strlen($value));
                }
            }
            return $value;
        };

        $stringify = static function ($value) use ($limit, $mask) {
            // 再帰用クロージャ
            $export = static function ($value, $nest = 0, $parents = []) use (&$export, $limit, $mask) {
                // 再帰を検出したら *RECURSION* とする（処理に関しては is_recursive のコメント参照）
                foreach ($parents as $parent) {
                    if ($parent === $value) {
                        return var_export('*RECURSION*', true);
                    }
                }
                // 配列は連想判定したり再帰したり色々
                if (is_array($value)) {
                    $parents[] = $value;
                    $flat = $value === array_values($value);
                    $kvl = [];
                    foreach ($value as $k => $v) {
                        if (count($kvl) >= $limit) {
                            $kvl[] = sprintf('...(more %d length)', count($value) - $limit);
                            break;
                        }
                        $kvl[] = ($flat ? '' : $k . ':') . $export(call_user_func($mask, $k, $v), $nest + 1, $parents);
                    }
                    return ($flat ? '[' : '{') . implode(', ', $kvl) . ($flat ? ']' : '}');
                }
                // オブジェクトは単にプロパティを配列的に出力する
                elseif (is_object($value)) {
                    $parents[] = $value;
                    return get_class($value) . $export((get_object_properties)($value), $nest, $parents);
                }
                // 文字列は改行削除
                elseif (is_string($value)) {
                    $value = str_replace(["\r\n", "\r", "\n"], '\n', $value);
                    if (($strlen = strlen($value)) > $limit) {
                        $value = substr($value, 0, $limit) . sprintf('...(more %d length)', $strlen - $limit);
                    }
                    return '"' . addcslashes($value, "\"\0\\") . '"';
                }
                // それ以外は stringify
                else {
                    return (stringify)($value);
                }
            };

            return $export($value);
        };

        $traces = $traces ?? array_slice(debug_backtrace(), 1);
        $result = [];
        foreach ($traces as $i => $trace) {
            // メソッド内で関数定義して呼び出したりすると file が無いことがある（かなりレアケースなので無視する）
            if (!isset($trace['file'])) {
                continue; // @codeCoverageIgnore
            }

            $file = $trace['file'];
            $line = $trace['line'];
            if (strpos($trace['file'], "eval()'d code") !== false && ($traces[$i + 1]['function'] ?? '') === 'eval') {
                $file = $traces[$i + 1]['file'];
                $line = $traces[$i + 1]['line'] . "." . $trace['line'];
            }

            if (isset($trace['type'])) {
                $callee = $trace['class'] . $trace['type'] . $trace['function'];
                if ($option['args'] && $maskregexs && method_exists($trace['class'], $trace['function'])) {
                    $ref = new \ReflectionMethod($trace['class'], $trace['function']);
                }
            }
            else {
                $callee = $trace['function'];
                if ($option['args'] && $maskregexs && function_exists($callee)) {
                    $ref = new \ReflectionFunction($trace['function']);
                }
            }
            $args = [];
            if ($option['args']) {
                $args = $trace['args'] ?? [];
                if (isset($ref)) {
                    $params = $ref->getParameters();
                    foreach ($params as $n => $param) {
                        if (array_key_exists($n, $args)) {
                            $args[$n] = $mask($param->getName(), $args[$n]);
                        }
                    }
                }
            }
            $callee .= '(' . implode(', ', array_map($stringify, $args)) . ')';

            $result[] = sprintf($option['format'], $file, $line, $callee);
        }
        if ($option['delimiter'] === null) {
            return $result;
        }
        return implode($option['delimiter'], $result);
    }

    /**
     * 特定条件までのバックトレースを取得する
     *
     * 第2引数 $options を満たすトレース以降を返す。
     * $options は ['$trace の key' => "条件"] を渡す。
     * 条件は文字列かクロージャで、文字列の場合は緩い一致、クロージャの場合は true を返した場合にそれ以降を返す。
     *
     * Example:
     * ```php
     * function f001 () {return backtrace(0, ['function' => __NAMESPACE__ . '\\f002', 'limit' => 2]);}
     * function f002 () {return f001();}
     * function f003 () {return f002();}
     * $traces = f003();
     * // limit 指定してるので2個
     * assertCount(2, $traces);
     * // 「function が f002 以降」を返す
     * assertArraySubset([
     *     'function' => __NAMESPACE__ . '\\f002'
     * ], $traces[0]);
     * assertArraySubset([
     *     'function' => __NAMESPACE__ . '\\f003'
     * ], $traces[1]);
     * ```
     *
     * @param int $flags debug_backtrace の引数
     * @param array $options フィルタ条件
     * @return array バックトレース
     */
    public static function backtrace($flags = \DEBUG_BACKTRACE_PROVIDE_OBJECT, $options = [])
    {
        $result = [];
        $traces = debug_backtrace($flags);
        foreach ($traces as $n => $trace) {
            foreach ($options as $key => $val) {
                if (!isset($trace[$key])) {
                    continue;
                }

                if ($val instanceof \Closure) {
                    $break = $val($trace[$key]);
                }
                else {
                    $break = $trace[$key] == $val;
                }
                if ($break) {
                    $result = array_slice($traces, $n);
                    break 2;
                }
            }
        }

        // offset, limit は特別扱いで千切り指定
        if (isset($options['offset']) || isset($options['limit'])) {
            $result = array_slice($result, $options['offset'] ?? 0, $options['limit'] ?? count($result));
        }

        return $result;
    }

    /**
     * エラー出力する
     *
     * 第1引数 $message はそれらしく文字列化されて出力される。基本的にはあらゆる型を与えて良い。
     *
     * 第2引数 $destination で出力対象を指定する。省略すると error_log 設定に従う。
     * 文字列を与えるとファイル名とみなし、ファイルに追記される。
     * ファイルを開くが、**ファイルは閉じない**。閉じ処理は php の終了処理に身を任せる。
     * したがって閉じる必要がある場合はファイルポインタを渡す必要がある。
     *
     * @param string|mixed $message 出力メッセージ
     * @param resource|string|mixed $destination 出力先
     * @return int 書き込んだバイト数
     */
    public static function error($message, $destination = null)
    {
        static $persistences = [];

        $time = date('d-M-Y H:i:s e');
        $content = (stringify)($message);
        $location = '';
        if (!($message instanceof \Exception || $message instanceof \Throwable)) {
            foreach (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS) as $trace) {
                if (isset($trace['file'], $trace['line'])) {
                    $location = " in {$trace['file']} on line {$trace['line']}";
                    break;
                }
            }
        }
        $line = "[$time] PHP Log:  $content$location\n";

        if ($destination === null) {
            $destination = (blank_if)(ini_get('error_log'), 'php://stderr');
        }

        if ($destination === 'syslog') {
            syslog(LOG_INFO, $message);
            return strlen($line);
        }

        if (is_resource($destination)) {
            $fp = $destination;
        }
        elseif (is_string($destination)) {
            if (!isset($persistences[$destination])) {
                $persistences[$destination] = fopen($destination, 'a');
            }
            $fp = $persistences[$destination];
        }

        if (empty($fp)) {
            throw new \InvalidArgumentException('$destination must be resource or string.');
        }

        flock($fp, LOCK_EX);
        fwrite($fp, $line);
        flock($fp, LOCK_UN);

        return strlen($line);
    }

    /**
     * 処理時間を計測する
     *
     * 第1引数 $callable を $count 回回してその処理時間を返す。
     *
     * Example:
     * ```php
     * // 0.01 秒を 10 回回すので 0.1 秒は超える
     * assertGreaterThan(0.1, timer(function(){usleep(10 * 1000);}, 10));
     * ```
     *
     * @param callable $callable 処理クロージャ
     * @param int $count ループ回数
     * @return float 処理時間
     */
    public static function timer(callable $callable, $count = 1)
    {
        $count = (int) $count;
        if ($count < 1) {
            throw new \InvalidArgumentException("\$count must be greater than 0 (specified $count).");
        }

        $t = microtime(true);
        for ($i = 0; $i < $count; $i++) {
            $callable();
        }
        return microtime(true) - $t;
    }

    /**
     * 簡易ベンチマークを取る
     *
     * 「指定ミリ秒内で何回コールできるか？」でベンチする。
     *
     * $suite は ['表示名' => $callable] 形式の配列。
     * 表示名が与えられていない場合、それらしい名前で表示する。
     *
     * Example:
     * ```php
     * // intval と int キャストはどちらが早いか調べる
     * benchmark([
     *     'intval',
     *     'intcast' => function($v){return (int)$v;},
     * ], ['12345'], 10);
     * ```
     *
     * @param array|callable $suite ベンチ対象処理
     * @param array $args 各ケースに与えられる引数
     * @param int $millisec 呼び出しミリ秒
     * @param bool $output true だと標準出力に出力される
     * @return array ベンチ結果の配列
     */
    public static function benchmark($suite, $args = [], $millisec = 1000, $output = true)
    {
        $benchset = [];
        foreach ((arrayize)($suite) as $name => $caller) {
            if (!is_callable($caller, false, $callname)) {
                throw new \InvalidArgumentException('caller is not callable.');
            }

            if (is_int($name)) {
                // クロージャは "Closure::__invoke" になるので "ファイル#開始行-終了行" にする
                if ($caller instanceof \Closure) {
                    $ref = new \ReflectionFunction($caller);
                    $callname = $ref->getFileName() . '#' . $ref->getStartLine() . '-' . $ref->getEndLine();
                }
                $name = $callname;
            }

            if (isset($benchset[$name])) {
                throw new \InvalidArgumentException('duplicated benchname.');
            }

            $benchset[$name] = (closurize)($caller);
        }

        if (!$benchset) {
            throw new \InvalidArgumentException('benchset is empty.');
        }

        // ウォームアップ兼検証（大量に実行してエラーの嵐になる可能性があるのでウォームアップの時点でエラーがないかチェックする）
        $assertions = (call_safely)(function ($benchset, $args) {
            $result = [];
            $args2 = $args;
            foreach ($benchset as $name => $caller) {
                $result[$name] = $caller(...$args2);
            }
            return $result;
        }, $benchset, $args);

        // 返り値の検証（ベンチマークという性質上、基本的に戻り値が一致しないのはおかしい）
        // rand/mt_rand, md5/sha1 のような例外はあるが、そんなのベンチしないし、クロージャでラップすればいいし、それでも邪魔なら @ で黙らせればいい
        foreach ($assertions as $name1 => $return1) {
            foreach ($assertions as $name2 => $return2) {
                if ($return1 !== null && $return2 !== null && $return1 !== $return2) {
                    $returns1 = (stringify)($return1);
                    $returns2 = (stringify)($return2);
                    trigger_error("Results of $name1 and $name2 are different. ($returns1, $returns2)");
                }
            }
        }

        // ベンチ
        $counts = [];
        foreach ($benchset as $name => $caller) {
            $end = microtime(true) + $millisec / 1000;
            $args2 = $args;
            for ($n = 0; microtime(true) <= $end; $n++) {
                $caller(...$args2);
            }
            $counts[$name] = $n;
        }

        // 結果配列
        $result = [];
        $maxcount = max($counts);
        arsort($counts);
        foreach ($counts as $name => $count) {
            $result[] = [
                'name'   => $name,
                'called' => $count,
                'mills'  => $millisec / $count,
                'ratio'  => $maxcount / $count,
            ];
        }

        // 出力するなら出力
        if ($output) {
            printf("Running %s cases (between %s ms):\n", count($benchset), number_format($millisec));
            echo (markdown_table)(array_map(function ($v) {
                return [
                    'name'       => $v['name'],
                    'called'     => number_format($v['called'], 0),
                    '1 call(ms)' => number_format($v['mills'], 6),
                    'ratio'      => number_format($v['ratio'], 3),
                ];
            }, $result));
        }

        return $result;
    }
}
