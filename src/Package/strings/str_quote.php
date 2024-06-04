<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 文字列をダブルクォート文字列に変換する
 *
 * 文字ではうまく表現できないが、例えば「本当の改行」が \n になり、「本当のタブ文字」が \t になる。
 * コントロール文字は "\code" 形式のようになる。
 * 「得られた文字列は eval すると元に戻る」とでも言えばいいか。
 *
 * 制御文字をそのまま出力するとまずい状況が稀によくある（特に行指向媒体への改行文字）。
 * この関数を通せば php の文字列の体裁を保ったまま1行化できる。
 * 端的に言えば var_export の文字列特化版。
 *
 * 挙動は $options である程度制御可能。
 * 各 $options は原則的に文字のマップか true を渡す（true の場合はデフォルトが使用される）。
 * 一部、それ以外の値・型に対応しているものもある。
 *
 * - escape-character: 制御文字のうち、明確なエスケープシーケンスが存在する場合はそれを使用する
 *   - control-character にオーバーラップするがこちらが優先される
 * - control-character: 00 ～ 1F+7F の制御文字を \code 形式にする
 *   - 文字列で "oct", "hex", "HEX" も指定できる。その場合それぞれ \oct, \xhex, \xHEX 形式になる
 * - special-character: ダブルクオート内の文字列が文字列であるための変換を行う
 *   - 原則的にデフォルトに任せて指定すべきではない
 *
 * Example:
 * ```php
 * // （非常に分かりにくいが）下記のように変換される
 * that(str_quote("\$a\nb\rc\x00"))->isSame("\"\\\$a\\nb\\rc\\0\"");
 * // 文字としての意味は一緒であり要するに表現形式の違いなので、php の世界で eval すれば元の文字列に戻る
 * that(eval('return ' . str_quote("\$a\nb\rc\x00") . ';'))->isSame("\$a\nb\rc\x00");
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 対象文字列
 * @param array $options オプション配列
 * @return string クォート文字列
 */
function str_quote(string $string, array $options = []): string
{
    $options += [
        'escape-character'  => true,
        'control-character' => true,
        'special-character' => true,
        'heredoc'           => '',
        'nowdoc'            => '',
        'indent'            => 0,
    ];

    assert(!($options['heredoc'] && $options['nowdoc']));

    // nowdoc にエスケープは存在しないのでそのまま埋め込む（その結果壊れてもこの関数の責務ではない）
    if (strlen($options['nowdoc'])) {
        $indent = str_repeat(" ", $options['indent']);
        $string = preg_replace('#(\R)#u', '$1' . $indent, $string);
        return "<<<'{$options['nowdoc']}'\n{$indent}{$string}\n{$indent}{$options['nowdoc']}";
    }

    // @see https://www.php.net/manual/ja/language.types.string.php#language.types.string.syntax.double
    $special_chars = [
        '\\' => '\\\\', // バックスラッシュ
        '"'  => '\\"',  // 二重引用符
        '$'  => '\\$',  // ドル記号
    ];
    $escape_chars = [
        "\11" => '\\t', // 水平タブ (HT またはアスキーの 0x09 (9))
        "\12" => '\\n', // ラインフィード (LF またはアスキーの 0x0A (10))
        "\13" => '\\v', // 垂直タブ (VT またはアスキーの 0x0B (11))
        "\14" => '\\f', // フォームフィード (FF またはアスキーの 0x0C (12))
        "\15" => '\\r', // キャリッジリターン (CR またはアスキーの 0x0D (13))
        "\33" => '\\e', // エスケープ (ESC あるいはアスキーの 0x1B (27))
    ];
    $control_chars = [
        "\0"   => "\\0",
        "\1"   => "\\1",
        "\2"   => "\\2",
        "\3"   => "\\3",
        "\4"   => "\\4",
        "\5"   => "\\5",
        "\6"   => "\\6",
        "\7"   => "\\7",
        "\10"  => "\\10",
        "\11"  => "\\11",
        "\12"  => "\\12",
        "\13"  => "\\13",
        "\14"  => "\\14",
        "\15"  => "\\15",
        "\16"  => "\\16",
        "\17"  => "\\17",
        "\20"  => "\\20",
        "\21"  => "\\21",
        "\22"  => "\\22",
        "\23"  => "\\23",
        "\24"  => "\\24",
        "\25"  => "\\25",
        "\26"  => "\\26",
        "\27"  => "\\27",
        "\30"  => "\\30",
        "\31"  => "\\31",
        "\32"  => "\\32",
        "\33"  => "\\33",
        "\34"  => "\\34",
        "\35"  => "\\35",
        "\36"  => "\\36",
        "\37"  => "\\37",
        "\177" => "\\177",
    ];

    // heredoc 用の特殊処理（タイプ可能な文字はエスケープしなくてもよいだろう）
    if (strlen($options['heredoc'])) {
        $control_chars = array_diff_key($control_chars, $escape_chars);
        $escape_chars = [];
        unset($special_chars['"']);
    }

    $charmap = [];
    if ($options['special-character']) {
        $charmap += is_array($options['special-character']) ? $options['special-character'] : $special_chars;
    }
    if ($options['escape-character']) {
        $charmap += is_array($options['escape-character']) ? $options['escape-character'] : $escape_chars;
    }
    if ($options['control-character']) {
        if ($options['control-character'] === 'oct') {
            // デフォで oct にしてあるので変換不要
            assert(end($control_chars) === "\\177");
        }
        if ($options['control-character'] === 'hex') {
            $control_chars = array_map(fn($v) => sprintf('\\x%02x', octdec(trim($v, '\\'))), $control_chars);
        }
        if ($options['control-character'] === 'HEX') {
            $control_chars = array_map(fn($v) => sprintf('\\x%02X', octdec(trim($v, '\\'))), $control_chars);
        }
        $charmap += is_array($options['control-character']) ? $options['control-character'] : $control_chars;
    }

    $string = strtr($string, $charmap);

    if (strlen($options['heredoc'])) {
        $indent = str_repeat(" ", $options['indent']);
        $string = preg_replace('#(\R)#u', '$1' . $indent, $string);
        return "<<<{$options['heredoc']}\n{$indent}{$string}\n{$indent}{$options['heredoc']}";
    }

    return '"' . $string . '"';
}
