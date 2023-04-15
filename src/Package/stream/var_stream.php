<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../utility/function_configure.php';
// @codeCoverageIgnoreEnd

/**
 * 変数をリソースのように扱えるファイルポインタを返す
 *
 * 得られたファイルポインタに fread すれば変数の値が見えるし、 fwrite すれば変数の値が書き換わる。
 * 逆に変数を書き換えればファイルポインタで得られる値も書き換わる。
 *
 * 用途は主にテスト用。
 * 例えば「何らかのファイルポインタを要求する処理」に対して fopen や tmpfile を駆使して値の確認をするのは結構めんどくさい。
 * （`rewind` したり `stream_get_contents` したり削除したりする必要がある）。
 * それよりもこの関数で得られたファイルポインタを渡し、 `that($var)->is($expected)` とできる方がテストの視認性が良くなる。
 *
 * Example:
 * ```php
 * // $var のファイルポインタを取得
 * $fp = var_stream($var);
 * // ファイルポインタに書き込みを行うと変数にも反映される
 * fwrite($fp, 'hoge');
 * that($var)->is('hoge');
 * // 変数に追記を行うとファイルポインタで読み取れる
 * $var .= 'fuga';
 * that(fread($fp, 1024))->is('fuga');
 * // 変数をまるっと置換するとファイルポインタ側もまるっと変わる
 * $var = 'hello, world';
 * that(stream_get_contents($fp, -1, 0))->is('hello, world');
 * // ファイルポインタをゴリっと削除すると変数も空になる
 * ftruncate($fp, 0);
 * that($var)->is('');
 * ```
 *
 * @package ryunosuke\Functions\Package\stream
 *
 * @param string|null $var 対象の変数
 * @param string $initial 初期値。与えたときのみ初期化される
 * @return resource 変数のファイルポインタ
 */
function var_stream(&$var, $initial = '')
{
    static $STREAM_NAME, $stream_class, $registered = false;
    if (!$registered) {
        $STREAM_NAME = $STREAM_NAME ?: function_configure('var_stream');
        if (in_array($STREAM_NAME, stream_get_wrappers())) {
            throw new \DomainException("$STREAM_NAME is registered already.");
        }

        $registered = true;
        stream_wrapper_register($STREAM_NAME, $stream_class = get_class(new class() {
            private static $ids     = 0;
            private static $entries = [];

            private $id;
            private $entry;
            private $position;

            public static function create(string &$var): int
            {
                self::$entries[++self::$ids] = &$var;
                return self::$ids;
            }

            public function stream_open(string $path, string $mode, int $options, &$opened_path): bool
            {
                assert([$mode, $options, &$opened_path]);
                $this->id = parse_url($path, PHP_URL_HOST);
                $this->entry = &self::$entries[$this->id];
                $this->position = 0;

                return true;
            }

            public function stream_close()
            {
                unset(self::$entries[$this->id]);
            }

            public function stream_lock(int $operation): bool
            {
                assert(is_int($operation));
                // 競合しないので常に true を返す
                return true;
            }

            public function stream_flush(): bool
            {
                // バッファしないので常に true を返す
                return true;
            }

            public function stream_eof(): bool
            {
                // 変数の書き換えを検知する術はないので eof は殺しておく
                return false;
            }

            public function stream_read(int $count): string
            {
                $result = substr($this->entry, $this->position, $count);
                $this->position += strlen($result);
                return $result;
            }

            public function stream_write(string $data): int
            {
                $datalen = strlen($data);
                $posision = $this->position;
                // 一般的に、ファイルの終端より先の位置に移動することも許されています。
                // そこにデータを書き込んだ場合、ファイルの終端からシーク位置までの範囲を読み込むと 値 0 が埋められたバイトを返します。
                $current = str_pad($this->entry, $posision, "\0", STR_PAD_RIGHT);
                $this->entry = substr_replace($current, $data, $posision, $datalen);
                $this->position += $datalen;
                return $datalen;
            }

            public function stream_truncate(int $new_size): bool
            {
                $current = substr($this->entry, 0, $new_size);
                $this->entry = str_pad($current, $new_size, "\0", STR_PAD_RIGHT);
                return true;
            }

            public function stream_tell(): int
            {
                return $this->position;
            }

            public function stream_seek(int $offset, int $whence = SEEK_SET): bool
            {
                $strlen = strlen($this->entry);
                switch ($whence) {
                    case SEEK_SET:
                        if ($offset < 0) {
                            return false;
                        }
                        $this->position = $offset;
                        break;

                    // stream_tell を定義していると SEEK_CUR が呼ばれない？（計算されて SEEK_SET に移譲されているような気がする）
                    // @codeCoverageIgnoreStart
                    case SEEK_CUR:
                        $this->position += $offset;
                        break;
                    // @codeCoverageIgnoreEnd

                    case SEEK_END:
                        $this->position = $strlen + $offset;
                        break;
                }
                // ファイルの終端から数えた位置に移動するには、負の値を offset に渡して whence を SEEK_END に設定しなければなりません。
                if ($this->position < 0) {
                    $this->position = $strlen + $this->position;
                    if ($this->position < 0) {
                        $this->position = 0;
                        return false;
                    }
                }
                return true;
            }

            public function stream_stat()
            {
                $size = strlen($this->entry);
                return [
                    7      => $size,
                    'size' => $size,
                ];
            }
        }));
    }

    if (func_num_args() > 1) {
        $var = $initial;
    }
    // タイプヒントによる文字列化とキャストによる文字列化は動作が異なるので、この段階で早めに文字列化しておく
    $var = (string) $var;
    return fopen($STREAM_NAME . '://' . $stream_class::create($var), 'r+b');
}
