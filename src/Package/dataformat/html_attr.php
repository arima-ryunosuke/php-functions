<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/chain_case.php';
// @codeCoverageIgnoreEnd

/**
 * 配列を html の属性文字列に変換する
 *
 * data-* や style, 論理属性など、全てよしなに変換して文字列で返す。
 * 返り値の文字列はエスケープが施されており、基本的にはそのまま html に埋め込んで良い。
 * （オプション次第では危険だったり乱れたりすることはある）。
 *
 * separator オプションを指定すると属性の区切り文字を指定できる。
 * 大抵の場合は半角スペースであり、少し特殊な場合に改行文字を指定するくらいだろう。
 * ただし、この separator に null を与えると文字列ではなく生の配列で返す。
 * この配列は `属性名 => 属性値` な生の配列であり、エスケープも施されていない。
 * $options 自体に文字列を与えた場合は separator 指定とみなされる。
 *
 * 属性の変換ルールは下記。
 *
 * - 属性名が数値の場合は属性としては生成されない
 * - 属性名は camelCase -> cahin-case の変換が行われる
 * - 値が null の場合は無条件で無視される
 *     - 下記 false との違いは「配列返しの場合に渡ってくるか？」である（null は無条件フィルタなので配列返しでも渡ってこない）
 * - 値が true の場合は論理属性とみなし値なしで生成される
 * - 値が false の場合は論理属性とみなし、 属性としては生成されない
 * - 値が配列の場合は ","（カンマ）で結合される
 *     - これは観測範囲内でカンマ区切りが多いため（srcset, accept など）。属性によってはカンマが適切ではない場合がある
 *     - 更にその配列が文字キーを持つ場合、キーが "=" で結合される
 *         - これは観測範囲内で = 区切りが多いため（viewport など）。属性によっては = が適切ではない場合がある
 * - 値が配列で属性名が class, style, data の場合は下記の特殊な挙動を示す
 *     - class: 半角スペースで結合される
 *         - キーは無視される
 *     - style: キーが css 名、値が css 値として ";" で結合される
 *         - キーは cahin-case に変換される
 *         - キーが数値の場合は値がそのまま追加される
 *         - 値が配列の場合は半角スペースで結合される
 *     - data-: キーが data 名、値が data 値として data 属性になる
 *         - キーは cahin-case に変換される
 *         - 値が真偽値以外のスカラーの場合はそのまま、非スカラー||真偽値の場合は json で埋め込まれる
 *             - これは jQuery において json をよしなに扱うことができるため
 *
 * ※ 上記における「配列」とは iterable を指すが、toString を実装した iterable なオブジェクトは toString が優先され、文字列とみなされる
 *
 * 複雑に見えるが「よしなに」やってくれると考えて良い。
 * 配列や真偽値で分岐が大量にあるが、大前提として「string だった場合は余計なことはしない」がある。
 * ので迷ったり予期しない結果の場合は呼び出し側で文字列化して呼べば良い。
 *
 * Example:
 * ```php
 * that(html_attr([
 *     // camelCase は camel-case になる
 *     'camelCase' => '<value>',
 *     // true は論理属性 true とみなし、値なし属性になる
 *     'checked'   => true,
 *     // false は論理属性 false とみなし、属性として現れない
 *     'disabled'  => false,
 *     // null は無条件で無視され、属性として現れない
 *     'readonly'  => null,
 *     // 配列はカンマで結合される
 *     'srcset'    => [
 *         'hoge.jpg 1x',
 *         'fuga.jpg 2x',
 *     ],
 *     // 連想配列は = で結合される
 *     'content'   => [
 *         'width' => 'device-width',
 *         'scale' => '1.0',
 *     ],
 *     // class はスペースで結合される
 *     'class'     => ['hoge', 'fuga'],
 *     // style 原則的に proerty:value; とみなす
 *     'style'     => [
 *         'color'           => 'red',
 *         'backgroundColor' => 'white',      // camel-case になる
 *         'margin'          => [1, 2, 3, 4], // スペースで結合される
 *         'opacity:0.5',                     // 直値はそのまま追加される
 *     ],
 *     // data- はその分属性が生える
 *     'data-'     => [
 *         'camelCase' => 123,
 *         'hoge'      => false,        // 真偽値は文字列として埋め込まれる
 *         'fuga'      => "fuga",       // 文字列はそのまま文字列
 *         'piyo'      => ['a' => 'A'], // 非スカラー以外は json になる
 *     ],
 * ], ['separator' => "\n"]))->is('camel-case="&lt;value&gt;"
 * checked
 * srcset="hoge.jpg 1x,fuga.jpg 2x"
 * content="width=device-width,scale=1.0"
 * class="hoge fuga"
 * style="color:red;background-color:white;margin:1 2 3 4;opacity:0.5"
 * data-camel-case="123"
 * data-hoge="false"
 * data-fuga="fuga"
 * data-piyo="{&quot;a&quot;:&quot;A&quot;}"');
 * ```
 *
 * @package ryunosuke\Functions\Package\dataformat
 *
 * @param iterable $array 属性配列
 * @param string|array|null $options オプション配列
 * @return string|array 属性文字列 or 属性配列
 */
function html_attr($array, $options = [])
{
    if (!is_array($options)) {
        $options = ['separator' => $options];
    }

    $options += [
        'quote'     => '"',  // 属性のクオート文字
        'separator' => " ",  // 属性の区切り文字
        'chaincase' => true, // 属性名, data などキーで camelCase を chain-case に変換するか
    ];

    $chaincase = static function ($string) use ($options) {
        if ($options['chaincase']) {
            return chain_case($string);
        }
        return $string;
    };
    $is_iterable = static function ($value) {
        if (is_array($value)) {
            return true;
        }
        if (is_object($value) && $value instanceof \Traversable && !method_exists($value, '__toString')) {
            return true;
        }
        return false;
    };
    $implode = static function ($glue, $iterable) use ($is_iterable) {
        if (!$is_iterable($iterable)) {
            return $iterable;
        }
        if (is_array($iterable)) {
            return implode($glue, $iterable);
        }
        return implode($glue, iterator_to_array($iterable));
    };

    $attrs = [];
    foreach ($array as $k => $v) {
        if ($v === null) {
            continue;
        }

        $k = $chaincase($k);
        assert(!isset($attrs[$k]));

        if (strpbrk($k, "\r\n\t\f '\"<>/=") !== false) {
            throw new \UnexpectedValueException('found invalid charactor as attribute name');
        }

        switch ($k) {
            default:
                if ($is_iterable($v)) {
                    $tmp = [];
                    foreach ($v as $name => $value) {
                        $name = (is_string($name) ? "$name=" : '');
                        $value = $implode(';', $value);
                        $tmp[] = $name . $value;
                    }
                    $v = implode(',', $tmp);
                }
                break;
            case 'class':
                $v = $implode(' ', $v);
                break;
            case 'style':
                if ($is_iterable($v)) {
                    $tmp = [];
                    foreach ($v as $property => $value) {
                        // css において CamelCace は意味を為さないのでオプションによらず強制的に chain-case にする
                        $property = (is_string($property) ? chain_case($property) . ":" : '');
                        $value = $implode(' ', $value);
                        $tmp[] = rtrim($property . $value, ';');
                    }
                    $v = implode(';', $tmp);
                }
                break;
            case 'data-':
                if ($is_iterable($v)) {
                    foreach ($v as $name => $data) {
                        $name = $chaincase($name);
                        $data = is_scalar($data) && !is_bool($data) ? $data : json_encode($data);
                        $attrs[$k . $name] = $data;
                    }
                    continue 2;
                }
                break;
        }

        $attrs[$k] = is_bool($v) ? $v : (string) $v;
    }

    if ($options['separator'] === null) {
        return $attrs;
    }

    $result = [];
    foreach ($attrs as $name => $value) {
        if (is_int($name)) {
            continue;
        }
        if ($value === false) {
            continue;
        }
        elseif ($value === true) {
            $result[] = htmlspecialchars($name, ENT_QUOTES);
        }
        else {
            $result[] = htmlspecialchars($name, ENT_QUOTES) . '=' . $options['quote'] . htmlspecialchars($value, ENT_QUOTES) . $options['quote'];
        }
    }
    return implode($options['separator'], $result);
}
