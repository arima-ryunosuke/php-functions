<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/arrayize.php';
// @codeCoverageIgnoreEnd

/**
 * 連想配列を元に環境変数を取得する
 *
 * 配列のキーで取得するキーを指定できる。
 * 連番の場合は元の環境変数名がキーとして使用される。
 *
 * 環境変数が存在しない場合、false ではなく null になる。
 * 環境変数名に配列を与えた場合、順に取得を試みて、見つからなかった場合に null になる。
 *
 * キーが指定されておらず、さらに環境変数候補数が1以外で環境変数が見つからない場合は例外を投げる。
 * （返すキーが一意に定まらない場合に例外を投げる）。
 *
 * Example:
 * ```php
 * putenv('ENV1=env_1');
 * putenv('ENV2=env_2');
 * putenv('ENV3=env_3');
 *
 * that(getenvs([
 *     'ENV1',                           // キー指定がない
 *     'e2' => 'ENV2',                   // キー指定がある
 *     'e3' => ['ENV4', 'ENV3', 'ENV2'], // 配列の左から取得を試みる
 *     'e8' => 'ENV8',                   // 存在しない環境変数
 *     'e9' => ['ENV9', 'ENV8', 'ENV7'], // 存在しない環境変数配列
 * ]))->is([
 *     'ENV1' => 'env_1', // キー指定がない場合、環境変数名がキーになる
 *     'e2'   => 'env_2', // キー指定がある場合、それがキーになる
 *     'e3'   => 'env_3', // ENV3 が見つかった
 *     'e8'   => null,    // ENV8 が見つからないので null
 *     'e9'   => null,    // ENV9, ENV8, ENV7 のどれも見つからないので null
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\info
 *
 * @param iterable $env_vars [キー => 環境変数名]
 * @return array 環境変数
 */
function getenvs($env_vars)
{
    $result = [];
    foreach ($env_vars as $key => $varname) {
        $varname = arrayize($varname);
        foreach ($varname as $name) {
            $alias = is_int($key) ? $name : $key;
            $val = getenv($name, true);

            if ($val !== false) {
                $result[$alias] = $val;
                continue 2;
            }
        }

        if (is_int($key)) {
            if (count($varname) !== 1) {
                throw new \InvalidArgumentException('environment variable name is ambiguous');
            }
            $result[reset($varname)] = null;
        }
        else {
            $result[$key] = null;
        }
    }
    return $result;
}
