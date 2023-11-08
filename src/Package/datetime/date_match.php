<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../datetime/date_convert.php';
require_once __DIR__ . '/../datetime/date_timestamp.php';
// @codeCoverageIgnoreEnd

/**
 * 日時と cron ライクな表記のマッチングを行う
 *
 * YYYY/MM/DD(W) hh:mm:ss のようなパターンを与える。
 *
 * - YYYY: 年を表す（1～9999）
 * - MM: 月を表す（1～12）
 * - DD: 日を表す（1～31, 99,L で末日を表す）
 *   - e.g. 2/99 は 2/28,2/29 を表す（年に依存）
 *   - e.g. 2/L も同様
 * - W: 曜日を表す（0～6, #N で第Nを表す、#o,#e で隔週を表す）
 *   - e.g. 3 は毎水曜日を表す
 *   - e.g. 3#4 は第4水曜日を表す
 *   - e.g. 5#L は最終水曜日を表す
 *   - e.g. 4#o は隔週水曜日を表す（週番号奇数）
 *   - e.g. 4#e は隔週水曜日を表す（週番号偶数）
 * - hh: 時を表す（任意で 0～23）
 * - mm: 分を表す（任意で 0～59）
 * - ss: 秒を表す（任意で 0～59）
 *
 * DD と W は AND 判定される（cron は OR）。
 * また `/`（毎）にあたる表記はない。
 *
 * 9,L は「最後」を意味し、文脈に応じた値に書き換わる。
 *  「最終」が可変である日付と曜日のみ指定可能。
 * 例えば `2012/02/99` は「2014/02/29」になるし、`2012/02/**(3#L)` は「2012/02の最終水曜」になる。
 *
 * 各区切り内の値は下記が許可される。
 *
 * - *: 任意の値を表す（桁合わせのためにいくつあってもよい）
 * - 値: 特定の一つの数値を表す
 * - 数字-数字: 範囲を表す
 * - 数字,数字: いずれかを表す
 *
 * `*` 以外は複合できるので Example を参照。
 *
 * この関数は実験的なので互換性担保に含まれない。
 *
 * Example:
 * ```php
 * // 2014年の12月にマッチする
 * that(date_match('2014/12/24 12:34:56', '2014/12/*'))->isTrue();
 * that(date_match('2014/11/24 12:34:56', '2014/12/*'))->isFalse();
 * that(date_match('2015/12/24 12:34:56', '2014/12/*'))->isFalse();
 * // 2014年の12月20日～25日にマッチする
 * that(date_match('2014/12/24 12:34:56', '2014/12/20-25'))->isTrue();
 * that(date_match('2014/12/26 12:34:56', '2014/12/20-25'))->isFalse();
 * that(date_match('2015/12/24 12:34:56', '2014/12/20-25'))->isFalse();
 * // 2014年の12月10,20,30日にマッチする
 * that(date_match('2014/12/20 12:34:56', '2014/12/10,20,30'))->isTrue();
 * that(date_match('2014/12/24 12:34:56', '2014/12/10,20,30'))->isFalse();
 * that(date_match('2015/12/30 12:34:56', '2014/12/10,20,30'))->isFalse();
 * // 2014年の12月10,20~25,30日にマッチする
 * that(date_match('2014/12/24 12:34:56', '2014/12/10,20-25,30'))->isTrue();
 * that(date_match('2014/12/26 12:34:56', '2014/12/10,20-25,30'))->isFalse();
 * that(date_match('2015/12/26 12:34:56', '2014/12/10,20-25,30'))->isFalse();
 * ```
 *
 * @package ryunosuke\Functions\Package\datetime
 *
 * @param mixed $datetime 日時を表す引数
 * @param string $cronlike マッチパターン
 * @return bool マッチしたら true
 */
function date_match($datetime, $cronlike)
{
    static $dayofweek = [
        0 => ['日', '日曜', '日曜日', 'sun', 'sunday'],
        1 => ['月', '月曜', '月曜日', 'mon', 'monday'],
        2 => ['火', '火曜', '火曜日', 'tue', 'tuesday'],
        3 => ['水', '水曜', '水曜日', 'wed', 'wednesday'],
        4 => ['木', '木曜', '木曜日', 'thu', 'thursday'],
        5 => ['金', '金曜', '金曜日', 'fri', 'friday'],
        6 => ['土', '土曜', '土曜日', 'sat', 'saturday'],
    ];

    static $reverse_dayofweek = null;
    $reverse_dayofweek ??= (function () use ($dayofweek) {
        $result = [];
        foreach ($dayofweek as $weekno => $texts) {
            $result += array_fill_keys($texts, $weekno);
        }
        return $result;
    })();

    static $dayofweek_pattern = null;
    $dayofweek_pattern ??= (function () use ($dayofweek) {
        $result = [];
        foreach ($dayofweek as $texts) {
            $result = array_merge($result, $texts);
        }
        usort($result, fn($a, $b) => strlen($b) <=> strlen($a));
        return implode('|', $result);
    })();

    $timestamp = date_timestamp($datetime);
    if ($timestamp === null) {
        throw new \InvalidArgumentException("failed to parse '$datetime'");
    }

    // よく使うので変数化しておく
    $weekno = idate('W', $timestamp);
    $firstdate = date('Y-m-1', $timestamp);
    $lastday = idate('t', $timestamp);
    $lastweekdays = []; // range($day, $lastday);
    for ($day = 29; $day <= $lastday; $day++) {
        $lastweekdays[] = $day;
    }

    // マッチング
    $pattern = <<<REGEXP
           (?<Y> \\*+ | (\\d{1,4}(-\\d{1,4})?)(,(\\d{1,4}(-\\d{1,4})?))* )
        (/ (?<M> \\*+ | (\\d{1,2}(-\\d{1,2})?)(,(\\d{1,2}(-\\d{1,2})?))* ))?
        (/ (?<D> \\*+ | ((\\d{1,2}|L)(-(\\d{1,2}|L))?)(,((\\d{1,2}|L)(-(\\d{1,2}|L))?))*))?
        \\s*
        (\((?<W> \\*+ | (([0-6]|$dayofweek_pattern)(\\#(\\d|L|E|O))?(-([0-6]|$dayofweek_pattern)(\\#(\\d|L|E|O))?)?)(,(([0-6]|$dayofweek_pattern)(\\#(\\d|L|E|O))?(-([0-6]|$dayofweek_pattern)(\\#(\\d|L|E|O))?)?))* ) \) )?
        \\s*
           (?<h> \\*+ | (\\d{1,2}(-\\d{1,2})?)(,(\\d{1,2}(-\\d{1,2})?))* )?
        (: (?<m> \\*+ | (\\d{1,2}(-\\d{1,2})?)(,(\\d{1,2}(-\\d{1,2})?))* ))?
        (: (?<s> \\*+ | (\\d{1,2}(-\\d{1,2})?)(,(\\d{1,2}(-\\d{1,2})?))* ))?
        # dummy-comment
    REGEXP;
    if (!preg_match("!^$pattern$!ixu", trim($cronlike), $matches, PREG_UNMATCHED_AS_NULL)) {
        throw new \InvalidArgumentException("failed to parse '$cronlike'");
    }

    $matches = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

    // 週の特殊処理
    $matches['W'] = preg_replace_callback("!$dayofweek_pattern!u", fn($m) => $reverse_dayofweek[$m[0]], $matches['W']);

    foreach ($matches as $key => &$match) {
        // 9, L 等の特殊処理
        if ($key === 'D') {
            $match = preg_replace('!(L+|9{2,})!', $lastday, $match);
        }
        else {
            $match = preg_replace('!(L+|9+)!', 'LAST', $match);
        }

        // 1-4 などを 1,2,3,4 に展開
        $match = preg_replace_callback('!(\d+)-(\d+)!u', fn($m) => implode(',', range($m[1], $m[2])), $match);
    }

    // 週の特殊処理
    $matches['W'] = preg_replace_callback('!(\d{1,2})(#(\d|LAST|e|o))?!ui', function ($m) use ($weekno, $firstdate, $lastweekdays) {
        $n = (int) $m[1];
        $w = $m[3] ?? null;
        if ($w === null || $w === '*') {
            return implode(',', range($n, 34, 7));
        }
        if ($w === 'e') {
            if ($weekno % 2 === 0) {
                return 'none';
            }
            return implode(',', range($n, 34, 7));
        }
        if ($w === 'o') {
            if ($weekno % 2 === 1) {
                return 'none';
            }
            return implode(',', range($n, 34, 7));
        }
        if ($w === 'LAST') {
            $w = date('w', strtotime($firstdate));
            $lasts = array_map(fn($v) => ($v - 29 + $w) % 7, $lastweekdays);
            return $n + (in_array($n, $lasts, true) ? 4 : 3) * 7;
        }
        return $n + ($w - 1) * 7;
    }, $matches['W']);

    // 1,2,3,4,7 などを連想配列に展開する（兼範囲チェック）
    $parse = function ($pattern, $min, $max) {
        $values = [];
        foreach (explode(',', (string) $pattern) as $range) {
            if (strlen(trim($range, '*'))) {
                $range = (int) $range;
                if (!($min <= $range && $range <= $max)) {
                    throw new \InvalidArgumentException("$range($min~$max)");
                }
                $values[$range] = true;
            }
        }
        return $values;
    };

    // 各要素ごとの処理
    $Ymdwhis = [
        'Y' => $parse($matches['Y'], 1, 9999),
        'n' => $parse($matches['M'], 1, 12),
        'j' => $parse($matches['D'], 1, 31),
        'Q' => $parse($matches['W'], 0, 34),
        'G' => $parse($matches['h'], 0, 24),
        'i' => $parse($matches['m'], 0, 59),
        's' => $parse($matches['s'], 0, 59),
    ];

    $datestring = date_convert(implode(',', array_keys($Ymdwhis)), $timestamp);
    $dateparts = array_combine(array_keys($Ymdwhis), explode(',', $datestring));

    foreach ($dateparts as $key => $value) {
        if ($Ymdwhis[$key] && !isset($Ymdwhis[$key][$value])) {
            return false;
        }
    }

    return true;
}
