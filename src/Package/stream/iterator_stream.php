<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * iterator を resource に変換する
 *
 * iterator(generator) は「ちょっとずつ返す」という性質を持つので resource 的に扱えた方が便利なことがある。
 * 例えば極々稀に iterator を resource として扱いたい場合が存在する。
 * - 外部ライブラリのメソッドが resource しか受け付けない
 * - 手元に SplFileObject しかない（SplFileObject から resource を得る手段は存在しない）
 * そんな時この関数を使えば resource 化することができる。
 *
 * 得られた resource は大抵の fxxxx 関数を呼ぶことができる。
 * が、呼んだところで効果があるのは非常に限定的で、意味があるのは ftell くらいしかない。
 * あくまで「resource として扱いたい場合にエラーが出て欲しくない」程度の意味でしかない。
 *
 * 実質的には tmpfile に全部書いてそのファイルリソースを返すのと同じ。
 * ただし、tmpfile が（tmpfs などで）メモリ上にあるかもしれないし全部書いて全部読むのは余計なオーバーヘッドがかかるし途中で打ち切ることもできない。
 * とは言え size が取れたり seek 出来たりと機能面ではそちらの方が優れているので参考実装として引数分岐で残してある。
 *
 * Example:
 * ```php
 * // Generator を resource 化する
 * $stream = iterator_stream((function() {
 *     yield "a\n";
 *     yield "ab\n";
 *     yield "abc\n";
 * })());
 * // resource として扱える
 * that(fgets($stream))->is("a\n");
 * that(fgets($stream))->is("ab\n");
 * that(fgets($stream))->is("abc\n");
 * that(fgets($stream))->is(false);
 *
 * // SplFileObject を resource 化する
 * $testpath = sys_get_temp_dir() . '/iterator_stream.txt';
 * file_put_contents($testpath, "a\nab\nabc\n");
 * $file = new \SplFileObject($testpath);
 * $stream = iterator_stream($file);
 * // resource として扱える（$file->current,next でも fgets($stream) でも同様の作用・副作用が得られる）
 * // SplFileObject には resource 取得メソッドが無いので resource を要求されると代替手段が無いに等しい
 * that($file->current())->is("a\n");
 * $file->next();
 * that(fgets($stream))->is("ab\n");
 * that(fgets($stream))->is("abc\n");
 * that(fgets($stream))->is(false);
 * ```
 *
 * @package ryunosuke\Functions\Package\stream
 *
 * @return resource iterator の resource
 */
function iterator_stream(\Iterator $iterator, ?string $tmpdir = null)
{
    if ($tmpdir !== null) {
        $tmp = fopen(tempnam($tmpdir, 'istream'), 'w+b');
        foreach ($iterator as $it) {
            fwrite($tmp, $it);
        }
        rewind($tmp);
        return $tmp;
    }

    static $STREAM_NAME, $stream_class = null;
    if ($STREAM_NAME === null) {
        $STREAM_NAME = 'iterator-stream';
        if (in_array($STREAM_NAME, stream_get_wrappers())) {
            throw new \DomainException("$STREAM_NAME is registered already."); // @codeCoverageIgnore
        }

        stream_wrapper_register($STREAM_NAME, $stream_class = get_class(new class() {
            public static $objects = [];

            private int       $id;
            private \Iterator $iterator;
            private int       $position;
            private string    $buffer;

            public $context;

            /** @noinspection PhpUnusedParameterInspection */
            public function stream_open(string $path, string $mode, int $options, &$opened_path): bool
            {
                assert(strpos($mode, 'r') !== false);

                $parsed = parse_url($path);

                $this->id = $parsed['host'];
                $this->iterator = self::$objects[$parsed['host']];
                $this->position = 0;
                $this->buffer = '';

                return true;
            }

            public function stream_close()
            {
                unset(self::$objects[$this->id]);
            }

            public function stream_read(int $count): string
            {
                $buffer = $this->buffer;
                while (strlen($buffer) < $count && $this->iterator->valid()) {
                    $buffer .= $this->iterator->current();
                    $this->iterator->next();
                }

                $result = substr($buffer, 0, $count);
                $this->buffer = substr($buffer, $count);

                $this->position += strlen($result);
                return $result;
            }

            public function stream_eof(): bool
            {
                return !($this->iterator->valid() || strlen($this->buffer));
            }

            public function stream_tell(): int
            {
                return $this->position;
            }

            public function stream_seek(int $offset, int $whence = SEEK_SET): bool
            {
                if ($offset === 0 && $whence === SEEK_SET) {
                    $this->position = 0;
                    $this->buffer = '';
                    $this->iterator->rewind();
                    return true;
                }
                return false;
            }

            public function stream_stat()
            {
                return [];
            }

            /** @noinspection PhpUnusedParameterInspection */
            public function stream_set_option(int $option, int $arg1, ?int $arg2) { return false; }

            /** @noinspection PhpUnusedParameterInspection */
            public function stream_lock($operation) { return false; }
        }));
    }

    $id = spl_object_id($iterator);
    $stream_class::$objects[$id] = $iterator;

    return fopen("$STREAM_NAME://$id", 'rb');
}
