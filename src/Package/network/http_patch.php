<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../network/http_request.php';
// @codeCoverageIgnoreEnd

/**
 * {@link http_request() http_request} の PATCH 特化版
 *
 * @package ryunosuke\Functions\Package\network
 * @inheritdoc http_request()
 *
 * @param string $url 対象 URL
 * @param mixed $data パラメータ
 * @return mixed レスポンスボディ
 */
function http_patch($url, $data = [], $options = [], &$response_header = [], &$info = [])
{
    $default = [
        'url'    => $url,
        'method' => 'PATCH',
        'body'   => $data,
    ];
    return http_request($options + $default, $response_header, $info);
}
