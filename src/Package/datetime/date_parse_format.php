<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../constants.php';
// @codeCoverageIgnoreEnd

/**
 * 日時文字列のフォーマットを返す
 *
 * 例えば "2014/12/24 12:34:56" から "Y/m/d H:i:s" を逆算して返す。
 * 精度は非常に低く、相対表現なども未対応（そもそも逆算は一意に決まるものでもない）。
 *
 *  Example:
 * ```php
 * // RFC3339
 * that(date_parse_format('2014-12-24T12:34:56'))->isSame('Y-m-d\TH:i:s');
 * // 日本式
 * that(date_parse_format('2014/12/24 12:34:56'))->isSame('Y/m/d H:i:s');
 * // アメリカ式
 * that(date_parse_format('12/24/2014 12:34:56'))->isSame('m/d/Y H:i:s');
 * // イギリス式
 * that(date_parse_format('24.12.2014 12:34:56'))->isSame('d.m.Y H:i:s');
 * ```
 *
 * @package ryunosuke\Functions\Package\datetime
 *
 * @param string $datetimestring 日時文字列
 * @param array $parsed パースの参考情報が格納される（内部向け）
 * @return ?string フォーマット文字列
 */
function date_parse_format($datetimestring, &$parsed = [])
{
    $datetimestring = trim($datetimestring);
    $parsed = (function ($datetimestring) {
        $date_parse = function ($datetimestring) {
            $parsed = date_parse($datetimestring);
            $parsed['datetimestring'] = $datetimestring;
            $parsed += [
                'has:Y' => $parsed['year'] !== false,
                'has:M' => $parsed['month'] !== false,
                'has:D' => $parsed['day'] !== false,
                'has:h' => $parsed['hour'] !== false,
                'has:m' => $parsed['minute'] !== false,
                'has:s' => $parsed['second'] !== false,
                'has:f' => $parsed['fraction'] !== false,
                'has:z' => ($parsed['zone'] ?? false) !== false,
            ];
            return $parsed;
        };

        $parsed = $date_parse($datetimestring);

        // エラーがあってもある程度は救うことができる
        if ($parsed['error_count']) {
            // スラッシュの扱いに難があるので統一して再チャレンジ（2014/12 と 2014-12 は扱いがまったく異なる）
            $parsed = $date_parse(str_replace('/', '-', $datetimestring));
            if (!$parsed['error_count']) {
                $parsed['warnings'][] = 'replace "/" -> "-"';
                return $parsed;
            }
            // 例えば fraction で誤検知している場合（20140202T123456.789123 は Y:7891 になる）
            if ($parsed['has:Y'] && $parsed['has:M'] && $parsed['has:D'] && $parsed['has:h'] && $parsed['has:m'] && $parsed['has:s'] && $parsed['has:f']) {
                $rdot = strrpos($datetimestring, '.');
                if ($rdot !== false) {
                    $parsed = $date_parse(substr($datetimestring, 0, $rdot));
                    if (!$parsed['error_count']) {
                        $parsed['warnings'][] = 'remove fraction';
                        $parsed['fraction'] = '0' . substr($datetimestring, $rdot);
                        return $parsed;
                    }
                }
            }
            // 例えば minute が足りない場合（20140202T12, 2014-02-02T12 のような分無しはパース自体が失敗する）
            if ($parsed['has:Y'] && $parsed['has:M'] && $parsed['has:D'] && !$parsed['has:h'] && !$parsed['has:m'] && !$parsed['has:s'] && !$parsed['has:f']) {
                $parsed = $date_parse($datetimestring . ':00');
                if (!$parsed['error_count']) {
                    $parsed['warnings'][] = 'add minute';
                    return $parsed;
                }
            }
            return $parsed;
        }

        // 日付ありきとする
        if (!$parsed['has:Y'] && !$parsed['has:M'] && !$parsed['has:D'] && $parsed['has:h'] && $parsed['has:m'] && $parsed['has:s']) {
            // 例えば 201412 は h:20,m:14,s:12 と解釈される
            $parsed = $date_parse($datetimestring . '01T00:00:00');
            if (!$parsed['error_count']) {
                $parsed['warnings'][] = 'add day';
                return $parsed;
            }
            // 例えば 2014 は h:20,m:14 と解釈される
            $parsed = $date_parse($datetimestring . '0101T00:00:00');
            if (!$parsed['error_count']) {
                $parsed['warnings'][] = 'add month,day';
                return $parsed;
            }
            return $parsed;
        }

        return $parsed;
    })($datetimestring);

    if ($parsed['error_count']) {
        return null;
    }
    // date_parse は妥当でない日付はエラーではなく警告扱い（2015-09-31 等）
    if ($parsed['has:Y'] && $parsed['has:M'] && $parsed['has:D'] && !checkdate($parsed['month'], $parsed['day'], $parsed['year'])) {
        return null;
    }

    // 得られた値でマッチングすれば元となる文字列が取得できる
    $parsed['monthF'] = EN_MONTH_LONG[$parsed['month']] ?? '';
    $parsed['monthM'] = EN_MONTH_SHORT[$parsed['month']] ?? '';
    $parsed['dayS'] = (new \NumberFormatter('en_US', \NumberFormatter::ORDINAL))->format($parsed['day'] ?: 0);
    $parsed['fractionV'] = substr($parsed['fraction'], 2);
    $regex = [
        'Y' => "(?<Y>{$parsed['year']})?          (?<dY>[^0-9a-z]+)?",
        'M' => "(?<M>(0?{$parsed['month']})|({$parsed['monthF']})|({$parsed['monthM']}))? (?<dM>[^0-9]+)?",
        'D' => "(?<D>(0?{$parsed['dayS']})|(0?{$parsed['day']}))?                         (?<dD>[^0-9]+)?",
        'h' => "(?<h>0?{$parsed['hour']})?        (?<dh>[^0-9]+)?",
        'm' => "(?<m>0?{$parsed['minute']})?      (?<dm>[^0-9]+)?",
        's' => "(?<s>0?{$parsed['second']})?      (?<ds>[^0-9]+)?",
        'f' => "(?<f>0?{$parsed['fractionV']}0*)? (?<df>[^0-9]+)?",
        'z' => "(?<z>[+\-]\d{1,2}:?\d{1,2})?      (?<dz>[^0-9]+)?",
    ];
    $formats = [
        'ja-jp' => "^{$regex['Y']}{$regex['M']}{$regex['D']}{$regex['h']}{$regex['m']}{$regex['s']}{$regex['f']}{$regex['z']}$",
        'en-us' => "^{$regex['M']}{$regex['D']}{$regex['Y']}{$regex['h']}{$regex['m']}{$regex['s']}{$regex['f']}{$regex['z']}$",
        'en-gb' => "^{$regex['D']}{$regex['M']}{$regex['Y']}{$regex['h']}{$regex['m']}{$regex['s']}{$regex['f']}{$regex['z']}$",
    ];
    foreach ($formats as $format) {
        if (preg_match("#$format#ixu", $datetimestring, $matches, PREG_UNMATCHED_AS_NULL)) {
            break;
        }
    }
    if (!$matches) {
        $parsed['errors'][] = 'unmatch regex';
        return null;
    }

    $parsed += [
        'Y' => strlen($matches['Y'] ?? '') ? $matches['Y'] : null,
        'M' => strlen($matches['M'] ?? '') ? $matches['M'] : null,
        'D' => strlen($matches['D'] ?? '') ? $matches['D'] : null,
        'h' => strlen($matches['h'] ?? '') ? $matches['h'] : null,
        'm' => strlen($matches['m'] ?? '') ? $matches['m'] : null,
        's' => strlen($matches['s'] ?? '') ? $matches['s'] : null,
        'f' => strlen($matches['f'] ?? '') ? $matches['f'] : null,
        'z' => strlen($matches['z'] ?? '') ? $matches['z'] : null,
    ];

    $parts = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
    $parts['Y'] = $parsed['Y'] === null ? '' : 'Y';
    $parts['M'] = $parsed['M'] === null ? '' : [1 => 'n', 2 => 'm', 3 => 'M'][strlen($parts['M'])] ?? 'F';
    $parts['D'] = $parsed['D'] === null ? '' : [1 => 'j', 2 => 'd', 3 => 'jS'][strlen($parts['D'])] ?? 'dS';
    $parts['h'] = $parsed['h'] === null ? '' : (strlen($parts['h']) === 1 ? 'G' : 'H');
    $parts['m'] = $parsed['m'] === null ? '' : 'i'; // ゼロなし分フォーマットは存在しない
    $parts['s'] = $parsed['s'] === null ? '' : 's'; // ゼロなし秒フォーマットは存在しない
    $parts['f'] = $parsed['f'] === null ? '' : (strlen($parts['f']) > 3 ? 'u' : 'v');
    $parts['z'] = $parsed['z'] === null ? '' : (strpos($parts['z'], ':') !== false ? 'P' : 'O');

    foreach (['dY', 'dM', 'dD', 'dh', 'dm', 'ds', 'df', 'dz'] as $d) {
        $parts[$d] = implode('', array_map(fn($v) => ctype_alpha($v) ? "\\$v" : $v, str_split($parts[$d] ?? '')));
    }

    return implode('', $parts);
}
