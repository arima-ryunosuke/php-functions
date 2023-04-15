<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * CSS セレクタ文字をパースして配列で返す
 *
 * 包含などではない属性セレクタを与えると属性として認識する。
 * 独自仕様として・・・
 *
 * - [!attr]: 否定属性として false を返す
 * - {styles}: style 属性とみなす
 *
 * がある。
 *
 * Example:
 * ```php
 * that(css_selector('#hoge.c1.c2[name=hoge\[\]][href="http://hoge"][hidden][!readonly]{width:123px;height:456px}'))->is([
 *     'id'       => 'hoge',
 *     'class'    => ['c1', 'c2'],
 *     'name'     => 'hoge[]',
 *     'href'     => 'http://hoge',
 *     'hidden'   => true,
 *     'readonly' => false,
 *     'style'    => [
 *         'width'  => '123px',
 *         'height' => '456px',
 *     ],
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\dataformat
 *
 * @param string $selector CSS セレクタ
 * @return array 属性配列
 */
function css_selector($selector)
{
    $tag = '';
    $id = '';
    $classes = [];
    $styles = [];
    $attrs = [];

    $context = null;
    $escaping = null;
    $chars = preg_split('##u', $selector, -1, PREG_SPLIT_NO_EMPTY);
    for ($i = 0, $l = count($chars); $i < $l; $i++) {
        $char = $chars[$i];
        if ($char === '"' || $char === "'") {
            $escaping = $escaping === $char ? null : $char;
        }

        if (!$escaping) {
            if ($context !== '{' && $context !== '[') {
                if ($char === '#') {
                    if (strlen($id)) {
                        throw new \InvalidArgumentException('#id is multiple.');
                    }
                    $context = $char;
                    continue;
                }
                if ($char === '.') {
                    $context = $char;
                    $classes[] = '';
                    continue;
                }
            }
            if ($char === '{') {
                $context = $char;
                $styles[] = '';
                continue;
            }
            if ($char === ';') {
                $styles[] = '';
                continue;
            }
            if ($char === '}') {
                $context = null;
                continue;
            }
            if ($char === '[') {
                $context = $char;
                $attrs[] = '';
                continue;
            }
            if ($char === ']') {
                $context = null;
                continue;
            }
        }

        if ($char === '\\') {
            $char = $chars[++$i];
        }

        if ($context === null) {
            $tag .= $char;
            continue;
        }
        if ($context === '#') {
            $id .= $char;
            continue;
        }
        if ($context === '.') {
            $classes[count($classes) - 1] .= $char;
            continue;
        }
        if ($context === '{') {
            $styles[count($styles) - 1] .= $char;
            continue;
        }
        if ($context === '[') {
            $attrs[count($attrs) - 1] .= $char;
            continue;
        }
    }

    $attrkv = [];
    if (strlen($tag)) {
        $attrkv[''] = $tag;
    }
    if (strlen($id)) {
        $attrkv['id'] = $id;
    }
    if ($classes) {
        $attrkv['class'] = $classes;
    }
    foreach ($styles as $style) {
        $declares = array_filter(array_map('trim', explode(';', $style)), 'strlen');
        foreach ($declares as $declare) {
            [$k, $v] = array_map('trim', explode(':', $declare, 2)) + [1 => null];
            if ($v === null) {
                throw new \InvalidArgumentException("[$k] is empty.");
            }
            $attrkv['style'][$k] = $v;
        }
    }
    foreach ($attrs as $attr) {
        [$k, $v] = explode('=', $attr, 2) + [1 => true];
        if (array_key_exists($k, $attrkv)) {
            throw new \InvalidArgumentException("[$k] is dumplicated.");
        }
        if ($k[0] === '!') {
            $k = substr($k, 1);
            $v = false;
        }
        $attrkv[$k] = is_string($v) ? json_decode($v) ?? $v : $v;
    }

    return $attrkv;
}
