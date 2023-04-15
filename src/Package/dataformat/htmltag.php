<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_sprintf.php';
require_once __DIR__ . '/../array/array_unset.php';
require_once __DIR__ . '/../dataformat/css_selector.php';
require_once __DIR__ . '/../strings/concat.php';
// @codeCoverageIgnoreEnd

/**
 * css セレクタから html 文字列を生成する
 *
 * `tag#id.class[attr=value]` のような css セレクタから `<tag id="id" class="class" attr="value"></tag>` のような html 文字列を返す。
 * 配列を与えるとキーがセレクタ、値がコンテント文字列になる。
 * さらに値が配列だと再帰して生成する。
 *
 * 値や属性は適切に htmlspecialchars される。
 *
 * Example:
 * ```php
 * // 単純文字列はただのタグを生成する
 * that(
 *     htmltag('a#hoge.c1.c2[name=hoge\[\]][href="http://hoge"][hidden]'))
 *     ->isSame('<a id="hoge" class="c1 c2" name="hoge[]" href="http://hoge" hidden></a>'
 * );
 * // ペア配列を与えるとコンテント文字列になる
 * that(
 *     htmltag(['a.c1#hoge.c2[name=hoge\[\]][href="http://hoge"][hidden]' => "this is text's content"]))
 *     ->isSame('<a id="hoge" class="c1 c2" name="hoge[]" href="http://hoge" hidden>this is text&#039;s content</a>'
 * );
 * // ネストした配列を与えると再帰される
 * that(
 *     htmltag([
 *         'div#wrapper' => [
 *             'b.class1' => [
 *                 '<plain>',
 *             ],
 *             'b.class2' => [
 *                 '<plain1>',
 *                 's' => '<strike>',
 *                 '<plain2>',
 *             ],
 *         ],
 *     ]))
 *     ->isSame('<div id="wrapper"><b class="class1">&lt;plain&gt;</b><b class="class2">&lt;plain1&gt;<s>&lt;strike&gt;</s>&lt;plain2&gt;</b></div>'
 * );
 * ```
 *
 * @package ryunosuke\Functions\Package\dataformat
 *
 * @param string|array $selector
 * @return string html 文字列
 */
function htmltag($selector)
{
    if (!is_iterable($selector)) {
        $selector = [$selector => ''];
    }

    $html = static fn($string) => htmlspecialchars($string, ENT_QUOTES);

    $build = static function ($selector, $content, $escape) use ($html) {
        $attrs = css_selector($selector);
        $tag = array_unset($attrs, '', '');
        if (!strlen($tag)) {
            throw new \InvalidArgumentException('tagname is empty.');
        }
        if (isset($attrs['class'])) {
            $attrs['class'] = implode(' ', $attrs['class']);
        }
        foreach ($attrs as $k => $v) {
            if ($v === false) {
                unset($attrs[$k]);
                continue;
            }
            elseif ($v === true) {
                $v = $html($k);
            }
            elseif (is_array($v)) {
                $v = 'style="' . array_sprintf($v, fn($style, $key) => is_int($key) ? $style : "$key:$style", ';') . '"';
            }
            else {
                $v = sprintf('%s="%s"', $html($k), $html(preg_replace('#^([\"\'])|([^\\\\])([\"\'])$#u', '$2', $v)));
            }
            $attrs[$k] = $v;
        }

        preg_match('#(\s*)(.+)(\s*)#u', $tag, $m);
        [, $prefix, $tag, $suffix] = $m;
        $tag_attr = $html($tag) . concat(' ', implode(' ', $attrs));
        $content = ($escape ? $html($content) : $content);

        return "$prefix<$tag_attr>$content</$tag>$suffix";
    };

    $result = '';
    foreach ($selector as $key => $value) {
        if (is_int($key)) {
            $result .= $html($value);
        }
        elseif (is_iterable($value)) {
            $result .= $build($key, htmltag($value), false);
        }
        else {
            $result .= $build($key, $value, true);
        }
    }
    return $result;
}
