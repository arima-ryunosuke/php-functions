<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/mb_monospace.php';
// @codeCoverageIgnoreEnd

/**
 * マルチバイト版 str_pad
 *
 * 単純な mb_strlen での実装ではなく mb_monospace による実装となっている。
 * 「文字数を指定して pad したい」という状況は utf8 で2バイト超えという状況がふさわしくないことが非常に多い。
 * 多くは単純に「全角は2文字、半角は1文字」というユースケースが多い（埋める文字がスペースなら特に）。
 *
 * また、$pad_string が切り捨てられることもない。
 * 標準の str_pad はできるだけ詰めようとして中途半端な $pad_string になることがあるが、その動作は模倣していない。
 * 端的に「$width を超えないようにできる限り敷き詰めて返す」という動作になる。
 *
 * Example:
 * ```php
 * // マルチバイトは2文字幅として換算される
 * that(mb_str_pad('aaaa', 12, '-'))->isSame('aaaa--------');
 * that(mb_str_pad('ああ', 12, '-'))->isSame('ああ--------');
 * // $pad_string は切り捨てられない
 * that(mb_str_pad('aaaa', 12, 'xyz'))->isSame('aaaaxyzxyz'); // 10文字で返す（あと1回 xyz すると 13 文字になり width を超えてしまう（かといって xy だけを足したりもしない））
 * that(mb_str_pad('ああ', 12, 'xyz'))->isSame('ああxyzxyz'); // マルチバイトでも同じ
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @param int $width 埋める幅
 * @param string $pad_string 埋める文字列
 * @param int $pad_type 埋める位置
 * @return string 指定文字で埋められた文字列
 */
function mb_str_pad(?string $string, $width, $pad_string = " ", $pad_type = STR_PAD_RIGHT)
{
    assert(in_array($pad_type, [STR_PAD_LEFT, STR_PAD_RIGHT, STR_PAD_BOTH]));

    $str_length = mb_monospace($string);
    $pad_length = mb_monospace($pad_string);
    $target_length = intval($width - $str_length);

    if ($pad_length === 0 || $target_length <= 0) {
        return $string;
    }

    $pad_count = $target_length / $pad_length;

    switch ($pad_type) {
        default:
            throw new \InvalidArgumentException("pad_type is invalid($pad_type)"); // @codeCoverageIgnore
        case STR_PAD_BOTH:
            $left = str_repeat($pad_string, floor($pad_count / 2));
            $right = str_repeat($pad_string, floor(($target_length - mb_monospace($left)) / $pad_length));
            return $left . $string . $right;
        case STR_PAD_RIGHT:
            return $string . str_repeat($pad_string, floor($pad_count));
        case STR_PAD_LEFT:
            return str_repeat($pad_string, floor($pad_count)) . $string;
    }
}
