<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../dataformat/csv_import.php';
require_once __DIR__ . '/../dataformat/json_import.php';
require_once __DIR__ . '/../dataformat/ltsv_import.php';
// @codeCoverageIgnoreEnd

/**
 * 指定ファイルを拡張子別に php の配列として読み込む
 *
 * 形式は拡張子で自動判別する。
 * その際、2重拡張子で hoge.sjis.csv のように指定するとそのファイルのエンコーディングを指定したことになる。
 *
 * Example:
 * ```php
 * // csv ファイルを読み込んで配列で返す
 * file_put_contents($csvfile = sys_get_temp_dir() . '/hoge.csv', 'a,b,c
 * 1,2,3
 * 4,5,6
 * 7,8,9
 * ');
 * that(file_get_arrays($csvfile))->isSame([
 *     ['a' => '1', 'b' => '2', 'c' => '3'],
 *     ['a' => '4', 'b' => '5', 'c' => '6'],
 *     ['a' => '7', 'b' => '8', 'c' => '9'],
 * ]);
 *
 * // sjis の json ファイルを読み込んで配列で返す
 * file_put_contents($jsonfile = sys_get_temp_dir() . '/hoge.sjis.json', '[
 * {"a": 1, "b": 2, "c": 3},
 * {"a": 4, "b": 5, "c": 6},
 * {"a": 7, "b": 8, "c": 9}
 * ]');
 * that(file_get_arrays($jsonfile))->isSame([
 *     ['a' => 1, 'b' => 2, 'c' => 3],
 *     ['a' => 4, 'b' => 5, 'c' => 6],
 *     ['a' => 7, 'b' => 8, 'c' => 9],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $filename 読み込むファイル名
 * @param array $options 各種オプション
 * @return array レコード配列
 */
function file_get_arrays($filename, $options = [])
{
    static $supported_encodings = null;
    if ($supported_encodings === null) {
        $supported_encodings = array_combine(array_map('strtolower', mb_list_encodings()), mb_list_encodings());
    }

    if (!file_exists($filename)) {
        throw new \InvalidArgumentException("$filename is not exists");
    }

    $internal_encoding = mb_internal_encoding();
    $mb_convert_encoding = function ($encoding, $contents) use ($internal_encoding) {
        if ($encoding !== $internal_encoding) {
            $contents = mb_convert_encoding($contents, $internal_encoding, $encoding);
        }
        return $contents;
    };

    $pathinfo = pathinfo($filename);
    $encoding = pathinfo($pathinfo['filename'], PATHINFO_EXTENSION);
    $encoding = $supported_encodings[strtolower($encoding)] ?? $internal_encoding;
    $extension = $pathinfo['extension'] ?? '';

    switch (strtolower($extension)) {
        default:
            throw new \InvalidArgumentException("ext '$extension' is not supported.");
        case 'php':
            return (array) require $filename;
        case 'csv':
            return (array) csv_import($mb_convert_encoding($encoding, file_get_contents($filename)), $options + ['structure' => true]);
        case 'json':
        case 'json5':
            return (array) json_import($mb_convert_encoding($encoding, file_get_contents($filename)), $options);
        case 'jsonl':
        case 'jsonl5':
            return (array) array_map(fn($json) => json_import($json, $options), $mb_convert_encoding($encoding, array_filter(file($filename, FILE_IGNORE_NEW_LINES), 'strlen')));
        case 'yml':
        case 'yaml':
            return (array) yaml_parse($mb_convert_encoding($encoding, file_get_contents($filename)), 0, $ndocs, $options);
        case 'xml':
            throw new \DomainException("ext '$extension' is supported in the future.");
        case 'ltsv':
            return (array) array_map(fn($ltsv) => ltsv_import($ltsv, $options), $mb_convert_encoding($encoding, array_filter(file($filename, FILE_IGNORE_NEW_LINES), 'strlen')));
    }
}
