<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * DataURL をエンコードする
 *
 * $metadata で mimetype や エンコード等を指定できる。
 * 指定されていない場合、自動検出して埋め込まれる。
 *
 * - mimetype(?string): 特筆無し
 * - charset(?string): 自動検出は mime 名になる。明示指定はそのまま埋め込まれる
 * - base64(?bool): true:base64encode, false:urlencode, null: raw
 *   - null の raw はスキームとしては base64 となる。つまり既に base64 の文字列が手元にある場合（変換したくない場合）に指定する
 *
 * Example:
 * ```php
 * that(dataurl_encode("hello, world", ['base64' => false]))->isSame("data:text/plain;charset=US-ASCII,hello%2C%20world");
 * that(dataurl_encode("hello, world", ['mimetype' => 'text/csv', 'charset' => 'hoge']))->isSame("data:text/csv;charset=hoge;base64,aGVsbG8sIHdvcmxk");
 * ```
 *
 * @package ryunosuke\Functions\Package\url
 *
 * @param string $data エンコードするデータ
 * @param array $metadata エンコードオプション
 * @return string DataURL
 */
function dataurl_encode($data, $metadata = [])
{
    if (!isset($metadata['mimetype'], $metadata['charset'])) {
        try {
            $finfo = finfo_open();
            [$mimetype, $charset] = preg_split('#;\\s#', finfo_buffer($finfo, $data, FILEINFO_MIME), 2, PREG_SPLIT_NO_EMPTY);

            $metadata['mimetype'] ??= $mimetype;
            $metadata['charset'] ??= mb_preferred_mime_name(explode('=', $charset, 2)[1]);
        }
        finally {
            finfo_close($finfo);
        }
    }

    if (!array_key_exists('base64', $metadata)) {
        $metadata['base64'] = true;
    }

    $encoder = function ($data) use ($metadata) {
        if ($metadata['base64'] === null) {
            return $data;
        }

        if ($metadata['base64']) {
            return base64_encode($data);
        }
        else {
            return rawurlencode($data);
        }
    };

    return "data:"
        . $metadata['mimetype']
        . (strlen($metadata['charset']) ? ";charset=" . $metadata['charset'] : "")
        . (($metadata['base64'] ?? true) ? ';base64' : '')
        . "," . $encoder($data);
}
