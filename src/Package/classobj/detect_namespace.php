<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../filesystem/dirname_r.php';
require_once __DIR__ . '/../syntax/throws.php';
// @codeCoverageIgnoreEnd

/**
 * ディレクトリ構造から名前空間を推測して返す
 *
 * 指定パスに名前空間を持つような php ファイルが有るならその名前空間を返す。
 * 指定パスに名前空間を持つような php ファイルが無いなら親をたどる。
 * 親に名前空間を持つような php ファイルが有るならその名前空間＋ローカルパスを返す。
 *
 * 言葉で表すとややこしいが、「そのパスに配置しても違和感の無い名前空間」を返してくれるはず。
 *
 * Example:
 * ```php
 * // Example 用としてこのパッケージの Transporter を使用してみる
 * $dirname = dirname(class_loader()->findFile(\ryunosuke\Functions\Transporter::class));
 * // "$dirname/Hoge" の名前空間を推測して返す
 * that(detect_namespace("$dirname/Hoge"))->isSame("ryunosuke\\Functions\\Hoge");
 * ```
 *
 * @package ryunosuke\Functions\Package\classobj
 *
 * @param string $location 配置パス。ファイル名を与えるとそのファイルを配置すべきクラス名を返す
 * @return string 名前空間
 */
function detect_namespace($location)
{
    // php をパースして名前空間部分を得るクロージャ
    $detectNS = function ($phpfile) {
        $tokens = token_get_all(file_get_contents($phpfile));
        $count = count($tokens);

        $namespace = [];
        foreach ($tokens as $n => $token) {
            if (is_array($token) && $token[0] === T_NAMESPACE) {
                // T_NAMESPACE と T_WHITESPACE で最低でも2つは読み飛ばしてよい
                for ($m = $n + 2; $m < $count; $m++) {
                    if (is_array($tokens[$m]) && $tokens[$m][0] === T_NAME_QUALIFIED) {
                        return $tokens[$m][1];
                    }
                    if (is_array($tokens[$m]) && $tokens[$m][0] === T_NAME_FULLY_QUALIFIED) {
                        $namespace[] = trim($tokens[$m][1], '\\');
                    }
                    // よほどのことがないと T_NAMESPACE の次の T_STRING は名前空間の一部
                    if (is_array($tokens[$m]) && $tokens[$m][0] === T_STRING) {
                        $namespace[] = $tokens[$m][1];
                    }
                    // 終わりが来たら結合して返す
                    if ($tokens[$m] === ';') {
                        return implode('\\', $namespace);
                    }
                }
            }
        }
        return null;
    };

    // 指定パスの兄弟ファイルを調べた後、親ディレクトリを辿っていく
    $basenames = [];
    return dirname_r($location, function ($directory) use ($detectNS, &$basenames) {
        foreach (array_filter(glob("$directory/*.php"), 'is_file') as $file) {
            $namespace = $detectNS($file);
            if ($namespace !== null) {
                $localspace = implode('\\', array_reverse($basenames));
                return rtrim($namespace . '\\' . $localspace, '\\');
            }
        }
        $basenames[] = pathinfo($directory, PATHINFO_FILENAME);
    }) ?: throws(new \InvalidArgumentException('can not detect namespace. invalid output path or not specify namespace.'));
}
