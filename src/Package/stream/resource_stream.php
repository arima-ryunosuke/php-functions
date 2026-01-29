<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * resource を (file)stream にプロキシする
 *
 * バックエンドが tmpfile になるいわゆる BufferedStream であり、透過的にバッファリングする。
 * もっとも、今のところ read にしか対応していないため、「seek できる stream にする」くらいの意味合いでしかない。
 *
 * resource に対応しているプロダクトでも stream 以外は対応していないことがある。
 * e.g. doctrine: https://github.com/doctrine/dbal/blob/4.4.1/src/Driver/Mysqli/Statement.php#L102
 * この関数を通すとファイルシステムを通して file stream 扱いになるのでこのようなプロダクトでも扱えるようになる。
 * 副作用としてはいったんファイルが出来上がることになるので resource であるメリットを一部捨て去ってしまうこと。
 *
 * $max_memory を与えるとそのサイズまではメモリ内で展開される。
 * 0 を与えると完全にディスクで動作する。
 * 0 以外では seek 動作が効かないので注意。
 * （php://temp が seek に対応していないっぽい。とはいえシーケンシャルじゃない seek したい状況がまずないので基本的に気にしなくてよい）。
 *
 * @package ryunosuke\Functions\Package\stream
 *
 * @return resource
 */
function resource_stream($resource, int $max_memory = 2 * 1024 * 1024, bool $forcely = false)
{
    // seekable だったら無駄なので何もしない
    if (!$forcely && stream_get_meta_data($resource)['seekable']) {
        return $resource;
    }

    static $STREAM_NAME, $stream_class = null;
    if ($STREAM_NAME === null) {
        $STREAM_NAME = 'resource-stream';
        if (in_array($STREAM_NAME, stream_get_wrappers())) {
            throw new \DomainException("$STREAM_NAME is registered already."); // @codeCoverageIgnore
        }

        stream_wrapper_register($STREAM_NAME, $stream_class = get_class(new class() {
            public static $resources = [];

            private int    $id;
            private        $sourceStream;
            private        $bufferStream;
            private object $bufferManager;

            public $context;

            // <editor-fold desc="open/close">

            /** @noinspection PhpUnusedParameterInspection */
            public function stream_open(string $path, string $mode, int $options, &$opened_path): bool
            {
                // リソース ID とパラメータを取得
                $parsed = parse_url($path);
                parse_str($parsed['query'], $query);

                // リソースを取得（unset のために ID は取っておく）
                $this->id = $parsed['host'];
                $this->sourceStream = self::$resources[$parsed['host']];

                // バッファー生成（位置は合わせておく）
                $this->bufferStream = $query['max_memory'] ? fopen("php://temp/maxmemory:{$query['max_memory']}", 'wb+') : tmpfile();
                fseek($this->bufferStream, ftell($this->sourceStream));

                // 既読管理マネージャ
                $this->bufferManager = new class () {
                    public function __construct(private array $ranges = []) { }

                    public function read(int $start, int $length): self
                    {
                        $end = $start + $length;

                        $result = [];
                        foreach ($this->ranges as [$readFrom, $readTo]) {
                            if ($readTo < $start) {
                                $result[] = [$readFrom, $readTo];
                            }
                            elseif ($readFrom > $end) {
                                $result[] = [$start, $end];
                                $start = $readFrom;
                                $end = $readTo;
                            }
                            else {
                                $start = min($start, $readFrom);
                                $end = max($end, $readTo);
                            }
                        }
                        $result[] = [$start, $end];
                        $this->ranges = $result;

                        return $this;
                    }

                    public function getUnread(int $start, int $length): array
                    {
                        $end = $start + $length;

                        $result = [];
                        foreach ($this->ranges as [$readFrom, $readTo]) {
                            if ($readFrom >= $end) {
                                break;
                            }
                            if ($readTo <= $start) {
                                continue;
                            }

                            if ($readFrom > $start) {
                                $result[] = [$start, $readFrom - $start];
                            }

                            $start = max($start, $readTo);

                            if ($start >= $end) {
                                return $result;
                            }
                        }

                        if ($start < $end) {
                            $result[] = [$start, $end - $start];
                        }

                        return $result;
                    }
                };

                return true;
            }

            public function stream_close(): void
            {
                fclose($this->sourceStream);
                fclose($this->bufferStream);
                unset(self::$resources[$this->id]);
            }

            // </editor-fold>

            // <editor-fold desc="read/write">

            public function stream_read(int $count): string|false
            {
                $bufferPos = ftell($this->bufferStream);

                // buffer に無いなら読む（seek 次第で細切れになるが普通はシーケンシャルなので許容する）
                $unreads = $this->bufferManager->getUnread($bufferPos, $count);
                foreach ($unreads as [$start, $length]) {
                    // buffer でしか seek していないのでここで seek（もちろんここでエラーになることもある）
                    if (ftell($this->sourceStream) !== $start) {
                        if (fseek($this->sourceStream, $start) === -1) {
                            return false;
                        }
                    }

                    // 読んで書いて既読にする
                    $buffer = fread($this->sourceStream, $length);
                    fseek($this->bufferStream, $start);
                    fwrite($this->bufferStream, $buffer);
                    $this->bufferManager->read($start, strlen($buffer));
                }

                // 上を通過した時点で buffer に溜まっているので単純に読めばよい
                fseek($this->bufferStream, $bufferPos);
                return fread($this->bufferStream, $count);
            }

            // </editor-fold>

            // <editor-fold desc="seek">

            public function stream_seek(int $offset, int $whence): bool
            {
                // seek は buffer が主体で読み込み時に source も seek する
                return fseek($this->bufferStream, $offset, $whence) === 0;
            }

            public function stream_tell(): int
            {
                return ftell($this->bufferStream);
            }

            public function stream_eof(): bool
            {
                return feof($this->sourceStream);
            }

            // </editor-fold>

            // <editor-fold desc="misc">

            public function stream_stat(): array|false
            {
                return fstat($this->sourceStream);
            }

            public function stream_set_option(int $option, int $arg1, ?int $arg2): bool
            {
                return match ($option) {
                    STREAM_OPTION_BLOCKING     => stream_set_blocking($this->sourceStream, $arg1),
                    STREAM_OPTION_READ_BUFFER  => stream_set_read_buffer($this->sourceStream, $arg2),
                    STREAM_OPTION_WRITE_BUFFER => stream_set_write_buffer($this->sourceStream, $arg2),
                    STREAM_OPTION_READ_TIMEOUT => stream_set_timeout($this->sourceStream, $arg1 + $arg2 / 1_000_000),
                };
            }

            public function stream_lock(int $operation): bool
            {
                return flock($this->sourceStream, $operation);
            }

            /** @noinspection PhpUnusedParameterInspection */
            public function stream_cast(int $cast_as)
            {
                return $this->bufferStream;
            }

            // </editor-fold>
        }));
    }

    $id = get_resource_id($resource);
    $stream_class::$resources[$id] = $resource;

    return fopen("$STREAM_NAME://$id?max_memory=$max_memory", 'rb');
}
