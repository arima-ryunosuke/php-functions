<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/is_resourcable.php';
// @codeCoverageIgnoreEnd

/**
 * 本ライブラリの設定を行う
 *
 * 各関数の挙動を変えたり、デフォルトオプションを設定できる。
 *
 * @package ryunosuke\Functions\Package\utility
 *
 * @param array|?string $option 設定。文字列指定時はその値を返す
 * @return array|string 設定値
 */
function function_configure($option)
{
    static $config = [];

    // default
    $config['cachedir'] ??= sys_get_temp_dir() . DIRECTORY_SEPARATOR . strtr(__NAMESPACE__, ['\\' => '%']);
    $config['storagedir'] ??= DIRECTORY_SEPARATOR === '/' ? '/var/tmp/rf' : (getenv('ALLUSERSPROFILE') ?: sys_get_temp_dir()) . '\\rf';
    $config['placeholder'] ??= '';
    $config['var_stream'] ??= get_cfg_var('rfunc.var_stream') ?: 'VarStreamV010000';          // for compatible
    $config['memory_stream'] ??= get_cfg_var('rfunc.memory_stream') ?: 'MemoryStreamV010000'; // for compatible
    $config['chain.version'] ??= 1;
    $config['chain.nullsafe'] ??= false;
    $config['process.autoload'] ??= [];

    // setting
    if (is_array($option)) {
        foreach ($option as $name => $entry) {
            $option[$name] = $config[$name] ?? null;
            switch ($name) {
                default:
                    $config[$name] = $entry;
                    break;
                case 'cachedir':
                case 'storagedir':
                    $entry ??= $config[$name];
                    if (!file_exists($entry)) {
                        @mkdir($entry, 0777 & (~umask()), true);
                    }
                    $config[$name] = realpath($entry);
                    break;
                case 'placeholder':
                    if (strlen($entry)) {
                        $entry = ltrim($entry[0] === '\\' ? $entry : __NAMESPACE__ . '\\' . $entry, '\\');
                        if (!defined($entry)) {
                            define($entry, tmpfile() ?: [] ?: '' ?: 0.0 ?: null ?: false);
                        }
                        if (!is_resourcable(constant($entry))) {
                            // もしリソースじゃないと一意性が保てず致命的になるので例外を投げる
                            throw new \RuntimeException('placeholder is not resource'); // @codeCoverageIgnore
                        }
                        $config[$name] = $entry;
                    }
                    break;
            }
        }
        return $option;
    }

    // getting
    if ($option === null) {
        return $config;
    }
    if (is_string($option)) {
        switch ($option) {
            default:
                return $config[$option] ?? null;
            case 'cachedir':
            case 'storagedir':
                $dirname = $config[$option];
                if (!file_exists($dirname)) {
                    @mkdir($dirname, 0777 & (~umask()), true); // @codeCoverageIgnore
                }
                return realpath($dirname);
        }
    }

    throw new \InvalidArgumentException(sprintf('$option is unknown type(%s)', gettype($option)));
}
