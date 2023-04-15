<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../network/http_request.php';
require_once __DIR__ . '/../var/is_empty.php';
// @codeCoverageIgnoreEnd

/**
 * {@link http_request() http_request} の GET 特化版
 *
 * @package ryunosuke\Functions\Package\network
 * @inheritdoc http_request()
 *
 * @param string $url 対象 URL
 * @param mixed $data パラメータ
 * @return mixed レスポンスボディ
 */
function http_get($url, $data = [], $options = [], &$response_header = [], &$info = [])
{
    if (!is_empty($data, true)) {
        $url .= (strrpos($url, '?') === false ? '?' : '&') . (is_array($data) || is_object($data) ? http_build_query($data) : $data);
    }
    $default = [
        'url'    => $url,
        'method' => 'GET',
    ];
    return http_request($options + $default, $response_header, $info);
}
