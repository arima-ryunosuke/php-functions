<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/mb_ereg_options.php';
require_once __DIR__ . '/../strings/mb_ereg_split.php';
// @codeCoverageIgnoreEnd

/**
 * テキストに patch を当てる
 *
 * diff 形式は現在のところ unified のみ。
 * reject の仕様はなく、ハンクが一つでも検出・適用不可なら例外を投げる。
 *
 * Example:
 * ```php
 * $xstring = <<<HERE
 * equal line
 * delete line
 * equal line
 * HERE;
 * $ystring = <<<HERE
 * equal line
 * equal line
 * append line
 * HERE;
 * // xstring から ystring へのパッチ
 * $patch = str_diff($xstring, $ystring, ['stringify' => 'unified=3']);
 * // xstring に適用すれば ystring になる
 * that(str_patch($xstring, $patch))->isSame($ystring);
 * // ystring に reverse で適用すれば xstring に戻る
 * that(str_patch($ystring, $patch, ['reverse' => true]))->isSame($xstring);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 文字列
 * @param string $patch パッチ文字列
 * @param array $options オプション配列
 * @return string パッチ適用結果
 */
function str_patch($string, $patch, $options = [])
{
    $options += [
        'encoding' => null,
        'format'   => 'unified', // パッチ形式（未実装。現在は unified のみ）
        'fuzz'     => 0,         // ハンク検出失敗時に同一行を伏せる量（未実装でおそらく実装しない。diff 側でせっかく出力してるのに無視するのはもったいない）
        'reverse'  => false,     // 逆パッチフラグ
        'forward'  => false,     // 既に当たっているなら例外を投げずにスルーする
    ];

    // 空文字の時は特別扱いで「差分なし」とみなす（差分がないなら diff 結果が空文字になるので必然的に渡ってくる機会が多くなる）
    if (!strlen($patch)) {
        return $string;
    }

    $recover = mb_ereg_options([
        'encoding'      => $options['encoding'],
        'regex_options' => 'r',
    ]);

    $parts = mb_ereg_split('(^@@\s+-\d+(?:,\d+)?\s+\+\d+(?:,\d+)?\s+@@\r?\n)', $patch, -1, PREG_SPLIT_DELIM_CAPTURE);
    $comment = array_shift($parts);
    assert(is_string($comment) && count($parts) % 2 === 0);
    if (!$parts) {
        throw new \InvalidArgumentException('$patch is invalid');
    }

    $matches = [];
    foreach (array_chunk($parts, 2) as $chunk) {
        mb_ereg('^@@\s+-(?<oldpos>\d+)(,(?<oldlen>\d+))?\s+\+(?<newpos>\d+)(,(?<newlen>\d+))?\s+@@\r?\n', $chunk[0], $match);
        $matches[] = array_map(fn($m) => $m === false ? null : $m, $match) + ['diff' => $chunk[1]];
    }

    $hunks = [];
    foreach ($matches as $match) {
        $hunk = new class($match['oldpos'], $match['oldlen'], $match['newpos'], $match['newlen'], $match['diff']) {
            private int $oldOffset;
            private int $oldLength;

            private int $newOffset;
            private int $newLength;

            private array $diffs;

            private int   $oldOriginalOffset;
            private int   $newOriginalOffset;
            private array $oldContents = [];
            private array $newContents = [];

            public function __construct($oldpos, $oldlen, $newpos, $newlen, $diff)
            {
                $this->oldOffset = $oldpos - 1;
                $this->oldLength = $oldlen ?? 1;
                $this->newOffset = $newpos - 1;
                $this->newLength = $newlen ?? 1;
                $this->diffs = mb_ereg_split('\\R', $diff, -1, PREG_SPLIT_NO_EMPTY);

                $this->oldOriginalOffset = $this->oldOffset;
                $this->newOriginalOffset = $this->newOffset;

                foreach ($this->diffs as $diff) {
                    switch ($diff[0]) {
                        case ' ':
                            $this->oldContents[] = $this->newContents[] = substr($diff, 1);
                            break;
                        case '-':
                            $this->oldContents[] = substr($diff, 1);
                            break;
                        case '+':
                            $this->newContents[] = substr($diff, 1);
                            break;
                    }
                }

                assert($this->oldLength === count($this->oldContents));
                assert($this->newLength === count($this->newContents));
            }

            public function reverse()
            {
                [
                    $this->oldOriginalOffset,
                    $this->oldOffset,
                    $this->oldLength,
                    $this->oldContents,
                    $this->newOriginalOffset,
                    $this->newOffset,
                    $this->newLength,
                    $this->newContents,
                ] = [
                    $this->newOriginalOffset,
                    $this->newOriginalOffset, // ミスではない
                    $this->newLength,
                    $this->newContents,
                    $this->oldOriginalOffset,
                    $this->oldOriginalOffset, // ミスではない
                    $this->oldLength,
                    $this->oldContents,
                ];
            }

            public function detect(array $lines, int $delta)
            {
                $nearest = static function (int $start, int $min, int $max) {
                    yield 0;
                    for ($delta = 1, $limit = max($start - $min, $max - $start); $delta <= $limit; $delta++) {
                        if (($start - $delta) >= $min) {
                            yield -$delta;
                        }
                        if (($start + $delta) <= $max) {
                            yield +$delta;
                        }
                    }
                };

                foreach ($nearest($this->oldOffset + $delta, 0, count($lines) - $this->oldLength) as $offset) {
                    if ($this->oldContents === array_slice($lines, $this->oldOffset + $offset, $this->oldLength)) {
                        $this->oldOffset += $offset;
                        return $offset;
                    }
                }

                throw new \UnexpectedValueException("not found hunk block\n" . implode("\n", $this->diffs));
            }

            public function apply(int &$current, array $lines)
            {
                $result = array_merge(array_slice($lines, $current, $this->oldOffset - $current), $this->newContents);
                $current = $this->oldOffset + $this->oldLength;

                return $result;
            }
        };

        if ($options['reverse']) {
            $hunk->reverse();
        }

        $hunks[] = $hunk;
    }

    $apply = function ($hunks, $lines) {
        $delta = 0;
        $current = 0;
        $result = [];
        foreach ($hunks as $hunk) {
            $delta = $hunk->detect($lines, $delta);

            $result = array_merge($result, $hunk->apply($current, $lines));
        }
        $result = array_merge($result, array_slice($lines, $current));

        return implode("\n", $result);
    };

    try {
        $lines = mb_split('\\R', $string);
        return $apply($hunks, $lines);
    }
    catch (\Exception $e) {
        // reverse で当ててみて例外が飛ばないなら元の文字列を返す
        if ($options['forward']) {
            foreach ($hunks as $hunk) {
                $hunk->reverse();
            }
            $apply($hunks, $lines);
            return $string;
        }
        throw $e;
    }
    finally {
        $recover();
    }
}
