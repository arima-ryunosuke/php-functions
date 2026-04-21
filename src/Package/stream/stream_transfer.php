<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../var/timeval.php';
// @codeCoverageIgnoreEnd

/**
 * ストリームの転送を並列で行う
 *
 * $streams は下記の配列を指定する。
 * ```
 * [
 *     'read'  => resource|string|callable, // 読み込み対象
 *     'write' => resource|string|callable, // 書き込み対象
 *     'done'  => callable, // 完了時コールバック
 *     'fail'  => callable, // 失敗時コールバック
 * ]
 * ```
 *
 * ローカルストリームはファイル名で渡すことが多いので、文字列が来たら fopen する。
 * 大量に実行したい場合に全て fopen したくない場合は callable を渡せば必要に応じてコールされる。
 *
 * done, fail 成功/失敗時にコールされるがほぼオマケ。
 * 未指定だと成功時 size, 失敗時 null が格納される。
 *
 * @package ryunosuke\Functions\Package\stream
 *
 * @param array<array{read:resource|string|callable, write:resource|string|callable, done?:callable, fail?:callable}> $streams
 */
function stream_transfer(array $streams, array $options = []): array
{
    $options += [
        'concurrency'   => 8,    // 同時並列数
        'buffer_size'   => 8192, // 読み込みバッファサイズ
        'select_second' => 1.5,  // stream_select の待機秒数（stream_select なので多少大きくてもよい）
        'sleep_second'  => 0.01, // 読めるものがなかった場合の待機秒数（select 未対応時の sleep なのであまり大きいとスループットが下がる）
        'done'          => null, // 共通の done
        'fail'          => null, // 共通の fail
    ];

    $open = fn($target, $mode) => match (true) {
        default              => $target,
        is_callable($target) => $target(),
        is_string($target)   => fopen($target, $mode),
    };

    $result = array_fill_keys(array_keys($streams), 0);
    $currents = [];
    $noselectable_streams = [];

    while ($streams || $currents) {
        while ($streams && count($currents) < $options['concurrency']) {
            // 次の要素を取得
            $first = array_key_first($streams);
            $stream = $streams[$first];
            unset($streams[$first]);

            // 呼び出し時点で全部開かれるのもアレなので callable/string を許容する
            $stream['read'] = $open($stream['read'], 'rb');
            $stream['write'] = $open($stream['write'], 'wb');

            // キューに追加
            @stream_set_blocking($stream['read'], false);
            $currents[$first] = $stream;
        }

        $read = false;
        foreach ($currents as $key => $current) {
            $data = fread($current['read'], $options['buffer_size']);

            // 読めなかったら諦める
            if ($data === false) {
                // @codeCoverageIgnoreStart
                unset($currents[$key]);
                $result[$key] = ($current['fail'] ?? $options['fail'] ?? fn() => null)($current, $key, $current['read']);
                continue;
                // @codeCoverageIgnoreEnd
            }

            // 読めたら書く
            if ($data !== '') {
                // https://www.php.net/manual/ja/function.fwrite.php
                // ネットワークストリームへの書き込みは、 すべての文字列を書き込み終える前に終了する可能性があります。 fwrite() の戻り値を確かめるようにしましょう
                for ($written = 0; $written < strlen($data); $written += $fwrite) {
                    $fwrite = fwrite($current['write'], substr($data, $written));
                    if ($fwrite === false) {
                        // @codeCoverageIgnoreStart
                        $result[$key] = ($current['fail'] ?? $options['fail'] ?? fn() => null)($current, $key, $current['write']);
                        unset($currents[$key]);
                        continue 2;
                        // @codeCoverageIgnoreEnd
                    }
                }

                $read = true;
            }

            // 読み終わったらそいつは終わり
            if (feof($current['read'])) {
                unset($currents[$key]);
                $result[$key] = ($current['done'] ?? $options['done'] ?? fn() => $result[$key] + strlen($data))($current, $key, null);
            }
        }

        // 読めなかったら待つ（読めてるなら次も読める可能性が高いので待たない）
        if (!$read && $currents) {
            // stream_select は対応していない resource をフィルタするらしく、全て未対応だと ValueError(No stream arrays were passed) を投げてくる（1つでも対応していれば投げない）
            // のでエラーになった resource を覚えておいてフィルタする
            $r = array_filter(array_column($currents, 'read'), fn($r) => !isset($noselectable_streams[get_resource_id($r)]));
            $w = $e = [];

            // stream_select が使えるなら使いたい。しかし対応していないプロトコルもあるだろうので usleep にフォールバック
            $ret = false;
            if ($r) {
                try {
                    $ret = @stream_select($r, $w, $e, ...timeval($options['select_second']));
                }
                catch (\Throwable) {
                    $noselectable_streams += array_fill_keys(array_map('get_resource_id', $r), false);
                }
            }
            if (!$ret) {
                usleep($options['sleep_second'] * 1_000_000);
            }
        }
    }

    return $result;
}
