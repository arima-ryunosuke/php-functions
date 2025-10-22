<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../database/sql_quote.php';
// @codeCoverageIgnoreEnd

/**
 * 連想配列の配列を SQL 的文字列に変換する
 *
 * xlsx か何かで提供されたファイルを SQL に変換したい状況はままある。
 * 保守運用などでの使用を想定しており、この関数で得られた SQL を**確認せずに実行してはならない**。
 *
 * カラムの読み替えやエンコーディングの変換などは行わない（それは入力元である $array の前処理の仕事）。
 * とはいえ iterable が来ることもあるので callback で簡単なフィルタ・変換は可能。
 *
 * 識別子のエスケープは一切しないので留意。
 *
 * Example:
 * ```php
 * $arrays = [
 *     ['id' => 1, 'name' => 'hoge'],
 *     ['id' => 2, 'name' => 'fuga'],
 *     ['id' => 3, 'name' => 'piyo'],
 * ];
 * // insert
 * that(sql_export($arrays, ['table' => 't_table']))->isSame(<<<SQL
 * INSERT INTO t_table(id, name) VALUES(1, 'hoge');
 * INSERT INTO t_table(id, name) VALUES(2, 'fuga');
 * INSERT INTO t_table(id, name) VALUES(3, 'piyo');
 *
 * SQL,);
 * // upsert
 * that(sql_export($arrays, ['table' => 't_table', 'upsert' => 'id']))->isSame(<<<SQL
 * INSERT INTO t_table(id, name) VALUES(1, 'hoge') ON CONFLICT(id) DO UPDATE SET id = excluded.id, name = excluded.name;
 * INSERT INTO t_table(id, name) VALUES(2, 'fuga') ON CONFLICT(id) DO UPDATE SET id = excluded.id, name = excluded.name;
 * INSERT INTO t_table(id, name) VALUES(3, 'piyo') ON CONFLICT(id) DO UPDATE SET id = excluded.id, name = excluded.name;
 *
 * SQL,);
 * // bulk insert
 * that(sql_export($arrays, ['table' => 't_table', 'bulk' => true]))->isSame(<<<SQL
 * INSERT INTO t_table(id, name) VALUES
 *   (1, 'hoge'),
 *   (2, 'fuga'),
 *   (3, 'piyo');
 *
 * SQL,);
 * // bulk upsert
 * that(sql_export($arrays, ['table' => 't_table', 'bulk' => true, 'upsert' => 'id']))->isSame(<<<SQL
 * INSERT INTO t_table(id, name) VALUES
 *   (1, 'hoge'),
 *   (2, 'fuga'),
 *   (3, 'piyo')
 * ON CONFLICT(id) DO UPDATE SET id = excluded.id, name = excluded.name;
 *
 * SQL,);
 * ```
 *
 * @package ryunosuke\Functions\Package\database
 *
 * @param iterable $sqlarrays 連想配列の配列
 * @param array $options オプション配列
 * @return string SQL 的文字列
 */
function sql_export($sqlarrays, $options = []): string
{
    $options += [
        'table'     => '',       // テーブル名（必須）
        'rdbms'     => 'sqlite', // 対象 RDBMS(sqlite|mysql|pgsql) これで SET や upsert 構文が変化する
        'bulk'      => false,    // BULK INSERT モード
        'upsert'    => '',       // DUPLICATE(mysql), CONFLICT(pgsql) 等の付与
        'delimiter' => ';',      // 複文のデリミタ
        'literal'   => \Stringable::class, // エスケープしないオブジェクト
        'callback'  => null,     // map + filter 用コールバック（1行が参照で渡ってくるので書き換えられる&&false を返すと結果から除かれる）
    ];

    assert(strlen($options['table']));
    assert(strlen($options['delimiter']));
    assert(in_array($options['rdbms'], ['sqlite', 'mysql', 'pgsql'], true));

    $implode = fn($array, $separator = ', ') => implode($separator, $array);

    $columns = null;
    $result = [];
    foreach ($sqlarrays as $n => $sqlarray) {
        if ($options['callback']) {
            if ($options['callback']($sqlarray, $n) === false) {
                continue;
            }
        }

        $vals = array_map(function ($v) use ($options) {
            if (is_a($v, $options['literal'])) {
                return $v;
            }
            return sql_quote($v);
        }, $sqlarray);

        if ($options['bulk']) {
            $cols = array_keys($vals);

            $comma = ',';
            if (!isset($columns)) {
                $comma = '';
                $columns = $cols;
                $result[] = "INSERT INTO {$options['table']}({$implode($columns)}) VALUES";
            }
            elseif ($columns !== $cols) {
                throw new \UnexpectedValueException("columns is mismatch(first:{$implode($columns)} vs $n:{$implode($cols)})");
            }
            $result[] = "$comma\n  ({$implode($vals)})";
        }
        elseif ($options['rdbms'] === 'mysql') {
            $sets = array_map(fn($v, $k) => "$k = $v", $vals, array_keys($vals));
            $result[] = "INSERT INTO {$options['table']} SET {$implode($sets)}";

            if (strlen($options['upsert'])) {
                $excludeds = array_map(fn($v) => "$v = excluded.$v", array_keys($vals));
                $result[] = array_pop($result) . " AS excluded ON DUPLICATE KEY UPDATE {$implode($excludeds)}";
            }
        }
        else {
            $cols = array_keys($vals);
            $result[] = "INSERT INTO {$options['table']}({$implode($cols)}) VALUES({$implode($vals)})";

            if (strlen($options['upsert'])) {
                $excludeds = array_map(fn($v) => "$v = excluded.$v", $cols);
                $result[] = array_pop($result) . " ON CONFLICT({$options['upsert']}) DO UPDATE SET {$implode($excludeds)}";
            }
        }
    }

    if (!$result) {
        return '';
    }

    if ($options['bulk'] && strlen($options['upsert'])) {
        $excludeds = array_map(fn($v) => "$v = excluded.$v", $columns);

        if ($options['rdbms'] === 'mysql') {
            $result[] = "\nAS excluded ON DUPLICATE KEY UPDATE {$implode($excludeds)}";
        }
        else {
            $result[] = "\nON CONFLICT({$options['upsert']}) DO UPDATE SET {$implode($excludeds)}";
        }
    }

    $delimiter = "{$options['delimiter']}\n";
    return implode($options['bulk'] ? "" : $delimiter, $result) . $delimiter;
}
