<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_each.php';
require_once __DIR__ . '/../array/array_lookup.php';
// @codeCoverageIgnoreEnd

/**
 * $_FILES の構造を組み替えて $_POST などと同じにする
 *
 * $_FILES の配列構造はバグとしか思えないのでそれを是正する関数。
 * 第1引数 $files は指定可能だが、大抵は $_FILES であり、指定するのはテスト用。
 *
 * サンプルを書くと長くなるので例は{@source \ryunosuke\Test\Package\UtilityTest::test_get_uploaded_files() テストファイル}を参照。
 *
 * @package ryunosuke\Functions\Package\info
 *
 * @param ?array $files $_FILES の同じ構造の配列。省略時は $_FILES
 * @return array $_FILES を $_POST などと同じ構造にした配列
 */
function get_uploaded_files($files = null)
{
    $result = [];
    foreach (($files ?: $_FILES) as $name => $file) {
        if (is_array($file['name'])) {
            $file = get_uploaded_files(array_each($file['name'], function (&$carry, $dummy, $subkey) use ($file) {
                $carry[$subkey] = array_lookup($file, $subkey);
            }, []));
        }
        $result[$name] = $file;
    }
    return $result;
}
