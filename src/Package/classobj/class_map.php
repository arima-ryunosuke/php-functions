<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../classobj/class_loader.php';
require_once __DIR__ . '/../filesystem/file_list.php';
require_once __DIR__ . '/../filesystem/path_is_absolute.php';
require_once __DIR__ . '/../filesystem/path_normalize.php';
require_once __DIR__ . '/../strings/namespace_split.php';
require_once __DIR__ . '/../utility/json_storage.php';
// @codeCoverageIgnoreEnd

/**
 * 指定クラスローダで読み込まれるであろう class => file を返す
 *
 * 実質的には composer で読み込まれるクラスマップを返す。
 * つまり `dump-autoload -o` したときの getClassMap 相当を返す。
 *
 * ファイル名からクラス名を逆引きする都合上、猛烈に遅いので注意。
 *
 * @package ryunosuke\Functions\Package\classobj
 */
function class_map(
    /** @var ?\Composer\Autoload\ClassLoader オートローダオブジェクト */
    ?object $loader = null,
    /** パスが相対パスだった場合の基底ディレクトリ */
    ?string $basePath = null,
    /** キャッシュを使用するか */
    bool $cache = true,
): /** [class => file] の配列 */ array
{
    $loader ??= class_loader();
    $basePath ??= dirname((new \ReflectionClass($loader))->getFileName(), 3);
    $storage = json_storage(__FUNCTION__);
    $cachekey = [spl_object_id($loader), $basePath];
    if (!$cache) {
        unset($storage[$cachekey]);
    }
    return $storage[$cachekey] ??= (function () use ($loader, $basePath) {
        $result = [];

        // psr0+4
        foreach ([
            0 => $loader->getPrefixes() + ["" => $loader->getFallbackDirs()],
            4 => $loader->getPrefixesPsr4() + ["" => $loader->getFallbackDirsPsr4()],
        ] as $level => $psr) {
            foreach ($psr as $prefix => $dirs) {
                foreach ($dirs as $dir) {
                    $dir = path_normalize(path_is_absolute($dir) ? $dir : "$basePath/$dir");
                    foreach (file_list($dir, ['name' => '#^[a-z_\x80-\xff][a-z0-9_\x80-\xff]*\.php$#ui']) ?? [] as $file) {
                        if ($level === 0) {
                            $class = strtr(substr($file, strlen($dir) + 1, -4), [DIRECTORY_SEPARATOR => '\\']);
                            if (!isset($result[$class]) && str_starts_with($class, $prefix)) {
                                $result[$class] = $file;
                            }
                        }
                        elseif ($level === 4) {
                            $class = strtr($prefix . substr($file, strlen($dir) + 1, -4), [DIRECTORY_SEPARATOR => '\\']);
                            if (!isset($result[$class])) {
                                $result[$class] = $file;
                            }
                        }
                    }
                }
            }
        }

        // クラスファイル名が見つかったからといってクラス定義ファイルとは限らないので中身を見なければならない
        $result = array_filter($result, function ($file, $class) {
            try {
                [$N, $C] = namespace_split($class);
                $tokens = \PhpToken::tokenize(file_get_contents($file), TOKEN_PARSE);
                $namespace = '';
                $namespacing = false;
                foreach ($tokens as $n => $token) {
                    switch (true) {
                        case $token->is(T_NAMESPACE):
                            $namespacing = true;
                            $namespace = '';
                            break;
                        case $token->is([';', '{']):
                            $namespacing = false;
                            break;
                        // namespace の文脈で T_NAME_FULLY_QUALIFIED は流れてこないが \\ がないと T_STRING で流れてくる
                        case $token->is([T_NAME_QUALIFIED, T_STRING]):
                            if ($namespacing) {
                                $namespace .= $token->text;
                            }
                            break;
                        case $token->is([T_CLASS, T_INTERFACE, T_TRAIT, /*T_ENUM:*/]):
                            // ある程度で区切らないと無名クラス（new class() { }）や class 定数（Hoge::class）で最後まで読んでしまい、極端に遅くなる
                            // class/interface/trait/enum キーワードとクラス名が16トークンも離れてることはまずないだろう
                            for ($i = $n + 1, $l = min($n + 16, count($tokens)); $i < $l; $i++) {
                                if ($tokens[$i]->is(T_STRING) && $namespace === $N && $tokens[$i]->is($C)) {
                                    return true;
                                }
                            }
                            break;
                    }
                }
            }
            catch (\ParseError) {
                // TOKEN_PARSE で tokenize するとパースエラーが発生するが、パースエラーになるファイルでクラス定義がされるわけないのでスルーでよい
            }
            return false;
        }, ARRAY_FILTER_USE_BOTH);

        // classmap は composer が生成するかユーザーが明示的に設定するので↑のような漁る処理は必要ない
        // ただしパスの正規化は行わなければならない
        foreach ($loader->getClassMap() as $class => $file) {
            $result[$class] ??= path_normalize(path_is_absolute($file) ? $file : "$basePath/$file");
        }

        return $result;
    })();
}
