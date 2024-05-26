<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * オブジェクトのプロパティを可視・不可視を問わず取得する
 *
 * get_object_vars + no public プロパティを返すイメージ。
 * クロージャだけは特別扱いで this + use 変数を返す。
 *
 * Example:
 * ```php
 * $object = new #[\AllowDynamicProperties] class('something', 42) extends \Exception{};
 * $object->oreore = 'oreore';
 *
 * // get_object_vars はそのスコープから見えないプロパティを取得できない
 * // var_dump(get_object_vars($object));
 *
 * // array キャストは全て得られるが null 文字を含むので扱いにくい
 * // var_dump((array) $object);
 *
 * // この関数を使えば不可視プロパティも取得できる
 * that(object_properties($object))->subsetEquals([
 *     'message' => 'something',
 *     'code'    => 42,
 *     'oreore'  => 'oreore',
 * ]);
 *
 * // クロージャは this と use 変数を返す
 * that(object_properties(fn() => $object))->is([
 *     'this'   => $this,
 *     'object' => $object,
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\classobj
 *
 * @param object $object オブジェクト
 * @param array $privates 継承ツリー上の private が格納される
 * @return array 全プロパティの配列
 */
function object_properties($object, &$privates = [])
{
    if ($object instanceof \Closure) {
        $ref = new \ReflectionFunction($object);
        $uses = method_exists($ref, 'getClosureUsedVariables') ? $ref->getClosureUsedVariables() : $ref->getStaticVariables();
        return ['this' => $ref->getClosureThis()] + $uses;
    }

    $fields = [];
    foreach ((array) $object as $name => $field) {
        $cname = '';
        $names = explode("\0", $name);
        if (count($names) > 1) {
            $name = array_pop($names);
            $cname = $names[1];
        }
        $fields[$cname][$name] = $field;
    }

    $classname = get_class($object);
    $parents = array_values(['', '*', $classname] + class_parents($object));
    uksort($fields, function ($a, $b) use ($parents) {
        return array_search($a, $parents, true) <=> array_search($b, $parents, true);
    });

    $result = [];
    foreach ($fields as $cname => $props) {
        foreach ($props as $name => $field) {
            if ($cname !== '' && $cname !== '*' && $classname !== $cname) {
                $privates[$cname][$name] = $field;
            }
            if (!array_key_exists($name, $result)) {
                $result[$name] = $field;
            }
        }
    }

    return $result;
}
