<?php

namespace ryunosuke\Functions\Package;

class Utility
{
    /**
     * シンプルにキャッシュする
     *
     * この関数は get/set を兼ねる。
     * キャッシュがある場合はそれを返し、ない場合は $provider を呼び出してその結果をキャッシュしつつそれを返す。
     *
     * 内部キャッシュオブジェクトがあるならそれを使う。その場合リクエストを跨いでキャッシュされる。
     * 内部キャッシュオブジェクトがないあるいは $use_internal=false なら素の static 変数でキャッシュする。
     *
     * $provider に null を与えるとキャッシュの削除となる。
     *
     * Example:
     * ```php
     * $provider = function(){return rand();};
     * // 乱数を返す処理だが、キャッシュされるので同じ値になる
     * $rand1 = cache('rand', $provider);
     * $rand2 = cache('rand', $provider);
     * assertSame($rand1, $rand2);
     * // $provider に null を与えると削除される
     * cache('rand', null);
     * $rand3 = cache('rand', $provider);
     * assertNotSame($rand1, $rand3);
     * ```
     *
     * @param string $key キャッシュのキー
     * @param callable $provider キャッシュがない場合にコールされる callable
     * @param string $namespace 名前空間
     * @param bool $use_internal 内部キャッシュオブジェクトを使うか
     * @return mixed キャッシュ
     */
    public static function cache($key, $provider, $namespace = null, $use_internal = true)
    {
        if ($namespace === null) {
            $namespace = __FILE__;
        }

        // 内部オブジェクトが使えるなら使う
        if ($use_internal && class_exists(\ryunosuke\Functions\Cacher::class)) {
            if ($provider === null) {
                return \ryunosuke\Functions\Cacher::delete($namespace, $key);
            }
            return \ryunosuke\Functions\Cacher::put($namespace, $key, $provider);
        }

        static $cache = [];
        if ($provider === null) {
            $return = isset($cache[$namespace][$key]);
            unset($cache[$namespace][$key]);
            return $return;
        }
        if (!isset($cache[$namespace])) {
            $cache[$namespace] = [];
        }
        if (!array_key_exists($key, $cache[$namespace])) {
            $cache[$namespace][$key] = $provider();
        }
        return $cache[$namespace][$key];
    }

    /**
     * エラー出力する
     *
     * 第1引数 $message はそれらしく文字列化されて出力される。基本的にはあらゆる型を与えて良い。
     *
     * 第2引数 $destination で出力対象を指定する。省略すると error_log 設定に従う。
     * 文字列を与えるとファイル名とみなし、ファイルに追記される。
     * ファイルを開くが、**ファイルは閉じない**。閉じ処理は php の終了処理に身を任せる。
     * したがって閉じる必要がある場合はファイルポインタを渡す必要がある。
     *
     * @param string|mixed $message 出力メッセージ
     * @param resource|string|mixed $destination 出力先
     * @return int 書き込んだバイト数
     */
    public static function error($message, $destination = null)
    {
        static $persistences = [];

        $time = date('d-M-Y H:i:s e');
        $content = call_user_func(stringify, $message);
        $location = '';
        if (!($message instanceof \Exception || $message instanceof \Throwable)) {
            foreach (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS) as $trace) {
                if (isset($trace['file'], $trace['line'])) {
                    $location = " in {$trace['file']} on line {$trace['line']}";
                    break;
                }
            }
        }
        $line = "[$time] PHP Log:  $content$location\n";

        if ($destination === null) {
            $destination = ini_get('error_log');
        }

        if ($destination === 'syslog') {
            syslog(LOG_INFO, $message);
            return strlen($line);
        }

        if (is_resource($destination)) {
            $fp = $destination;
        }
        elseif (is_string($destination)) {
            if (!isset($persistences[$destination])) {
                $persistences[$destination] = fopen($destination, 'a');
            }
            $fp = $persistences[$destination];
        }

        if (empty($fp)) {
            throw new \InvalidArgumentException('$destination must be resource or string.');
        }

        flock($fp, LOCK_EX);
        fwrite($fp, $line);
        flock($fp, LOCK_UN);

        return strlen($line);
    }

    /**
     * 簡易ベンチマークを取る
     *
     * 「指定ミリ秒内で何回コールできるか？」でベンチする。
     *
     * $suite は ['表示名' => $callable] 形式の配列。
     * 表示名が与えられていない場合、それらしい名前で表示する。
     *
     * Example:
     * ```php
     * // intval と int キャストはどちらが早いか調べる
     * benchmark([
     *     'intval',
     *     'intcast' => function($v){return (int)$v;},
     * ], ['12345'], 10);
     * ```
     *
     * @param array|callable $suite ベンチ対象処理
     * @param array $args 各ケースに与えられる引数
     * @param int $millisec 呼び出しミリ秒
     * @param bool $output true だと標準出力に出力される
     * @return array ベンチ結果の配列
     */
    public static function benchmark($suite, $args = [], $millisec = 1000, $output = true)
    {
        $benchset = [];
        foreach (call_user_func(arrayize, $suite) as $name => $caller) {
            if (!is_callable($caller, false, $callname)) {
                throw new \InvalidArgumentException('caller is not callable.');
            }

            if (is_int($name)) {
                // クロージャは "Closure::__invoke" になるので "ファイル#開始行-終了行" にする
                if ($caller instanceof \Closure) {
                    $ref = new \ReflectionFunction($caller);
                    $callname = $ref->getFileName() . '#' . $ref->getStartLine() . '-' . $ref->getEndLine();
                }
                $name = $callname;
            }

            if (isset($benchset[$name])) {
                throw new \InvalidArgumentException('duplicated benchname.');
            }

            $benchset[$name] = call_user_func(closurize, $caller);
        }

        if (!$benchset) {
            throw new \InvalidArgumentException('benchset is empty.');
        }

        // ウォームアップ兼検証（大量に実行してエラーの嵐になる可能性があるのでウォームアップの時点でエラーがないかチェックする）
        $assertions = call_user_func(call_safely, function ($benchset, $args) {
            return call_user_func(array_lmap, $benchset, 'call_user_func_array', $args);
        }, $benchset, $args);

        // 返り値の検証（ベンチマークという性質上、基本的に戻り値が一致しないのはおかしい）
        // rand/mt_rand, md5/sha1 のような例外はあるが、そんなのベンチしないし、クロージャでラップすればいいし、それでも邪魔なら @ で黙らせればいい
        foreach ($assertions as $name1 => $return1) {
            foreach ($assertions as $name2 => $return2) {
                if ($return1 !== null && $return2 !== null && $return1 !== $return2) {
                    $returns1 = call_user_func(stringify, $return1);
                    $returns2 = call_user_func(stringify, $return2);
                    trigger_error("Results of $name1 and $name2 are different. ($returns1, $returns2)");
                }
            }
        }

        // ベンチ
        $counts = [];
        foreach ($benchset as $name => $caller) {
            $end = microtime(true) + $millisec / 1000;
            for ($n = 0; microtime(true) <= $end; $n++) {
                call_user_func_array($caller, $args);
            }
            $counts[$name] = $n;
        }

        // 結果配列
        $result = [];
        $maxcount = max($counts);
        arsort($counts);
        foreach ($counts as $name => $count) {
            $result[] = [
                'name'   => $name,
                'called' => $count,
                'mills'  => $millisec / $count,
                'ratio'  => $maxcount / $count,
            ];
        }

        // 出力するなら出力
        if ($output) {
            $nlength = max(5, max(array_map('strlen', array_keys($benchset))));
            $slength = 9;
            $olength = 12;
            $rlength = 6;
            $defformat = "| %-{$nlength}s | %{$slength}s | %{$olength}s | %{$rlength}s |";
            $sepformat = "| %'-{$nlength}s | %'-{$slength}s:| %'-{$olength}s:| %'-{$rlength}s:|";

            $template = <<<'RESULT'
Running %count$s cases (between %millsec$s ms):
%header$s
%separator$s
%summary$s

RESULT;
            echo call_user_func(kvsprintf, $template, [
                'count'     => count($benchset),
                'millsec'   => number_format($millisec),
                'header'    => sprintf($defformat, 'name', 'called', '1 call(ms)', 'ratio'),
                'separator' => sprintf($sepformat, '', '', '', ''),
                'summary'   => implode("\n", array_map(function ($data) use ($defformat) {
                    return vsprintf($defformat, [
                            $data['name'],
                            number_format($data['called']),
                            number_format($data['mills'] * 1000, 6),
                            number_format($data['ratio'], 3),
                        ]
                    );
                }, $result)),
            ]);
        }

        return $result;
    }
}
