<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../misc/strip_php.php';
require_once __DIR__ . '/../random/unique_string.php';
// @codeCoverageIgnoreEnd

/**
 * html の空白類を除去して minify する
 *
 * 文字列的ではなく DOM 的に行うのでおかしな部分 html を食わせると意図しない結果になる可能性がある。
 * その副作用として属性のクオートやタグ内空白は全て正規化される。
 *
 * html コメントも削除される。
 * また、空白が意味を持つタグ（textarea, pre）は対象にならない。
 * さらに、php を含むような html （テンプレート）の php タグは一切の対象外となる。
 *
 * これらの挙動の一部はオプションで指定が可能。
 *
 * Example:
 * ```php
 * // e.g. id が " でクオートされている
 * // e.g. class のクオートが " になっている
 * // e.g. タグ内空白（id, class の間隔等）がスペース1つになっている
 * // e.g. php タグは一切変更されていない
 * // e.g. textarea は保持されている
 * that(html_strip("<span  id=id  class='c1  c2  c3'><?= '<hoge>  </hoge>' ?> a  b  c </span> <pre> a  b  c </pre>"))->isSame('<span id="id" class="c1  c2  c3"><?= \'<hoge>  </hoge>\' ?> a b c </span><pre> a  b  c </pre>');
 * ```
 *
 * @package ryunosuke\Functions\Package\dataformat
 *
 * @param string $html html 文字列
 * @param array $options オプション配列
 * @return string 空白除去された html 文字列
 */
function html_strip($html, $options = [])
{
    $options += [
        'error-level'    => E_USER_ERROR, // エラー時の報告レベル
        'encoding'       => 'UTF-8',      // html のエンコーディング
        'escape-phpcode' => true,         // php タグを退避するか
        'html-comment'   => true,         // html コメントも対象にするか
        'ignore-tags'    => [
            // 空白を除去しない特別タグ
            'pre',      // html の仕様でそのまま表示
            'textarea', // html の仕様...なのかスタイルなのかは分からないが普通はそのまま表示だろう
            'script',   // type が js とは限らない。そもそも js だとしても下手にいじるのは怖すぎる
            'style',    // 同上
        ],
    ];

    $preserving = unique_string($html, 64, range('a', 'z'));
    $mapping = [];

    if ($options['escape-phpcode']) {
        $mapping = [];
        $html = strip_php($html, [
            'replacer'       => $preserving,
            'trailing_break' => false,
        ], $mapping);
    }

    // xml 宣言がないとマルチバイト文字が html エンティティになってしまうし documentElement がないと <p> が自動付与されてしまう
    $docTag = "root-$preserving";
    $mapping["<$docTag>"] = '';
    $mapping["</$docTag>"] = '';
    $html = "<?xml encoding=\"{$options['encoding']}\"><$docTag>$html</$docTag>";

    // dom 化
    libxml_clear_errors();
    $current = libxml_use_internal_errors(true);
    $dom = new \DOMDocument();
    $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOXMLDECL);
    if ($options['error-level']) {
        // http://www.xmlsoft.org/html/libxml-xmlerror.html
        $nohandling = [];
        $nohandling[] = 801;
        if (!$options['escape-phpcode']) {
            $nohandling[] = 46;
        }
        foreach (libxml_get_errors() as $error) {
            if (!in_array($error->code, $nohandling, true)) {
                trigger_error($error->code . ': ' . $error->message, $options['error-level']);
            }
        }
    }
    libxml_use_internal_errors($current);

    $xpath = new \DOMXPath($dom);

    if ($options['html-comment']) {
        /** @var \DOMComment[] $comments */
        $comments = iterator_to_array($xpath->query('//comment()'), true);
        foreach ($comments as $comment) {
            $comment->parentNode->removeChild($comment);
        }
        $dom->documentElement->normalize();
    }

    /** @var \DOMText[] $texts */
    $texts = iterator_to_array($xpath->query('//text()'), true);
    $texts = array_values(array_filter($texts, function (\DOMNode $node) use ($options) {
        while ($node = $node->parentNode) {
            if (in_array($node->nodeName, $options['ignore-tags'], true)) {
                return false;
            }
        }
        return true;
    }));
    // @see https://developer.mozilla.org/ja/docs/Web/API/Document_Object_Model/Whitespace
    foreach ($texts as $n => $text) {
        // 連続空白の正規化
        $text->data = preg_replace("#[\t\n\r ]+#u", " ", $text->data);

        // 空白の直後に他の空白がある場合は (2 つが別々なインライン要素をまたぐ場合も含めて) 無視
        if (($next = $texts[$n + 1] ?? null) && ($text->data[-1] ?? null) === ' ') {
            $next->data = ltrim($next->data, "\t\n\r ");
        }

        // 行頭と行末の一連の空白が削除される
        $prev = $text->previousSibling ?? $text->parentNode->previousSibling;
        if (!$prev || in_array($prev->nodeName, $options['ignore-tags'], true)) {
            $text->data = ltrim($text->data, "\t\n\r ");
        }
        $next = $text->nextSibling ?? $text->parentNode->nextSibling;
        if (!$next || in_array($next->nodeName, $options['ignore-tags'], true)) {
            $text->data = rtrim($text->data, "\t\n\r ");
        }
    }
    return trim(strtr($dom->saveHTML($dom->documentElement), $mapping), "\t\n\r ");
}
