<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/arrayize.php';
require_once __DIR__ . '/../exec/process_closure.php';
require_once __DIR__ . '/../reflection/parameter_length.php';
// @codeCoverageIgnoreEnd

/**
 * 複数の callable を並列で実行する
 *
 * callable はクロージャも使用できるが、独自の方法でエクスポートしてから実行するので可能な限り this bind は外したほうが良い。
 *
 * Example:
 * ```php
 * # 単一のクロージャを複数の引数で回す
 * $t = microtime(true);
 * $result = process_parallel(static function ($arg1, $arg2) {
 *     usleep(1000 * 1000);
 *     fwrite(STDOUT, "this is stdout");
 *     fwrite(STDERR, "this is stderr");
 *     return $arg1 + $arg2;
 * }, ['a' => [1, 2], 'b' => [2, 3], [3, 4]]);
 * // 1000ms かかる処理を3本実行するが、トータル時間は 3000ms ではなくそれ以下になる（多少のオーバーヘッドはある）
 * that(microtime(true) - $t)->break()->lessThan(2.0);
 * // 実行結果は下記のような配列で返ってくる（その際キーは維持される）
 * that($result)->isSame([
 *     'a' => [
 *         'status' => 0,
 *         'stdout' => "this is stdout",
 *         'stderr' => "this is stderr",
 *         'return' => 3,
 *     ],
 *     'b' => [
 *         'status' => 0,
 *         'stdout' => "this is stdout",
 *         'stderr' => "this is stderr",
 *         'return' => 5,
 *     ],
 *     [
 *         'status' => 0,
 *         'stdout' => "this is stdout",
 *         'stderr' => "this is stderr",
 *         'return' => 7,
 *     ],
 * ]);
 * # 複数のクロージャを複数の引数で回す（この場合、引数のキーは合わせなければならない）
 * $t = microtime(true);
 * $result = process_parallel([
 *     'a' => static function ($arg1, $arg2) {
 *         usleep(300 * 1000);
 *         return $arg1 + $arg2;
 *     },
 *     'b' => static function ($arg1, $arg2) {
 *         usleep(500 * 1000);
 *         return $arg1 * $arg2;
 *     },
 *     static function ($arg) {
 *         usleep(1000 * 1000);
 *         exit($arg);
 *     },
 * ], ['a' => [1, 2], 'b' => [2, 3], [127]]);
 * // 300,500,1000ms かかる処理を3本実行するが、トータル時間は 1800ms ではなくそれ以下になる（多少のオーバーヘッドはある）
 * that(microtime(true) - $t)->break()->lessThan(1.5);
 * // 実行結果は下記のような配列で返ってくる（その際キーは維持される）
 * that($result)->isSame([
 *     'a' => [
 *         'status' => 0,
 *         'stdout' => "",
 *         'stderr' => "",
 *         'return' => 3,
 *     ],
 *     'b' => [
 *         'status' => 0,
 *         'stdout' => "",
 *         'stderr' => "",
 *         'return' => 6,
 *     ],
 *     [
 *         'status' => 127,  // 終了コードが入ってくる
 *         'stdout' => "",
 *         'stderr' => "",
 *         'return' => null,
 *     ],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\exec
 *
 * @param callable|callable[] $tasks 並列実行する callable. 単一の場合は引数分実行して結果を返す
 * @param array $args 各々の引数。$tasks が配列の場合はそれに対応する引数配列。単一の場合は実行回数も兼ねた引数配列
 * @param ?array $autoload 実行前に読み込むスクリプト。省略時は自動検出された vendor/autoload.php と function_configure/process.autoload
 * @param ?string $workdir ワーキングディレクトリ。省略時はテンポラリディレクトリ
 * @param ?array $options その他の追加オプション
 * @return array 実行結果（['return' => callable の返り値, 'status' => 終了コード, 'stdout' => 標準出力, 'stderr' => 標準エラー]）
 */
function process_parallel($tasks, $args = [], $autoload = null, $workdir = null, $env = null, $options = null)
{
    // 単一で来た場合は同じものを異なる引数で呼び出すシングルモードとなる
    if (!is_array($tasks)) {
        $tasks = array_fill_keys(array_keys($args) ?: [0], $tasks);
    }

    // 引数配列は単一の値でも良い
    $args = array_map(fn(...$args) => arrayize(...$args), $args);

    // 実行すれば "ArgumentCountError: Too few arguments" で怒られるがもっと早い段階で気づきたい
    foreach ($tasks as $key => $task) {
        assert(parameter_length($task, true) <= count($args[$key] ?? []), "task $key's arguments are mismatch.");
    }

    // プロセスを準備
    $processes = [];
    foreach ($tasks as $key => $task) {
        $processes[$key] = process_closure($task, $args[$key] ?? [], false, $autoload, $workdir, $env, $options);
    }

    // プロセスを実行兼返り値用に加工
    $results = [];
    foreach ($processes as $key => $process) {
        $return = $process();
        $results[$key] = [
            'status' => $process->status()['exitcode'],
            'stdout' => $process->stdout,
            'stderr' => $process->stderr,
            'return' => $return,
        ];
    }
    return $results;
}
