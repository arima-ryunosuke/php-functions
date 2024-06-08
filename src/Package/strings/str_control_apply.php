<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/strpos_escaped.php';
require_once __DIR__ . '/../strings/strposr.php';
require_once __DIR__ . '/../strings/strtr_escaped.php';
// @codeCoverageIgnoreEnd

/**
 * 制御文字を実際に適用させる
 *
 * とはいえ文字列として適用できる制御文字はそう多くはなく、実質的に \b くらいだろう。
 *
 * - \b: 前の1文字を消して自身も消える
 * - \d: 次の\d以外の1文字を消して自身も消える
 *   - 前方探索なので利便性のため「\d以外の」という条件がついている
 * - \r: 直前の \n から直後の \n までを消す
 *   - \r に「消す」という意味はないが、実用上はその方が便利なことが多い
 *
 * なお、 \b と書いてあるが php のエスケープシーケンスに \b は存在しないため \x08 と記述する必要がある（\d も同様）。
 * それはそれで不便なので \b, \d は特別扱いとしてある（$characters のデフォルト値に潜ませてあるが、それを外せば特別扱いは無くなる）。
 *
 * Example:
 * ```php
 * // 最初の X は [BS] で消える・次の X は [DEL] で消える、XXX は [CR] で消える。結果 text\nzzz になる
 * that(str_control_apply("X\b\dXtext\nXXX\rzzz"))->isSame("text\nzzz");
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @param string $characters 対象とする制御文字
 * @return string 制御文字が適用された文字列
 */
function str_control_apply(string $string, string $characters = "\b\x08\d\x7f\r"): string
{
    $remap = [];
    if (strpos_escaped($characters, "\b") !== null) {
        $remap["\b"] = "\x08";
    }
    if (strpos_escaped($characters, "\d") !== null) {
        $remap["\d"] = "\x7f";
    }
    $string = strtr_escaped($string, $remap);
    $characters = strtr_escaped($characters, $remap);

    $offset = 0;
    while (true) {
        $pos = strcspn($string, $characters, $offset) + $offset;
        $control = $string[$pos] ?? null;
        if ($control === null) {
            break;
        }
        if ($control === "\x08") {
            if ($pos === 0) {
                $string = substr_replace($string, '', $pos, 1);
                $offset = $pos;
            }
            else {
                $string = substr_replace($string, '', $pos - 1, 2);
                $offset = $pos - 1;
            }
        }
        if ($control === "\x7f") {
            $next = strspn($string, "\x7f", $pos) + $pos;
            $string = substr_replace($string, '', $next, 1);
            $string = substr_replace($string, '', $pos, 1);
            $offset = $pos;
        }
        if ($control === "\x0d") {
            $prev = strposr($string, "\x0a", $pos);
            if ($prev === false) {
                $string = substr_replace($string, '', 0, $pos + 1);
                $offset = 0;
            }
            else {
                $string = substr_replace($string, '', $prev + 1, $pos - $prev);
                $offset = $prev + 1;
            }
        }
    }
    return $string;
}
