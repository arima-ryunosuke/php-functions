<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_kmap.php';
require_once __DIR__ . '/../classobj/auto_loader.php';
require_once __DIR__ . '/../exec/process_async.php';
require_once __DIR__ . '/../info/php_binary.php';
require_once __DIR__ . '/../utility/function_configure.php';
require_once __DIR__ . '/../var/var_export3.php';
require_once __DIR__ . '/../constants.php';
// @codeCoverageIgnoreEnd

/**
 * ビルトインサーバーを起動する
 *
 * 単に別プロセスで php -S するだけなので本番では使用してはならない。
 * 少し小細工として下記を実装してある。
 *
 * - $router: クロージャを渡せる
 * - $options['last-modified']: true にすると存在するファイルの 304 キャッシュが有効になる
 *
 * @package ryunosuke\Functions\Package\utility
 *
 * @param string $document_root 公開ディレクトリ兼カレントディレクトリ
 * @param string|callable $router ルータースクリプト or クロージャ
 * @param array $options オプション配列
 * @return \ProcessAsync|object プロセスオブジェクト
 */
function built_in_server($document_root, $router = null, $options = [])
{
    $options += [
        'host'          => '0.0.0.0', // bind アドレス
        'port'          => 8000,      // bind ポート
        'last-modified' => true,      // 静的ファイルの 304 キャッシュの有効無効
        // php.ini のエントリ
        '-d'            => [
            'opcache.enable' => 1,
            'uopz.disable'   => 1, // built in server で uopz が有効だとおかしなエラーを吐くことを確認
        ],
    ];

    // @codeCoverageIgnoreStart
    $mimetypes = GENERAL_MIMETYPE;
    $response304 = static function () use ($mimetypes) {
        //$file = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI'];
        $file = $_SERVER['SCRIPT_FILENAME'];
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (file_exists($file) && $ext !== 'php') {
            $modifiedSince = filter_input(INPUT_SERVER, 'HTTP_IF_MODIFIED_SINCE');
            $lastModified = filemtime($file);
            if ($modifiedSince && strtotime($modifiedSince) >= $lastModified) {
                http_response_code(304);
                header('content-type:' . ($mimetypes[$ext] ?? 'text/plain'));
            }
            else {
                http_response_code(200);
                header('content-type:' . ($mimetypes[$ext] ?? 'text/plain'));
                header('last-modified:' . gmdate('D, d M Y H:i:s \G\M\T', $lastModified));
                readfile($file);
            }
            exit;
        }
    };
    // @codeCoverageIgnoreEnd

    $mainscript = null;
    if (is_string($router) && file_exists($router)) {
        $mainscript = $router;
    }
    elseif (is_callable($router)) {
        $autoload = array_merge([auto_loader()], function_configure('process.autoload'));
        $router_code = var_export3($router, true);
        $static_code = $options['last-modified'] ? var_export3($response304, true) . '();' : '';

        $maincode = '<?php
            $autoload = ' . var_export($autoload, true) . ';
            foreach ($autoload as $file) {
                require_once $file;
            }
            ' . $static_code . '
            return ' . $router_code . '();
        ';
        file_put_contents($mainscript = sys_get_temp_dir() . '/router-' . sha1($maincode) . '.php', $maincode);
    }
    elseif ($options['last-modified']) {
        $static_code = var_export3($response304, true) . '();';
        $maincode = '<?php
            ' . $static_code . '
            return false;
        ';
        file_put_contents($mainscript = sys_get_temp_dir() . '/router-' . sha1($maincode) . '.php', $maincode);
    }

    $process = process_async(php_binary(), array_filter([
        '-S' => "{$options['host']}:{$options['port']}",
        '-t' => $document_root,
        '-d' => array_kmap((array) $options['-d'], fn($v, $k) => is_int($k) ? $v : "$k=$v"),
        $mainscript,
    ], fn($v) => $v !== null), '', $stdout, $stderr, $document_root);

    return $process;
}
