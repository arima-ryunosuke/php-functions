<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../dataformat/paml_import.php';
require_once __DIR__ . '/../misc/resolve_symbol.php';
require_once __DIR__ . '/../strings/quoteexplode.php';
require_once __DIR__ . '/../strings/str_between.php';
require_once __DIR__ . '/../strings/str_chop.php';
require_once __DIR__ . '/../strings/strpos_array.php';
require_once __DIR__ . '/../strings/strpos_quoted.php';
// @codeCoverageIgnoreEnd

/**
 * アノテーションっぽい文字列をそれっぽくパースして返す
 *
 * $annotation にはリフレクションオブジェクトも渡せる。
 * その場合、getDocComment や getFilename, getNamespaceName などを用いてある程度よしなに名前解決する。
 * もっとも、@Class(args) 形式を使わないのであれば特に意味はない。
 *
 * $schame で「どのように取得するか？」のスキーマ定義が渡せる。
 * スキーマ定義は連想配列で各アノテーションごとに下記のような定義を指定でき、連想配列でない場合はすべてのアノテーションにおいて指定したとみなされる。
 *
 * - true: 余計なことはせず、アノテーションの文字列をそのまま返す
 * - false: 下記にようによしなに変換して返す
 * - []: 複数値モードを強制する
 * - null: 単一値モードを強制する
 *
 * アノテーションの仕様は下記（すべて $schema が false であるとする）。
 *
 * - @から行末まで（1行に複数のアノテーションは含められない）
 *     - ただし行末が `({[` のいずれかであれば次の `]})` までブロックを記載する機会が与えられる
 *     - ブロックを見つけたときは本来値となるべき値がキーに、ブロックが値となり、結果は必ず配列化される
 * - 同じアノテーションを複数見つけたときは配列化される
 * - `@hogera`: 値なしは null を返す
 * - `@hogera v1 "v2 v3"`: ["v1", "v2 v3"] という配列として返す
 * - `@hogera {key: 123}`: ["key" => 123] という（連想）配列として返す
 * - `@hogera [123, 456]`: [123, 456] という連番配列として返す
 * - `@hogera ("2019/12/23")`: hogera で解決できるクラス名で new して返す（$filename 引数の指定が必要）
 * - 下3つの形式はアノテーション区切りのスペースはあってもなくても良い
 *
 * $schema が true だと上記のような変換は一切行わず、素朴な文字列で返す。
 * あくまで簡易実装であり、本格的に何かをしたいなら専用のパッケージを導入したほうが良い。
 *
 * Example:
 * ```php
 * $annotations = parse_annotation('
 *
 * @noval
 * @single this is value
 * @closure this is value
 * @array this is value
 * @hash {key: 123}
 * @list [1, 2, 3]
 * @ArrayObject([1, 2, 3])
 * @block message {
 *     this is message1
 *     this is message2
 * }
 * @same this is same value1
 * @same this is same value2
 * @same this is same value3
 * ', [
 *     'single'  => true,
 *     'closure' => fn($value) => explode(' ', strtoupper($value)),
 * ]);
 * that($annotations)->is([
 *     'noval'       => null,                        // 値なしは null になる
 *     'single'      => 'this is value',             // $schema 指定してるので文字列になる
 *     'closure'     => ['THIS', 'IS', 'VALUE'],     // $schema 指定してそれがクロージャだとコールバックされる
 *     'array'       => ['this', 'is', 'value'],     // $schema 指定していないので配列になる
 *     'hash'        => ['key' => '123'],            // 連想配列になる
 *     'list'        => [1, 2, 3],                   // 連番配列になる
 *     'ArrayObject' => new \ArrayObject([1, 2, 3]), // new されてインスタンスになる
 *     "block"       => [                            // ブロックはブロック外をキーとした連想配列になる（複数指定でキーは指定できるイメージ）
 *         "message" => ["this is message1\n    this is message2"],
 *     ],
 *     'same'        => [                            // 複数あるのでそれぞれの配列になる
 *         ['this', 'is', 'same', 'value1'],
 *         ['this', 'is', 'same', 'value2'],
 *         ['this', 'is', 'same', 'value3'],
 *     ],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\misc
 *
 * @param string|\Reflector $annotation アノテーション文字列
 * @param array|mixed $schema スキーマ定義
 * @param string|array $nsfiles ファイル名 or [ファイル名 => 名前空間名]
 * @return array アノテーション配列
 */
function parse_annotation($annotation, $schema = [], $nsfiles = [])
{
    if ($annotation instanceof \Reflector) {
        $reflector = $annotation;
        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        $annotation = $reflector->getDocComment();

        // クラスメンバーリフレクションは getDeclaringClass しないと名前空間が取れない
        if (false
            || $reflector instanceof \ReflectionClassConstant
            || $reflector instanceof \ReflectionProperty
            || $reflector instanceof \ReflectionMethod
        ) {
            $reflector = $reflector->getDeclaringClass();
        }

        // 無名クラスに名前空間という概念はない（無くはないが普通に想起される名前空間ではない）
        $namespaces = [];
        if (!($reflector instanceof \ReflectionClass && $reflector->isAnonymous())) {
            $namespaces[] = $reflector->getNamespaceName();
        }
        $nsfiles[$reflector->getFileName()] = $nsfiles[$reflector->getFileName()] ?? $namespaces;

        // doccomment 特有のインデントを削除する
        $annotation = preg_replace('#(\\R)[ \\t]+\\*[ \\t]?#u', '$1', str_chop($annotation, '/**', '*/'));
    }

    $result = [];
    $multiples = [];

    $brace = [
        '(' => ')',
        '{' => '}',
        '[' => ']',
    ];
    for ($i = 0, $l = strlen($annotation); $i < $l; $i++) {
        $i = strpos_quoted($annotation, '@', $i);
        if ($i === false) {
            break;
        }

        $seppos = min(strpos_array($annotation, [" ", "\t", "\n", '[', '{', '('], $i + 1) ?: [false]);
        $name = substr($annotation, $i + 1, $seppos - $i - 1);
        $i += strlen($name);
        $name = trim($name);

        $key = null;
        $brkpos = strpos_quoted($annotation, "\n", $seppos) ?: strlen($annotation);
        if (isset($brace[$annotation[$brkpos - 1]])) {
            $s = $annotation[$brkpos - 1];
            $e = $brace[$s];
            $brkpos--;
            $key = trim(substr($annotation, $seppos, $brkpos - $seppos));
            $value = $s . str_between($annotation, $s, $e, $brkpos) . $e;
            $i = $brkpos;
        }
        else {
            $endpos = strpos_quoted($annotation, "@", $seppos) ?: strlen($annotation);
            $value = substr($annotation, $seppos, $endpos - $seppos);
            $i += strlen($value);
            $value = trim($value);
        }

        $rawmode = $schema;
        if (is_array($rawmode)) {
            $rawmode = array_key_exists($name, $rawmode) ? $rawmode[$name] : false;
        }
        if ($rawmode instanceof \Closure) {
            $value = $rawmode($value, $key);
        }
        elseif ($rawmode) {
            if (is_string($key)) {
                $value = substr($value, 1, -1);
            }
        }
        else {
            if (is_array($rawmode)) {
                $multiples[$name] = true;
            }
            if (is_null($rawmode)) {
                $multiples[$name] = false;
            }
            if ($value === '') {
                $value = null;
            }
            elseif (in_array($value[0] ?? null, ['('], true)) {
                $class = resolve_symbol($name, $nsfiles, 'alias') ?? $name;
                $value = new $class(...paml_import(substr($value, 1, -1)));
            }
            elseif (in_array($value[0] ?? null, ['{', '['], true)) {
                $value = (array) paml_import($value)[0];
            }
            else {
                $value = array_values(array_filter(quoteexplode([" ", "\t"], $value), "strlen"));
            }
        }

        if (array_key_exists($name, $result) && !isset($multiples[$name])) {
            $multiples[$name] = true;
            $result[$name] = [$result[$name]];
        }
        if (strlen($key ?? '')) {
            $multiples[$name] = true;
            $result[$name][$key] = $value;
        }
        elseif (isset($multiples[$name]) && $multiples[$name] === true) {
            $result[$name][] = $value;
        }
        else {
            $result[$name] = $value;
        }
    }

    return $result;
}
