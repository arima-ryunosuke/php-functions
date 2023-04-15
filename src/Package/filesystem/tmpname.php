<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../utility/function_configure.php';
// @codeCoverageIgnoreEnd

/**
 * 終了時に削除される一時ファイル名を生成する
 *
 * tempnam とほぼ同じで違いは下記。
 *
 * - 引数が逆
 * - 終了時に削除される
 * - 失敗時に false を返すのではなく例外を投げる
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $prefix ファイル名プレフィックス
 * @param ?string $dir 生成ディレクトリ。省略時は sys_get_temp_dir()
 * @return string 一時ファイル名
 */
function tmpname($prefix = 'rft', $dir = null)
{
    // デフォルト付きで tempnam を呼ぶ
    $dir = $dir ?: function_configure('cachedir');
    $tempfile = tempnam($dir, $prefix);

    // tempnam が何をしても false を返してくれないんだがどうしたら返してくれるんだろうか？
    if ($tempfile === false) {
        throw new \UnexpectedValueException("tmpname($dir, $prefix) failed.");// @codeCoverageIgnore
    }

    // 生成したファイルを覚えておいて最後に消す
    static $files = [];
    $files[$tempfile] = new class($tempfile) {
        private $tempfile;

        public function __construct($tempfile) { $this->tempfile = $tempfile; }

        public function __destruct() { return $this(); }

        public function __invoke()
        {
            // 明示的に消されたかもしれないので file_exists してから消す
            if (file_exists($this->tempfile)) {
                // レースコンディションのため @ を付ける
                @unlink($this->tempfile);
            }
        }
    };

    return $tempfile;
}
