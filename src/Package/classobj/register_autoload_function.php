<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../classobj/type_exists.php';
require_once __DIR__ . '/../stream/include_stream.php';
// @codeCoverageIgnoreEnd

/**
 * オートロード前後にコールバックする
 *
 * before を使って「クラスを読み込み前に動的に書き換える」のようなことが可能になる。
 * after を使って「`__initialize` を呼ぶ」のような規約を定めればスタティックイニシャライザのようなことが可能になる。
 *
 * prepend なオートローダで実装してあるので、その後のさらに prepend されたようなオートローダでの読み込みは感知できない。
 * もちろんロード済みクラスも感知できない。
 *
 * before 内で無条件にクラスを呼ぶと無限ループになるので注意（オートローダが呼ばれて before が呼ばれてオートローダが呼ばれて before が呼ばれて・・・）。
 *
 * ローダーオブジェクトを返すが特に意味はなく、使うべきではない。
 *
 * @package ryunosuke\Functions\Package\classobj
 *
 * @param ?callable $before 読み込み前コールバック
 * @param ?callable $after 読み込み後コールバック
 * @return object ローダーオブジェクト
 */
function register_autoload_function($before = null, $after = null)
{
    static $loader = null;
    $loader ??= new class() {
        public $befores = [];
        public $afters  = [];

        private $loading = false;

        public function __invoke($classname)
        {
            if (!$this->loading) {
                $this->loading = true;
                // file スキームをこの瞬間だけ上書きして require/include をフックする
                $include_stream = include_stream()->register(function ($filename) use ($classname) {
                    $contents = null;
                    foreach ($this->befores as $before) {
                        $contents = $before($classname, $filename, $contents);
                    }
                    return $contents ?? file_get_contents($filename);
                });
                try {
                    $autoloaders = spl_autoload_functions();
                    foreach ($autoloaders as $autoloader) {
                        if ($autoloader !== $this) {
                            // ここで require/include が走れば↑の before がコールされる
                            $autoloader($classname);
                            if (type_exists($classname, false)) {
                                break;
                            }
                        }
                    }

                }
                finally {
                    // file スキームの上書きは影響範囲が大きいので必ず元に戻す
                    $include_stream->restore();
                    $this->loading = false;
                }
            }
            if (type_exists($classname, false)) {
                // ロードができたら after をコールする
                foreach ($this->afters as $after) {
                    $after($classname);
                }
            }
        }
    };
    if ($before) {
        $loader->befores[] = $before;
    }
    if ($after) {
        $loader->afters[] = $after;
    }

    spl_autoload_unregister($loader);
    spl_autoload_register($loader, true, true);

    return $loader;
}
