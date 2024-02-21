<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../info/ansi_strip.php';
// @codeCoverageIgnoreEnd

/**
 * 標準出力をコメント化して埋め込む ob_start
 *
 * 非常にニッチな関数で、想定用途は「README.md の中の php を実行して出力結果を埋め込みたい」のみ。
 * 例えば php のマニュアルみたいな「上記の結果は下記のようになります」は対応が分かりにくいのでコメントで埋め込みたいことがある。
 * いちいち結果を手で埋め込むのも馬鹿らしいのでこの関数を使えば自動で埋め込まれる。
 *
 * 言語仕様上の制約で echo/print は不可。
 * また、 ob_content 系で途中経過の出力は取れない（chunk_size を指定すると強制フラッシュされるらしいので制御できない）。
 * 返り値オブジェクトが toString を実装してるのでそれで得ること（ただし返り値は toString であること以外はいかなる前提も置いてはならない）。
 *
 * @package ryunosuke\Functions\Package\outcontrol
 *
 * @return object|string 制御用（デバッグ用）
 */
function ob_stdout()
{
    $status = new class {
        public const SPECIALS = [
            'include'      => true,
            'include_once' => true,
            'require'      => true,
            'require_once' => true,
        ];

        private array  $traces  = [];
        private array  $outputs = [];
        private string $buffer  = '';

        public function trace(string $buffer, int $phase): ?array
        {
            $traces = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
            $trace = $traces[2] ?? [];
            assert($this->traces[] = $trace + ['buffer' => $buffer, 'phase' => $phase]);

            // end を呼ばずに言語ランタイムのシャットダウン関数が呼ばれた場合
            if (!$trace) {
                return null; // @codeCoverageIgnore
            }

            // php タグ外と echo/print はオペコードレベルで同じっぽいので検出不可（何か方法があるかもしれないので残しておく）
            if (isset(self::SPECIALS[$trace['function'] ?? ''])) {
                return null;
            }

            return $trace;
        }

        public function append(?string $file, ?int $line, string $buffer): void
        {
            if (isset($file, $line)) {
                $this->outputs[$file][$line] ??= '';
                $this->outputs[$file][$line] .= $buffer;
            }

            $this->buffer .= $buffer;
        }

        public function outputs(): array
        {
            return $this->outputs;
        }

        public function __toString(): string
        {
            return $this->buffer;
        }
    };

    // ob_start を $chunk_size:1 で呼べば標準出力をキャプチャできる（実際には1バイト単位ではなく行単位っぽい）
    ob_start(function ($buffer, $phase) use ($status) {
        $trace = $status->trace($buffer, $phase);

        if (!($phase & PHP_OUTPUT_HANDLER_FINAL)) {
            $status->append($trace['file'] ?? null, $trace['line'] ?? null, $buffer);
            // chunk_size を指定してるので $buffer を返すと出力されてしまう
            // さらに、空文字を返すと get_contents 系で取得ができなくなる
            // 出力されてしまうよりは得られない方がマシと判断（最悪 $status で得ることはできるし）
            // php の仕様がおかしい気がするけど18年前からずっとこうらしい…
            return '';
        }

        foreach ($status->outputs() as $file => $lines) {
            $content = file_get_contents($file);
            $contents = preg_split('#\\R#u', $content);

            // 実行のたびに増えていくことになるので既存の出力コメントは捨てる
            foreach (token_get_all($content) as $token) {
                if (is_array($token) && $token[0] === T_COMMENT && strpos($token[1], "/*= ") === 0) {
                    $comments = preg_split('#\\R#u', $token[1]);
                    array_splice($contents, $token[2] - 1, count($comments), array_pad([], count($comments), null));
                }
            }

            // コメント化して埋め込む（行番号がだんだんズレていくので注意）
            ksort($lines);
            $addition = 0;
            foreach ($lines as $line => $buffer) {
                $stmt = $contents[$line + $addition - 1];
                $indent = str_repeat(' ', strspn($stmt, ' '));

                $outlines = preg_split('#\\R#u', "/*= " . trim(ansi_strip($buffer)) . " */");
                $outlines = array_map(fn($v) => "$indent$v", $outlines);

                array_splice($contents, $line + $addition, 0, $outlines);
                $addition += count($outlines);
            }

            // 異なっていたら書き換え
            $newcontent = implode("\n", array_filter($contents, fn($v) => $v !== null));
            if ($content !== $newcontent) {
                file_put_contents($file, $newcontent);
            }
        }

        return $status;
    }, 1);
    return $status;
}
