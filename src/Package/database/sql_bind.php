<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../database/sql_quote.php';
require_once __DIR__ . '/../strings/str_embed.php';
require_once __DIR__ . '/../var/arrayval.php';
// @codeCoverageIgnoreEnd

/**
 * ものすごく雑に SQL に値を埋め込む
 *
 * 非常に荒くアドホックに実装しているのでこの関数で得られた SQL を**実際に実行してはならない**。
 * あくまでログ出力やデバッグ用途で視認性を高める目的である。
 *
 * プレースホルダは ? か :alnum で混在していても良い。
 *
 * Example:
 * ```php
 * that(sql_bind('select ?', 1))->isSame("select 1");
 * that(sql_bind('select :hoge', ['hoge' => 'hoge']))->isSame("select 'hoge'");
 * that(sql_bind('select ?, :hoge', [1, 'hoge' => 'hoge']))->isSame("select 1, 'hoge'");
 * ```
 *
 * @package ryunosuke\Functions\Package\database
 *
 * @param string $sql 値を埋め込む SQL
 * @param array|mixed $values 埋め込む値
 * @return mixed 値が埋め込まれた SQL
 */
function sql_bind($sql, $values)
{
    $embed = [];
    foreach (arrayval($values, false) as $k => $v) {
        if (is_int($k)) {
            $embed['?'][] = sql_quote($v);
        }
        else {
            $embed[":$k"] = sql_quote($v);
        }
    }

    return str_embed($sql, $embed, [
        "'"   => "'",
        '"'   => '"',
        '-- ' => "\n",
        '/*'  => "*/",
    ]);
}
