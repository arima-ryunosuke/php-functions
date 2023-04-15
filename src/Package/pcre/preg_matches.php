<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 複数マッチに対応した preg_match
 *
 * 要するに preg_match_all とほぼ同義だが、下記の差異がある。
 *
 * - 正規表現フラグに "g" フラグが使用できる。 "g" を指定すると preg_match_all 相当の動作になる
 * - キャプチャは参照引数ではなく返り値で返す
 * - 「パターン全体マッチ」を表す 0 キーは返さない
 * - 上記2つの動作により「マッチしなかったら空配列を返す」という動作になる
 * - 名前付きキャプチャーに対応する数値キーは伏せられる
 * - 伏せられても数値キーは 0 ベースで通し連番となる
 *
 * Example:
 * ```php
 * $pattern = '#(\d{4})/(?<month>\d{1,2})(?:/(\d{1,2}))?#';
 * // 1(month)番目は名前付きキャプチャなので 1 キーとしては含まれず month というキーで返す（2 が詰められて 1 になる）
 * that(preg_matches($pattern, '2014/12/24'))->isSame([0 => '2014', 'month' => '12', 1 => '24']);
 * // 一切マッチしなければ空配列が返る
 * that(preg_matches($pattern, 'hoge'))->isSame([]);
 *
 * // g オプションを与えると preg_match_all 相当の動作になる（flags も使える）
 * $pattern = '#(\d{4})/(?<month>\d{1,2})(?:/(\d{1,2}))?#g';
 * that(preg_matches($pattern, '2013/11/23, 2014/12/24', PREG_SET_ORDER))->isSame([
 *     [0 => '2013', 'month' => '11', 1 => '23'],
 *     [0 => '2014', 'month' => '12', 1 => '24'],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\pcre
 *
 * @param string $pattern 正規表現
 * @param string $subject 対象文字列
 * @param int $flags PREG 定数
 * @param int $offset 開始位置
 * @return array キャプチャした配列
 */
function preg_matches($pattern, $subject, $flags = 0, $offset = 0)
{
    // 0 と名前付きに対応する数値キーを伏せてその上で通し連番にするクロージャ
    $unset = function ($match) {
        $result = [];
        $keys = array_keys($match);
        for ($i = 1; $i < count($keys); $i++) {
            $key = $keys[$i];
            if (is_string($key)) {
                $result[$key] = $match[$key];
                $i++;
            }
            else {
                $result[] = $match[$key];
            }
        }
        return $result;
    };

    $endpairs = [
        '(' => ')',
        '{' => '}',
        '[' => ']',
        '<' => '>',
    ];
    $endpos = strrpos($pattern, $endpairs[$pattern[0]] ?? $pattern[0]);
    $expression = substr($pattern, 0, $endpos);
    $modifiers = str_split(substr($pattern, $endpos));

    if (($g = array_search('g', $modifiers, true)) !== false) {
        unset($modifiers[$g]);

        preg_match_all($expression . implode('', $modifiers), $subject, $matches, $flags, $offset);
        if (($flags & PREG_SET_ORDER) === PREG_SET_ORDER) {
            return array_map($unset, $matches);
        }
        return $unset($matches);
    }
    else {
        $flags = ~PREG_PATTERN_ORDER & ~PREG_SET_ORDER & $flags;

        preg_match($pattern, $subject, $matches, $flags, $offset);
        return $unset($matches);
    }
}
