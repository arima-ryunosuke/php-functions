<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../classobj/register_autoload_function.php';
// @codeCoverageIgnoreEnd

/**
 * メソッド呼び出しロガーを仕込む
 *
 * この関数はかなり実験的なもので、互換性を考慮しない。
 *
 * @package ryunosuke\Functions\Package\errorfunc
 *
 * @param \Psr\Log\LoggerInterface $logger 書き出すファイル名
 * @return mixed
 */
function set_trace_logger($logger, string $target)
{
    $GLOBALS['___trace_log_internal'] = function (string $file, int $line, string $class, string $method, array $args) use ($logger) {
        $logger->debug("", [
            'id'     => $_SERVER['UNIQUE_ID'] ?? str_pad($_SERVER['REQUEST_TIME_FLOAT'], 15, STR_PAD_RIGHT),
            'class'  => $class,
            'method' => $method,
            'args'   => $args,
            'file'   => $file,
            'line'   => $line,
        ]);
    };

    return register_autoload_function(function ($classname, $filename, $contents) use ($target) {
        if (preg_match($target, $classname)) {
            $contents ??= file_get_contents($filename);
            $contents = preg_replace_callback('#((final|public|protected|private|static)\s+){0,3}function\s+[_0-9a-z]+?\([^{]+\{#usmi', function ($m) {
                return $m[0] . "(\$GLOBALS['___trace_log_internal'] ?? fn() => null)(__FILE__, __LINE__ - 1, __CLASS__, __FUNCTION__, func_get_args());";
            }, $contents);
            return $contents;
        }
    });
}
