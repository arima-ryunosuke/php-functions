<?php
/**
 * クラスに関するユーティリティ
 *
 * @package class
 */

/**
 * composer のクラスローダを返す
 *
 * かなり局所的な実装で vendor ディレクトリを変更していたりするとそれだけで例外になる。
 *
 * Example:
 * ```php
 * assert(class_loader() instanceof \Composer\Autoload\ClassLoader);
 * ```
 *
 * @param string $startdir 高速化用の検索開始ディレクトリを指定するが、どちらかと言えばテスト用
 * @return \Composer\Autoload\ClassLoader クラスローダ
 */
function class_loader($startdir = null)
{
    $file = \ryunosuke\Functions\Cacher::put(__FILE__, __FUNCTION__, function ($cache) use ($startdir) {
        if (!isset($cache)) {
            $dir = $startdir ?: __DIR__;
            while ($dir !== ($pdir = dirname($dir))) {
                $dir = $pdir;
                if (file_exists($file = "$dir/autoload.php") || file_exists($file = "$dir/vendor/autoload.php")) {
                    $cache = $file;
                    break;
                }
            }
            if ($cache === null) {
                throw new \DomainException('autoloader is not found.');
            }
        }
        return $cache;
    });
    return require $file;
}

/**
 * クラスの名前空間部分を取得する
 *
 * Example:
 * ```php
 * assert(class_namespace('vendor\\namespace\\ClassName') === 'vendor\\namespace');
 * ```
 *
 * @param string|object $class 対象クラス・オブジェクト
 * @return string クラスの名前空間
 */
function class_namespace($class)
{
    if (is_object($class)) {
        $class = get_class($class);
    }

    $parts = explode('\\', $class);
    array_pop($parts);
    return ltrim(implode('\\', $parts), '\\');
}

/**
 * クラスの名前空間部分を除いた短い名前を取得する
 *
 * Example:
 * ```php
 * assert(class_shorten('vendor\\namespace\\ClassName') === 'ClassName');
 * ```
 *
 * @param string|object $class 対象クラス・オブジェクト
 * @return string クラスの短い名前
 */
function class_shorten($class)
{
    if (is_object($class)) {
        $class = get_class($class);
    }

    $parts = explode('\\', $class);
    return array_pop($parts);
}

/**
 * 既存（未読み込みに限る）クラスを強制的に置換する
 *
 * 例えば継承ツリーが下記の場合を考える。
 *
 * classA <- classB <- classC
 *
 * この場合、「classC は classB に」「classB は classA に」それぞれ依存している、と考えることができる。
 * これは静的に決定的であり、この依存を壊したり注入したりする手段は存在しない。
 * 例えば classA の実装を差し替えたいときに、いかに classA を継承した classAA を定義したとしても classB の親は classA で決して変わらない。
 *
 * この関数を使うと本当に classA そのものを弄るので、継承ツリーを下記のように変えることができる。
 *
 * classA <- classAA <- classB <- classC
 *
 * つまり、classA を継承した classAA を定義してそれを classA とみなすことが可能になる。
 * ただし、内部的には class_alias を使用して実現しているので厳密には異なるクラスとなる。
 *
 * 実際のところかなり強力な機能だが、同時にかなり黒魔術的なので乱用は控えたほうがいい。
 *
 * @param string $class 対象クラス名
 * @param \Closure $register 置換クラスを定義 or 返すクロージャ。「返せる」のは php7.0 以降のみ
 * @param string $dirname 一時ファイル書き出しディレクトリ。指定すると実質的にキャッシュとして振る舞う
 */
function class_replace($class, $register, $dirname = null)
{
    $class = ltrim($class, '\\');

    // 読み込み済みクラスは置換できない（php はクラスのアンロード機能が存在しない）
    if (class_exists($class, false)) {
        throw new \DomainException("'$class' is already declared.");
    }

    // 対象クラス名をちょっとだけ変えたクラスを用意して読み込む
    $classfile = class_loader()->findFile($class);
    $fname = rtrim(($dirname ?: sys_get_temp_dir()), '/\\') . '/' . str_replace('\\', '/', $class) . '.php';
    if (func_num_args() === 2 || !file_exists($fname)) {
        $content = file_get_contents($classfile);
        $content = preg_replace("#class\\s+[a-z0-9_]+#ui", '$0_', $content);
        file_set_contents($fname, $content);
    }
    require_once $fname;

    $classess = get_declared_classes();
    $newclass = $register();

    // クロージャ内部でクラス定義した場合（増えたクラスでエイリアスする）
    if ($newclass === null) {
        $classes = array_diff(get_declared_classes(), $classess);
        if (count($classes) !== 1) {
            throw new \DomainException('declared multi classes.');
        }
        $newclass = reset($classes);
    }
    // php7.0 から無名クラスが使えるのでそのクラス名でエイリアスする
    if (is_object($newclass)) {
        /** @noinspection PhpUnusedLocalVariableInspection */
        $newclass = get_class($newclass);
    }

    class_alias($newclass, $class);
}

/**
 * クラスにメソッドがあるかを返す
 *
 * Example:
 * ```php
 * assert(has_class_methods('Exception', 'getMessage') === true);
 * assert(has_class_methods('Exception', 'getmessage') === true);
 * assert(has_class_methods('Exception', 'undefined')  === false);
 * ```
 *
 * @param string|object $class 対象クラス・オブジェクト
 * @param string $method_name 調べるメソッド名
 * @return bool 持っているなら true
 */
function has_class_methods($class, $method_name)
{
    if (is_object($class)) {
        $class = get_class($class);
    }

    // php はクラス名の大文字小文字を区別しない。
    // が、そんな頻繁にバラバラに与えられないだろうし動作は変わらないし変換するコストの方が大きそうなので考慮しない
    $cache = \ryunosuke\Functions\Cacher::put(__FILE__, __FUNCTION__, function ($cache) use ($class) {
        if (!isset($cache[$class])) {
            // php はメソッドの大文字小文字を区別しない
            $cache[$class] = array_change_key_case(array_flip(get_class_methods($class)), CASE_LOWER);
        }
        return $cache;
    });
    return isset($cache[$class][strtolower($method_name)]);
}
