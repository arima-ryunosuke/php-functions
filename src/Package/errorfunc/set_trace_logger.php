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
 * @param resource|string $logfile 書き出すファイル名
 * @param string $target 仕込むクラスの正規表現
 * @return mixed
 */
function set_trace_logger($logfile, $liner, string $target)
{
    $logfile = is_string($logfile) ? fopen($logfile, 'a') : $logfile; // for testing
    $liner ??= function ($values) {
        $stringify = function ($value, &$total = 0) use (&$stringify) {
            if (is_array($value)) {
                $result = [];
                $n = 0;
                foreach ($value as $k => $v) {
                    if (++$total > 10) {
                        $result[] = '...';
                        break;
                    }
                    $v = $stringify($v, $total);
                    if ($k === $n) {
                        $result[] = $v;
                    }
                    else {
                        $result[] = "$k:$v";
                    }
                    $n++;
                }
                return "[" . implode(",", $result) . "]";
            }
            if (is_object($value)) {
                return get_class($value) . "#" . spl_object_id($value);
            }
            if (is_resource($value)) {
                return (string) $value;
            }
            return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        };
        $values['time'] = $values['time']->format('Y-m-d\TH:i:s.v');
        $values['args'] = implode(', ', array_map($stringify, $values['args']));
        return vsprintf("[%s] %s %s::%s(%s);%s:%d\n", $values);
    };

    $GLOBALS['___trace_log_internal'] = function (string $file, int $line, string $class, string $method) use ($logfile, $liner) {
        fwrite($logfile, $liner([
            'id'     => $_SERVER['UNIQUE_ID'] ?? str_pad($_SERVER['REQUEST_TIME_FLOAT'], 15, STR_PAD_RIGHT),
            'time'   => new \DateTime(),
            'class'  => $class,
            'method' => $method,
            'args'   => debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2)[1]['args'] ?? [],
            'file'   => $file,
            'line'   => $line,
        ]));
    };

    return register_autoload_function(function ($classname, $filename, $contents) use ($target) {
        if (preg_match($target, $classname)) {
            $contents ??= file_get_contents($filename);
            $contents = preg_replace_callback('#((final|public|protected|private|static)\s+){0,3}function\s+[_0-9a-z]+?\([^{]+\{#usmi', function ($m) {
                return $m[0] . "(\$GLOBALS['___trace_log_internal'] ?? fn() => null)(__FILE__, __LINE__ - 1, __CLASS__, __FUNCTION__);";
            }, $contents);
            return $contents;
        }
    });
}
