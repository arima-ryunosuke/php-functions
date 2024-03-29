<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/arrayize.php';
require_once __DIR__ . '/../classobj/auto_loader.php';
require_once __DIR__ . '/../classobj/object_storage.php';
require_once __DIR__ . '/../exec/process_async.php';
require_once __DIR__ . '/../filesystem/mkdir_p.php';
require_once __DIR__ . '/../filesystem/path_resolve.php';
require_once __DIR__ . '/../utility/function_configure.php';
require_once __DIR__ . '/../var/var_export3.php';
// @codeCoverageIgnoreEnd

/**
 * クロージャを別プロセスで実行する
 *
 * process_parallel の単一クロージャ特化版。
 * クロージャを別プロセスでバックグラウンド実行して結果を返すオブジェクトを返す。
 * クロージャは独自の方法でエクスポートしてから実行するので可能な限り this bind は外したほうが良い。
 *
 * バックグラウンドで実行するので指定クロージャを実行中に別のことができる。
 * これはマルチコアを活かすのにも有用であるし、IO を伴う処理を効率よく実行できる。
 *
 * Example:
 * ```php
 * $hugefile1 = tempnam(sys_get_temp_dir(), 't');
 * $hugefile2 = tempnam(sys_get_temp_dir(), 't');
 * file_put_contents($hugefile1, str_repeat('x', 1024* 1024)); // もっとでかくないと効果は薄いがテストなのであまり大きくしない
 * file_put_contents($hugefile2, str_repeat('y', 1024* 1024));
 * // 超絶でかいファイルの sha1 を計算してる間に・・・
 * $hash1 = process_closure(static fn() => sha1_file($hugefile1));
 * $hash2 = process_closure(static fn() => sha1_file($hugefile2));
 * // ここで別のことができる（裏で処理は走っている）
 * // doSomething())
 * // 返り値オブジェクトをコールすると結果が得られる（この時、処理が未完なら待たされる）
 * that($hash1())->is('e37f4d5be56713044d62525e406d250a722647d6');
 * that($hash2())->is('2b6a7ad91a60e40a5fd37abe06e165dc7498b24e');
 *
 * // あるいは http リクエストを走らせている間に・・・
 * $start = microtime(true);
 * $response1 = process_closure(static fn($url) => file_get_contents($url), TESTWEBSERVER . '/delay/2');
 * $response2 = process_closure(static fn($url) => file_get_contents($url), TESTWEBSERVER . '/delay/2');
 * // 別のことができる（裏でリクエストは走っている）
 * // doSomething())
 * // 返り値オブジェクトをコールするとレスポンスが得られる
 * that($response1())->isNotEmpty();
 * that($response2())->isNotEmpty();
 * // トータルで2秒程度である（少なくとも 2 * 2 で4秒にはならない）
 * that(microtime(true) - $start)->break()->isBetween(2.0, 4.0);
 * ```
 *
 * @package ryunosuke\Functions\Package\exec
 *
 * @param \Closure $closure 非同期実行するクロージャ
 * @param mixed $args クロージャの引数
 * @param bool|int $throw exitcode で例外を投げるか（現在は bool のみ対応）
 * @param ?array $autoload 実行前に読み込むスクリプト。省略時は自動検出された vendor/autoload.php と function_configure/process.autoload
 * @param ?string $workdir ワーキングディレクトリ。省略時はテンポラリディレクトリ
 * @param ?array $options その他の追加オプション
 * @return \ProcessAsync|object プロセスオブジェクト
 */
function process_closure($closure, $args = [], $throw = true, $autoload = null, $workdir = null, $env = null, $options = null)
{
    static $storage = null;
    $storage ??= object_storage(__FUNCTION__);
    /** @noinspection PhpIllegalArrayKeyTypeInspection */
    $closure_code = $storage[$closure] ??= var_export3($closure, true);

    $autoload = arrayize($autoload ?? array_merge([auto_loader()], function_configure('process.autoload')));
    $workdir ??= (sys_get_temp_dir() . '/rfpc');
    mkdir_p($workdir);

    $namespace = strlen(__CLASS__) ? __CLASS__ . '::' : __NAMESPACE__ . '\\';
    $maincode = '<?php
        $autoload = ' . var_export($autoload, true) . ';
        foreach ($autoload as $file) {
            require_once $file;
        }
        $stdin  = eval(stream_get_contents(STDIN));
        $timer  = ' . $namespace . 'cpu_timer();
        $return = ' . $closure_code . '(...$stdin);
        file_put_contents($argv[1], ' . $namespace . 'var_export3([$return, $timer->result(), memory_get_peak_usage()], ["outmode" => "file"]));
    ';
    file_put_contents($mainscript = sys_get_temp_dir() . '/process-' . sha1($maincode) . '.php', $maincode);

    $phpbin = path_resolve('php' . (DIRECTORY_SEPARATOR === '\\' ? '.exe' : ''), [dirname(PHP_BINARY)]);
    $return = tempnam($workdir, 'return');
    $process = process_async($phpbin, [$mainscript, $return], var_export3(arrayize($args), ["outmode" => "eval"]), $stdout, $stderr, $workdir, $env, $options);
    $process->setDestructAction('terminate');
    $process->setCompleteAction(function () use ($throw, $return) {
        /** @var $this \ProcessAsync */
        // 勝手プロセスじゃなくて php なので Fatal error のとき exitcode が非0なのは保証されている
        if ($throw && $this->status['exitcode']) {
            // が、php は設定次第で標準出力/エラーのどちらにも出力されうるので読み替えなければならない
            throw new \ErrorException(strlen($this->stderr) ? $this->stderr : $this->stdout, $this->status['exitcode']);
        }
        if (!filesize($return)) {
            return null;
        }
        $results = include $return;
        opcache_invalidate($return, true);
        $this->status['cpu'] = $results[1];
        $this->status['memory'] = $results[2];
        return $results[0];
    });
    return $process;
}
