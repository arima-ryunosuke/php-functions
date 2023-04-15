<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/strpos_escaped.php';
require_once __DIR__ . '/../strings/strtr_escaped.php';
// @codeCoverageIgnoreEnd

/**
 * glob 記法を正規表現に変換する
 *
 * glob/fnmatch における「パスとしてのマッチ（ディレクトリ区切りの特別扱い）」という性質は失われ、あくまで文字列として扱う。
 * サポートしている記法は下記（ https://ja.wikipedia.org/wiki/%E3%82%B0%E3%83%AD%E3%83%96 ）。
 * - `*`: 0文字以上の任意の文字列にマッチ
 * - `?`: 任意の1文字にマッチ
 * - `[...]`: 括弧内で列挙されたどれか1文字にマッチ
 * - `[!...]`: 括弧内で列挙されていない何かの1文字にマッチ
 * - `[0-9]`: 括弧内で指定された範囲内の1文字にマッチ
 * - `[!0-9]`: 括弧内で指定されていない範囲内の1文字にマッチ
 * - `{a,b,c}`: 「a」、「b」あるいは「c」のいずれかにマッチ（要 GLOB_BRACE）
 *
 * Example:
 * ```php
 * $files = ['hoge.jpg', 'test1.jpg', 'test12.jpg', 'test123.png', 'testA.jpg', 'testAB.jpg', 'testABC.png', 'test.jpg', 'test.jpeg'];
 * // 先頭一致する jpg
 * that(preg_grep('#' . glob2regex('test*.jpg') . '#', $files))->isSame([
 *     1 => 'test1.jpg',
 *     2 => 'test12.jpg',
 *     4 => 'testA.jpg',
 *     5 => 'testAB.jpg',
 *     7 => 'test.jpg',
 * ]);
 * // 先頭一致した2文字の jpg
 * that(preg_grep('#' . glob2regex('test??.jpg') . '#', $files))->isSame([
 *     2 => 'test12.jpg',
 *     5 => 'testAB.jpg',
 * ]);
 * // 先頭一致した数値1桁の jpg
 * that(preg_grep('#' . glob2regex('test[0-9].jpg') . '#', $files))->isSame([
 *     1 => 'test1.jpg',
 * ]);
 * // 先頭一致した数値1桁でない jpg
 * that(preg_grep('#' . glob2regex('test[!0-9].jpg') . '#', $files))->isSame([
 *     4 => 'testA.jpg',
 * ]);
 * // jpeg, jpg のどちらにもマッチ（GLOB_BRACE 使用）
 * that(preg_grep('#' . glob2regex('test.jp{e,}g', GLOB_BRACE) . '#', $files))->isSame([
 *     7 => 'test.jpg',
 *     8 => 'test.jpeg',
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\pcre
 *
 * @param string $pattern glob パターン文字列
 * @param int $flags glob フラグ。現在のところ GLOB_BRACE だけが有効
 * @return string 正規表現パターン文字列
 */
function glob2regex($pattern, $flags = 0)
{
    $replacer = [
        // target glob character
        '*'  => '.*',
        '?'  => '.',
        '[!' => '[^',
        // quote regex character
        '.'  => '\\.',
        //'\\' => '\\\\',
        '+'  => '\\+',
        //'*' => '\\*',
        //'?' => '\\?',
        //'[' => '\\[',
        '^'  => '\\^',
        //']' => '\\]',
        '$'  => '\\$',
        '('  => '\\(',
        ')'  => '\\)',
        //'{' => '\\{',
        //'}' => '\\}',
        '='  => '\\=',
        '!'  => '\\!',
        '<'  => '\\<',
        '>'  => '\\>',
        '|'  => '\\|',
        ':'  => '\\:',
        //'-' => '\\-',
        '#'  => '\\#',
    ];

    if (!($flags & GLOB_BRACE)) {
        $replacer += [
            '{' => '\\{',
            '}' => '\\}',
        ];
    }

    $pattern = strtr_escaped($pattern, $replacer);

    if ($flags & GLOB_BRACE) {
        while (true) {
            $brace_s = strpos_escaped($pattern, '{');
            if ($brace_s === false) {
                break;
            }
            $brace_e = strpos_escaped($pattern, '}', $brace_s);
            if ($brace_e === false) {
                break;
            }
            $brace = substr($pattern, $brace_s + 1, $brace_e - $brace_s - 1);
            $brace = strtr_escaped($brace, [',' => '|']);
            $pattern = substr_replace($pattern, "($brace)", $brace_s, $brace_e - $brace_s + 1);
        }
    }

    return $pattern;
}
