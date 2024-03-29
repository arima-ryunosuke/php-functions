<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../exec/process_async.php';
// @codeCoverageIgnoreEnd

/**
 * proc_open ～ proc_close の一連の処理を行う
 *
 * 標準入出力は文字列で受け渡しできるが、決め打ち実装なのでいわゆる対話型なプロセスは起動できない。
 * また、標準入出力はリソース型を渡すこともできる。
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
 * that($rc)->isSame(123); // -d で与えた max_file_uploads で exit してるので 123
 * that($stdout)->isSame('out'); // 標準出力に標準入力を書き込んでいるので "out" が格納される
 * that($stderr)->isSame('err'); // 標準エラーに書き込んでいるので "err" が格納される
 * ```
 *
 * @package ryunosuke\Functions\Package\exec
 *
 * @param string $command 実行コマンド。php7.4 未満では escapeshellcmd される
 * @param array|string $args コマンドライン引数。php7.4 未満では文字列はそのまま結合され、配列は escapeshellarg された上でキーと結合される
 * @param string|resource $stdin 標準入力（string を渡すと単純に読み取れられる。resource を渡すと fread される）
 * @param string|resource $stdout 標準出力（string を渡すと参照渡しで格納される。resource を渡すと fwrite される）
 * @param string|resource $stderr 標準エラー（string を渡すと参照渡しで格納される。resource を渡すと fwrite される）
 * @param ?string $cwd 作業ディレクトリ
 * @param ?array $env 環境変数
 * @param ?array $options その他の追加オプション
 * @return int リターンコード
 */
function process($command, $args = [], $stdin = '', &$stdout = '', &$stderr = '', $cwd = null, array $env = null, $options = null)
{
    $rc = process_async($command, $args, $stdin, $stdout, $stderr, $cwd, $env, $options)();
    if ($rc === -1) {
        // どうしたら失敗するのかわからない
        throw new \RuntimeException("$command exit failed."); // @codeCoverageIgnore
    }
    return $rc;
}
