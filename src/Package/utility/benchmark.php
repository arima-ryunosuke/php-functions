<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/arrayize.php';
require_once __DIR__ . '/../dataformat/markdown_table.php';
require_once __DIR__ . '/../funchand/call_safely.php';
require_once __DIR__ . '/../info/ini_sets.php';
require_once __DIR__ . '/../info/is_ansi.php';
require_once __DIR__ . '/../var/var_pretty.php';
// @codeCoverageIgnoreEnd

/**
 * 簡易ベンチマークを取る
 *
 * 「指定ミリ秒内で何回コールできるか？」でベンチする。
 *
 * $suite は ['表示名' => $callable] 形式の配列。
 * 表示名が与えられていない場合、それらしい名前で表示する。
 *
 * Example:
 * ```php
 * // intval と int キャストはどちらが早いか調べる
 * benchmark([
 *     'intval',
 *     'intcast' => fn($v) => (int) $v,
 * ], ['12345'], 10);
 * ```
 *
 * @package ryunosuke\Functions\Package\utility
 *
 * @param array|callable $suite ベンチ対象処理
 * @param array $args 各ケースに与えられる引数
 * @param int $millisec 呼び出しミリ秒
 * @param bool $output true だと標準出力に出力される
 * @return array ベンチ結果の配列
 */
function benchmark($suite, $args = [], $millisec = 1000, $output = true)
{
    $benchset = [];
    foreach (arrayize($suite) as $name => $caller) {
        if (!is_callable($caller, false, $callname)) {
            throw new \InvalidArgumentException('caller is not callable.');
        }

        if (is_int($name)) {
            // クロージャは "Closure::__invoke" になるので "ファイル#開始行-終了行" にする
            if ($caller instanceof \Closure) {
                $ref = new \ReflectionFunction($caller);
                $callname = $ref->getFileName() . '#' . $ref->getStartLine() . '-' . $ref->getEndLine();
            }
            $name = $callname;
        }

        if (isset($benchset[$name])) {
            throw new \InvalidArgumentException('duplicated benchname.');
        }

        $benchset[$name] = \Closure::fromCallable($caller);
    }

    if (!$benchset) {
        throw new \InvalidArgumentException('benchset is empty.');
    }

    // opcache を利用するようなベンチはこの辺を切っておかないと正確な結果にならない
    // ウォームアップで mtime が更新され、その1秒以内にベンチが走るので一切 opcache が効かなくなるため
    $restore = ini_sets([
        'opcache.validate_timestamps'    => 0,
        'opcache.file_update_protection' => "0",
    ]);

    // ウォームアップ兼検証（大量に実行してエラーの嵐になる可能性があるのでウォームアップの時点でエラーがないかチェックする）
    $assertions = call_safely(function ($benchset, $args) {
        $result = [];
        $args2 = $args;
        foreach ($benchset as $name => $caller) {
            $result[$name] = $caller(...$args2);
        }
        return $result;
    }, $benchset, $args);

    // 返り値の検証（ベンチマークという性質上、基本的に戻り値が一致しないのはおかしい）
    // rand/mt_rand, md5/sha1 のような例外はあるが、そんなのベンチしないし、クロージャでラップすればいいし、それでも邪魔なら @ で黙らせればいい
    $context = is_ansi(STDOUT) ? 'cli' : 'plain';
    $diffs = [];
    foreach ($assertions as $name => $return) {
        $diffs[var_pretty($return, [
            'context' => $context,
            'limit'   => 1024,
            'return'  => true,
        ])][] = $name;
    }
    if (count($diffs) > 1) {
        $head = $body = [];
        foreach ($diffs as $return => $names) {
            $head[] = count($names) === 1 ? $names[0] : '(' . implode(' | ', $names) . ')';
            $body[implode("\n", $names)] = ['return' => $return];
        }
        trigger_error(sprintf("Results of %s are different.\n", implode(' & ', $head)));
        if (error_reporting() & E_USER_NOTICE) {
            // @codeCoverageIgnoreStart
            echo markdown_table($body, [
                'context'  => $context,
                'keylabel' => 'name',
            ]);
            // @codeCoverageIgnoreEnd
        }
    }

    // ベンチ
    $counts = [];
    foreach ($benchset as $name => $caller) {
        $end = microtime(true) + $millisec / 1000;
        $args2 = $args;
        for ($n = 0; microtime(true) <= $end; $n++) {
            $caller(...$args2);
        }
        $counts[$name] = $n;
    }

    $restore();

    // 結果配列
    $result = [];
    $maxcount = max($counts);
    arsort($counts);
    foreach ($counts as $name => $count) {
        $result[] = [
            'name'   => $name,
            'called' => $count,
            'mills'  => $millisec / $count,
            'ratio'  => $maxcount / $count,
        ];
    }

    // 出力するなら出力
    if ($output) {
        printf("Running %s cases (between %s ms):\n", count($benchset), number_format($millisec));
        echo markdown_table(array_map(function ($v) {
            return [
                'name'       => $v['name'],
                'called'     => number_format($v['called'], 0),
                '1 call(ms)' => number_format($v['mills'], 6),
                'ratio'      => number_format($v['ratio'], 3),
            ];
        }, $result));
    }

    return $result;
}
