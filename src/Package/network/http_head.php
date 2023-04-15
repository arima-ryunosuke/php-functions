<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../network/http_get.php';
// @codeCoverageIgnoreEnd

/**
 * {@link http_request() http_request} の HEAD 特化版
 *
 * @package ryunosuke\Functions\Package\network
 * @inheritdoc http_request()
 *
 * @param string $url 対象 URL
 * @param mixed $data パラメータ
 * @return array レスポンスヘッダ
 */
function http_head($url, $data = [], $options = [], &$response_header = [], &$info = [])
{
    $default = [
        'method'       => 'HEAD',
        CURLOPT_NOBODY => true,
    ];
    http_get($url, $data, $options + $default, $response_header, $info);
    return $response_header;
}
