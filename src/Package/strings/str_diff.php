<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_maps.php';
require_once __DIR__ . '/../array/array_zip.php';
require_once __DIR__ . '/../info/ansi_colorize.php';
require_once __DIR__ . '/../info/is_ansi.php';
require_once __DIR__ . '/../strings/mb_ereg_options.php';
require_once __DIR__ . '/../strings/mb_monospace.php';
require_once __DIR__ . '/../strings/mb_pad_width.php';
require_once __DIR__ . '/../strings/mb_wordwrap.php';
// @codeCoverageIgnoreEnd

/**
 * テキストの diff を得る
 *
 * `$options['allow-binary']` でバイナリ文字列の扱いを指定する（false: 例外, null: null を返す）。
 * `$options['ignore-case'] = true` で大文字小文字を無視する。
 * `$options['ignore-space-change'] = true` で空白文字の数を無視する。
 * `$options['ignore-all-space'] = true` ですべての空白文字を無視する。
 * `$options['color']` で色を指定する。
 * `$options['lineno']` で行番号表示を指定する。ただし行番号が出るのは sisple unified と split と html のみ（これら以外は由緒正しい形式なので行を出すと壊れてしまう）。
 * `$options['stringify']` で差分データを文字列化するクロージャを指定する。
 *
 * - normal: 標準形式（diff のオプションなしに相当する）
 * - context: コンテキスト形式（context=3 のような形式で diff の -C 3 に相当する）
 * - unified: ユニファイド形式（unified=3 のような形式で diff の -U 3 に相当する）
 *     - unified のみを指定するとヘッダを含まない +- のみの差分を出す
 * - split: サイドバイサイド形式（split=3,120 のような形式で diff の -y -W 120 に相当する）
 *     - diff -y と互換性はなく、あくまでそれっぽくしているのみ
 *     - 120 部分は省略でき、省略した場合自動で算出される
 * - html: ins, del の html タグ形式
 *     - html=perline とすると行レベルでの差分も出す
 *
 * Example:
 * ```php
 * // 前文字列
 * $old = 'same
 * delete
 * same
 * same
 * change
 * ';
 * // 後文字列
 * $new = 'same
 * same
 * append
 * same
 * this is changed line
 * ';
 * // シンプルな差分テキストを返す
 * that(str_diff($old, $new))->isSame(' same
 * -delete
 *  same
 * +append
 *  same
 * -change
 * +this is changed line
 * ');
 * // html で差分を返す
 * that(str_diff($old, $new, ['stringify' => 'html']))->isSame(<<<HTML
 * <span>same</span>
 * <del>delete</del>
 * <span>same</span>
 * <ins>append</ins>
 * <span>same</span>
 * <del>change</del>
 * <ins>this is changed line</ins>
 *
 * HTML);
 * // 行レベルの html で差分を返す
 * that(str_diff($old, $new, ['stringify' => 'html=perline']))->isSame(<<<HTML
 * <span>same</span>
 * <del>delete</del>
 * <span>same</span>
 * <ins>append</ins>
 * <span>same</span>
 * <ins>this is </ins><span>chang</span><ins>ed lin</ins><span>e</span>
 *
 * HTML);
 * // raw な配列で差分を返す
 * that(str_diff($old, $new, ['stringify' => null]))->isSame([
 *     // 等価行（'=' という記号と前後それぞれの文字列を返す（キーは行番号））
 *     ['=', [0 => 'same'], [0 => 'same']],
 *     // 削除行（'-' という記号と前の文字列を返す（キーは行番号）、後は int で行番号のみ）
 *     ['-', [1 => 'delete'], 0],
 *     // 等価行
 *     ['=', [2 => 'same'], [1 => 'same']],
 *     // 追加行（'+' という記号と後の文字列を返す（キーは行番号）、前は int で行番号のみ）
 *     ['+', 2, [2 => 'append']],
 *     // 等価行
 *     ['=', [3 => 'same'], [3 => 'same']],
 *     // 変更行（'*' という記号と前後それぞれの文字列を返す（キーは行番号））
 *     ['*', [4 => 'change'], [4 => 'this is changed line']],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string|array|resource $xstring 元文字列
 * @param string|array|resource $ystring 比較文字列
 * @param array $options オプション配列
 * @return string|array|null 差分テキスト。 stringify が null の場合は raw な差分配列
 */
function str_diff($xstring, $ystring, $options = [])
{
    $differ = new class($options) {
        private $options;
        private $recover;

        public function __construct($options)
        {
            $options += [
                'allow-binary'        => true,
                'ignore-case'         => false,
                'ignore-space-change' => false,
                'ignore-all-space'    => false,
                'trailing-break'      => false, // for compatible
                'color'               => false,
                'lineno'              => false,
                'stringify'           => 'unified',
            ];
            $options['color'] ??= is_ansi(STDOUT);
            if ($options['color'] === true) {
                $options['color'] = ['-' => 'RED+white|bold', '+' => 'CYAN+white|bold'];
            }
            if ($options['color'] === false) {
                $options['color'] = [];
            }
            $this->options = $options;

            $this->recover = mb_ereg_options([
                'encoding'      => $options['encoding'] ?? null,
                'regex_options' => 'r',
            ]);
        }

        public function __invoke($xstring, $ystring)
        {
            $arrayize = function ($string) {
                $binary_check = function (?string $string) {
                    if ($this->options['allow-binary'] === true || !preg_match('#\0#', $string)) {
                        return $string;
                    }
                    throw new \InvalidArgumentException('detected binary string');
                };

                if (is_resource($string)) {
                    $array = [];
                    while (!feof($string)) {
                        $array[] = $binary_check(rtrim(fgets($string), "\r\n"));
                    }
                    return $array;
                }
                if (is_array($string)) {
                    return array_values(array_map($binary_check, $string));
                }
                return mb_split('\\R', $binary_check($string));
            };

            try {
                $xarray = $arrayize($xstring);
                $yarray = $arrayize($ystring);
            }
            catch (\InvalidArgumentException $ex) {
                if ($this->options['allow-binary'] === false) {
                    throw $ex;
                }
                return null;
            }

            $trailingN = "";
            if ($xarray[count($xarray) - 1] === '' && $yarray[count($yarray) - 1] === '') {
                $trailingN = "\n";
                array_pop($xarray);
                array_pop($yarray);
            }

            $diffs = $this->diff($xarray, $yarray);

            $stringfy = $this->options['stringify'];
            if (!$stringfy) {
                return $diffs;
            }

            $lineno_length = null;
            if ($this->options['lineno']) {
                $this->recursive($diffs, function ($line, $no) use (&$lineno_length) {
                    $lineno_length = max(strlen($no), $lineno_length ?? 0);
                });
            }
            if ($stringfy === 'normal') {
                $stringfy = [$this, 'normal'];
            }
            if (is_string($stringfy) && preg_match('#context(=(\d+))?#', $stringfy, $m)) {
                $block_size = (int) ($m[2] ?? 3);
                $stringfy = [$this, 'context'];
            }
            if (is_string($stringfy) && preg_match('#unified(=(\d+))?#', $stringfy, $m)) {
                $block_size = isset($m[2]) ? (int) $m[2] : null;
                $stringfy = fn($diff) => $this->unified($diff, $block_size, $lineno_length);
            }
            if (is_string($stringfy) && preg_match('#split(=(\d+),?(\d+)?)?#', $stringfy, $m)) {
                $block_size = (int) ($m[2] ?? 3);
                $column_size = $m[3] ?? null;
                if ($column_size === null) {
                    // FullHD での一般的な COLUMNS は 220～240 くらいで、ツールバーなども加味して最大幅は 200 程度を想定しておく
                    // mb_monospace は強烈に遅いので打ち切りの意味もある
                    $sizes = [1 => 0, 2 => 0];
                    $this->recursive($diffs, function ($line, $no, $n) use (&$sizes) {
                        return ($sizes[$n] = max(mb_monospace($line), $sizes[$n])) <= 200;
                    });
                    $column_size = array_maps($sizes, fn($v) => $v + $lineno_length + 1);
                }
                $stringfy = fn($diff) => $this->split($diff, $column_size, $lineno_length);
            }
            if (is_string($stringfy) && preg_match('#html(=(.+))?#', $stringfy, $m)) {
                $mode = $m[2] ?? null;
                $stringfy = fn($diff) => $this->html($diff, $mode);
            }

            if (is_string($stringfy)) {
                throw new \InvalidArgumentException("$stringfy is not supported");
            }

            if (isset($block_size)) {
                $result = implode("\n", array_map($stringfy, $this->block($diffs, $block_size)));
            }
            else {
                $result = $stringfy($diffs);
            }

            $result = strlen($result) ? $result . $trailingN : $result;
            if ($this->options['trailing-break']) {
                $result .= "\n";
            }
            return $result;
        }

        private function diff(array $xarray, array $yarray)
        {
            $convert = function ($string) {
                if ($this->options['ignore-case']) {
                    $string = strtoupper($string);
                }
                if ($this->options['ignore-space-change']) {
                    $string = mb_ereg_replace('\\s+', ' ', $string);
                }
                if ($this->options['ignore-all-space']) {
                    $string = mb_ereg_replace('\\s+', '', $string);
                }
                return $string;
            };
            $xarray2 = array_map($convert, $xarray);
            $yarray2 = array_map($convert, $yarray);
            $xcount = count($xarray2);
            $ycount = count($yarray2);

            $head = [];
            reset($yarray2);
            foreach ($xarray2 as $xk => $xv) {
                $yk = key($yarray2);
                if ($yk !== $xk || $xv !== $yarray2[$xk]) {
                    break;
                }
                $head[$xk] = $xv;
                unset($xarray2[$xk], $yarray2[$xk]);
            }

            $tail = [];
            end($xarray2);
            end($yarray2);
            do {
                $xk = key($xarray2);
                $yk = key($yarray2);
                if (null === $xk || null === $yk || current($xarray2) !== current($yarray2)) {
                    break;
                }
                prev($xarray2);
                prev($yarray2);
                $tail = [$xk - $xcount => $xarray2[$xk]] + $tail;
                unset($xarray2[$xk], $yarray2[$yk]);
            } while (true);

            $common = $this->lcs(array_values($xarray2), array_values($yarray2));

            $xchanged = $ychanged = [];
            foreach ($head as $n => $line) {
                $xchanged[$n] = false;
                $ychanged[$n] = false;
            }
            foreach ($common as $line) {
                foreach ($xarray2 as $n => $l) {
                    unset($xarray2[$n]);
                    $xchanged[$n] = $line !== $l;
                    if (!$xchanged[$n]) {
                        break;
                    }
                }
                foreach ($yarray2 as $n => $l) {
                    unset($yarray2[$n]);
                    $ychanged[$n] = $line !== $l;
                    if (!$ychanged[$n]) {
                        break;
                    }
                }
            }
            foreach ($xarray2 as $n => $line) {
                $xchanged[$n] = true;
            }
            foreach ($yarray2 as $n => $line) {
                $ychanged[$n] = true;
            }
            foreach ($tail as $n => $line) {
                $xchanged[$n + $xcount] = false;
                $ychanged[$n + $ycount] = false;
            }

            $diffs = [];
            $xi = $yi = 0;
            while ($xi < $xcount || $yi < $ycount) {
                for ($xequal = [], $yequal = []; $xi < $xcount && $yi < $ycount && !$xchanged[$xi] && !$ychanged[$yi]; $xi++, $yi++) {
                    $xequal[$xi] = $xarray[$xi];
                    $yequal[$yi] = $yarray[$yi];
                }
                for ($delete = []; $xi < $xcount && $xchanged[$xi]; $xi++) {
                    $delete[$xi] = $xarray[$xi];
                }
                for ($append = []; $yi < $ycount && $ychanged[$yi]; $yi++) {
                    $append[$yi] = $yarray[$yi];
                }

                if ($xequal && $yequal) {
                    $diffs[] = ['=', $xequal, $yequal];
                }
                if ($delete && $append) {
                    $diffs[] = ['*', $delete, $append];
                }
                elseif ($delete) {
                    $diffs[] = ['-', $delete, $yi - 1];
                }
                elseif ($append) {
                    $diffs[] = ['+', $xi - 1, $append];
                }
            }
            return $diffs;
        }

        private function lcs(array $xarray, array $yarray)
        {
            $xcount = count($xarray);
            $ycount = count($yarray);
            if ($xcount === 0) {
                return [];
            }
            if ($xcount === 1) {
                if (in_array($xarray[0], $yarray, true)) {
                    return [$xarray[0]];
                }
                return [];
            }
            $i = (int) ($xcount / 2);
            $xprefix = array_slice($xarray, 0, $i);
            $xsuffix = array_slice($xarray, $i);
            $llB = $this->length($xprefix, $yarray);
            $llE = $this->length(array_reverse($xsuffix), array_reverse($yarray));
            $jMax = 0;
            $max = 0;
            for ($j = 0; $j <= $ycount; $j++) {
                $m = $llB[$j] + $llE[$ycount - $j];
                if ($m >= $max) {
                    $max = $m;
                    $jMax = $j;
                }
            }
            $yprefix = array_slice($yarray, 0, $jMax);
            $ysuffix = array_slice($yarray, $jMax);
            return array_merge($this->lcs($xprefix, $yprefix), $this->lcs($xsuffix, $ysuffix));
        }

        private function length(array $xarray, array $yarray)
        {
            $xcount = count($xarray);
            $ycount = count($yarray);
            $current = array_fill(0, $ycount + 1, 0);
            for ($i = 0; $i < $xcount; $i++) {
                $prev = $current;
                for ($j = 0; $j < $ycount; $j++) {
                    $current[$j + 1] = $xarray[$i] === $yarray[$j] ? $prev[$j] + 1 : max($current[$j], $prev[$j + 1]);
                }
            }
            return $current;
        }

        private function minmaxlen($diffs)
        {
            $xmin = $ymin = PHP_INT_MAX;
            $xmax = $ymax = -1;
            $xlen = $ylen = 0;
            foreach ($diffs as $diff) {
                $xargs = (is_array($diff[1]) ? array_keys($diff[1]) : [$diff[1]]);
                $yargs = (is_array($diff[2]) ? array_keys($diff[2]) : [$diff[2]]);
                $xmin = min($xmin, ...$xargs);
                $ymin = min($ymin, ...$yargs);
                $xmax = max($xmax, ...$xargs);
                $ymax = max($ymax, ...$yargs);
                $xlen += is_array($diff[1]) ? count($diff[1]) : 0;
                $ylen += is_array($diff[2]) ? count($diff[2]) : 0;
            }
            if ($xmin === -1 && $xlen > 0) {
                $xmin = 0;
            }
            if ($ymin === -1 && $ylen > 0) {
                $ymin = 0;
            }
            return [$xmin + 1, $xmax + 1, $xlen, $ymin + 1, $ymax + 1, $ylen];
        }

        private function normal($diffs)
        {
            $index = function ($v) {
                if (!is_array($v)) {
                    return $v + 1;
                }
                $keys = array_keys($v);
                $s = reset($keys) + 1;
                $e = end($keys) + 1;
                return $s === $e ? "$s" : "$s,$e";
            };

            $rule = [
                '+' => ['a', [2 => '> ']],
                '-' => ['d', [1 => '< ']],
                '*' => ['c', [1 => '< ', 2 => '> ']],
            ];
            $result = [];
            foreach ($diffs as $diff) {
                if (isset($rule[$diff[0]])) {
                    $difftext = [];
                    foreach ($rule[$diff[0]][1] as $n => $sign) {
                        $difftext[] = implode("\n", array_map(fn($v) => $this->color($sign . $v, $diff[0], $n), $diff[$n]));
                    }
                    $result[] = "{$index($diff[1])}{$rule[$diff[0]][0]}{$index($diff[2])}";
                    $result[] = implode("\n---\n", $difftext);
                }
            }
            return implode("\n", $result);
        }

        private function context($diffs)
        {
            [$xmin, $xmax, , $ymin, $ymax,] = $this->minmaxlen($diffs);
            $xheader = $xmin === $xmax ? "$xmin" : "$xmin,$xmax";
            $yheader = $ymin === $ymax ? "$ymin" : "$ymin,$ymax";

            $rules = [
                '-*' => [
                    'header' => "*** {$xheader} ****",
                    '-'      => [1 => '- '],
                    '*'      => [1 => '! '],
                    '='      => [1 => '  '],
                ],
                '+*' => [
                    'header' => "--- {$yheader} ----",
                    '+'      => [2 => '+ '],
                    '*'      => [2 => '! '],
                    '='      => [2 => '  '],
                ],
            ];
            $result = ["***************"];
            foreach ($rules as $key => $rule) {
                $result[] = $rule['header'];
                if (array_filter($diffs, fn($d) => strpos($key, $d[0]) !== false)) {
                    foreach ($diffs as $diff) {
                        foreach ($rule[$diff[0]] ?? [] as $n => $sign) {
                            $result[] = implode("\n", array_map(fn($v) => $this->color($sign . $v, $diff[0], $n), $diff[$n]));
                        }
                    }
                }
            }
            return implode("\n", $result);
        }

        private function unified($diffs, $block_size, $lineno_length)
        {
            $result = [];

            if ($block_size !== null) {
                [$xmin, , $xlen, $ymin, , $ylen] = $this->minmaxlen($diffs);
                $xheader = $xlen === 1 ? "$xmin" : "$xmin,$xlen";
                $yheader = $ylen === 1 ? "$ymin" : "$ymin,$ylen";
                $result[] = "@@ -{$xheader} +{$yheader} @@";
            }

            $pad = function ($no, $n) use ($block_size, $lineno_length) {
                if ($block_size !== null || !$this->options['lineno']) {
                    return "";
                }
                if ($no !== null) {
                    $no++;
                }
                if ($n === 3) {
                    return str_pad($no ?? "", $lineno_length * 2 + 2, ' ', STR_PAD_BOTH);
                }
                $s = str_pad($no ?? "", $lineno_length, ' ', STR_PAD_LEFT);
                $e = str_repeat(' ', $lineno_length);
                $l = $n === 1 ? $s : $e;
                $r = $n === 2 ? $s : $e;
                return "$l $r ";
            };

            $rule = [
                '+' => [2 => '+'],
                '-' => [1 => '-'],
                '*' => [1 => '-', 2 => '+'],
                '=' => [3 => ' '],
            ];
            foreach ($diffs as $diff) {
                foreach ($rule[$diff[0]] as $n => $sign) {
                    $nx = $n === 3 ? 1 : $n;
                    $result[] = implode("\n", array_maps($diff[$nx], fn($v, $k) => $this->color($pad($k, $n) . $sign . $v, $diff[0], $n)));
                }
            }
            return implode("\n", $result);
        }

        private function split($diffs, $column_size, $lineno_length)
        {
            if (is_array($column_size)) {
                $overwidth = max(0, ($column_size[1] + $column_size[2]) - 200) / 2;
                $left_width = max(40, $column_size[1] - $overwidth);
                $right_width = max(40, $column_size[2] - $overwidth);
            }
            else {
                $column = ($column_size - 3) / 2;
                $left_width = floor($column);
                $right_width = ceil($column);
            }
            $pad = function ($no) use ($lineno_length) {
                if (!$this->options['lineno']) {
                    return "";
                }
                if ($no !== null) {
                    $no++;
                }
                return str_pad($no ?? "", $lineno_length, ' ', STR_PAD_LEFT) . ' ';
            };

            $rules = [
                '+' => ['+', 1 => null, 2 => 2],
                '-' => ['-', 1 => 1, 2 => null],
                '*' => ['*', 1 => 1, 2 => 2],
                '=' => ['|', 1 => 1, 2 => 2],
            ];

            $result = [];
            foreach ($diffs as $diff) {
                [$sign, $before, $after] = $rules[$diff[0]];

                $mi = new \MultipleIterator(\MultipleIterator::MIT_NEED_ANY | \MultipleIterator::MIT_KEYS_NUMERIC);
                $mi->attachIterator(new \ArrayIterator($diff[$before] ?? []));
                $mi->attachIterator(new \ArrayIterator($diff[$after] ?? []));

                foreach ($mi as $k => $v) {
                    $d0 = mb_wordwrap($v[0] ?? '', $left_width - $lineno_length - 1, null);
                    $d1 = mb_wordwrap($v[1] ?? '', $right_width - $lineno_length - 1, null);
                    foreach (array_zip($d0, $d1) as $n => $dd) {
                        if ($n === 0) {
                            $p0 = $pad($k[0]);
                            $p1 = $pad($k[1]);
                        }
                        else {
                            $p0 = $p1 = $pad(null);
                        }
                        $before = $this->color(mb_pad_width($p0 . ($dd[0] ?? ''), $left_width), $k[0] === null ? '' : $diff[0], 1);
                        $after = $this->color(mb_pad_width($p1 . ($dd[1] ?? ''), $right_width), $k[1] === null ? '' : $diff[0], 2);
                        $result[] = "$before $sign $after";
                    }
                }
            }
            return implode("\n", $result);
        }

        private function html($diffs, $mode)
        {
            $htmlescape = function ($v) use (&$htmlescape) {
                if (is_array($v)) {
                    return array_map($htmlescape, $v);
                }
                return htmlspecialchars($v, ENT_QUOTES);
            };
            $taging = function ($tag, $content, $no) {
                if (strlen($tag) && strlen($content)) {
                    if ($this->options['lineno'] && $no !== null) {
                        return "<$tag data-line-number='$no'>$content</$tag>";
                    }
                    return "<$tag>$content</$tag>";
                }
                return $content;
            };

            $rule = [
                '+' => [2 => 'ins'],
                '-' => [1 => 'del'],
                '*' => [1 => 'del', 2 => 'ins'],
                '=' => [3 => 'span'],
            ];
            $result = [];
            foreach ($diffs as $diff) {
                if ($mode === 'perline' && $diff[0] === '*') {
                    $length = min(count($diff[1]), count($diff[2]));
                    $delete = array_splice($diff[1], 0, $length, []);
                    $append = array_splice($diff[2], 0, $length, []);
                    for ($i = 0; $i < $length; $i++) {
                        $options2 = ['stringify' => null, 'lineno' => false] + $this->options;
                        $diffs2 = str_diff(preg_split('/(?<!^)(?!$)/u', $delete[$i]), preg_split('/(?<!^)(?!$)/u', $append[$i]), $options2);
                        //$diffs2 = str_diff(mb_split('(?<!^)(?!$)', $delete[$i]), mb_split('(?<!^)(?!$)', $append[$i]), $options2);
                        $result2 = [];
                        foreach ($diffs2 as $diff2) {
                            foreach ($rule[$diff2[0]] as $n => $tag) {
                                $nx = $n === 3 ? 1 : $n;
                                $content = $taging($tag, implode("", (array) $htmlescape($diff2[$nx])), null);
                                if (strlen($content)) {
                                    $result2[] = $content;
                                }
                            }
                        }
                        $result[] = implode("", $result2);
                    }
                }
                foreach ($rule[$diff[0]] as $n => $tag) {
                    $nx = $n === 3 ? 1 : $n;
                    $contents = [];
                    foreach ($diff[$nx] as $no => $line) {
                        $contents[] = $taging($tag, $htmlescape($line), $no);
                    }
                    $content = implode("\n", $contents);
                    if ($diff[0] === '=' && !strlen($content)) {
                        $result[] = "";
                    }
                    if (strlen($content)) {
                        $result[] = $content;
                    }
                }
            }
            return implode("\n", $result);
        }

        private function block($diffs, $block_size)
        {
            $head = fn($array) => array_slice($array, 0, $block_size, true);
            $tail = fn($array) => array_slice($array, -$block_size, null, true);

            $blocks = [];
            $block = [];
            $last = count($diffs) - 1;
            foreach ($diffs as $n => $diff) {
                if ($diff[0] !== '=') {
                    $block[] = $diff;
                    continue;
                }

                if (!$block) {
                    if ($block_size) {
                        $block[] = ['=', $tail($diff[1]), $tail($diff[2])];
                    }
                }
                elseif ($last === $n) {
                    if ($block_size) {
                        $block[] = ['=', $head($diff[1]), $head($diff[2])];
                    }
                }
                elseif (count($diff[1]) > $block_size * 2) {
                    if ($block_size) {
                        $block[] = ['=', $head($diff[1]), $head($diff[2])];
                    }
                    $blocks[] = $block;
                    $block = [];
                    if ($block_size) {
                        $block[] = ['=', $tail($diff[1]), $tail($diff[2])];
                    }
                }
                else {
                    if ($block_size) {
                        $block[] = $diff;
                    }
                }
            }
            if (trim(implode('', array_column($block, 0)), '=')) {
                $blocks[] = $block;
            }
            return $blocks;
        }

        private function recursive($diffs, $callback)
        {
            foreach ($diffs as $diff) {
                foreach (array_filter($diff, fn($v) => is_array($v)) as $n => $dd) {
                    foreach ($dd as $no => $d) {
                        if ($callback($d, $no, $n) === false) {
                            return false;
                        }
                    }
                }
            }
            return true;
        }

        private function color($string, $mode, $n)
        {
            $color = $this->options['color'][$mode] ?? null;
            if ($mode === '*' && $color === null) {
                $fallback = match ($n) {
                    1 => '-',
                    2 => '+',
                };
                $color = $this->options['color'][$fallback] ?? null;
            }

            if ($color !== null) {
                $string = ansi_colorize($string, $color);
            }
            return $string;
        }
    };

    return $differ($xstring, $ystring);
}
