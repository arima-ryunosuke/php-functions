<?php

require __DIR__ . '/../include/global.php';

$implode = 'implode';
$export = function ($value) use (&$export) {
    return is_array($value)
        ? '[' . array_sprintf($value, function ($v, $k) use ($export) { return $export($k) . ' => ' . $export($v); }, ', ') . ']'
        : var_export2($value, true);
};

// 全対象だといくらなんでも多すぎるので拡張で適当に差っ引くルール
$targetExtension = [
    'Core'     => '',
    'date'     => '',
    'hash'     => '',
    'pcre'     => '',
    'standard' => '',
    'mbstring' => '',
    ''         => '',
];

/** @var \ReflectionFunction[] $reffuncs */
/// 対象となる関数を掻き集める必要があるが、数パスかかる

// 明らかに不要なものは対象外
$reffuncs = [];
foreach (get_defined_functions(true) as $type => $functions) {
    foreach ($functions as $funcname) {
        $reffunc = new \ReflectionFunction($funcname);

        // 指定された拡張以外は除外
        if (!isset($targetExtension[(string) $reffunc->getExtensionName()])) {
            continue;
        }
        // 名前空間付きは呼びづらいので除外
        if ($reffunc->inNamespace()) {
            continue;
        }
        // 引数なしは呼ぶ意味がないので除外
        if ($reffunc->getNumberOfParameters() === 0) {
            continue;
        }
        // 参照返し関数は実質呼べないに等しいので除外
        if ($reffunc->returnsReference()) {
            continue;
        }
        // 参照渡し関数は実質呼べないに等しいので除外
        foreach ($reffunc->getParameters() as $p) {
            if ($p->isPassedByReference()) {
                continue 2;
            }
        }

        $reffuncs[$funcname] = $reffunc;
    }
}

// 特定プレフィックスを除去したエイリアスを追加
foreach ($reffuncs as $funcname => $reffunc) {
    foreach (['#^array_#', '#^str_#'] as $regex) {
        $newname = preg_splice($regex, '', $funcname);
        if (!isset($reffuncs[$newname])) {
            $reffuncs[$newname] = $reffunc;
            break;
        }
    }
}

// ↑の除去やエイリアスで飛び飛びになるので本当の名前でソートする
$reffuncs = kvsort($reffuncs, function ($a, $b) { return strcmp($a->name, $b->name); });

// ここから本懐。アノテーション文字列を生成する
$anotations = [];
foreach ($reffuncs as $funcname => $reffunc) {
    $anotations[] = " * @see " . $reffunc->name;

    // 実質引数が1つならフィールド呼び出しが可能
    if ($reffunc->getNumberOfRequiredParameters() === 1) {
        $anotations[] = " * @property \ChainObject \$$funcname";
    }

    // 仮引数文字列を構築
    $hasCallback = array_find($reffunc->getParameters(), function (\ReflectionParameter $p) {
        if ($p->hasType()) {
            $type = $p->getType();
            if ($type instanceof \ReflectionNamedType && (strpos($type->getName(), 'callable') !== false || strpos($type->getName(), 'Closure') !== false)) {
                return true;
            }
        }
        // 組み込み関数は大抵の場合 $callback で登録されているようだ（ここは結構な頻度でいじると思う）
        if (strpos($p->getName(), 'callback') !== false || strpos($p->getName(), 'callable') !== false) {
            return true;
        }
    }, false);
    $params = array_values(function_parameter($reffunc));

    // callback を受け取る関数なら P, E も登録
    $funcs = [$funcname];
    if ($hasCallback) {
        $funcs[] = "{$funcname}P";
        $funcs[] = "{$funcname}E";
    }
    foreach ($funcs as $f) {
        for ($i = null, $l = $reffunc->getNumberOfParameters(); $i < $l; $i++) {
            $args = $params;
            // 可変引数は5件程度水増しする
            if ($reffunc->getParameters()[(int) $i]->isVariadic()) {
                for ($j = $i; $j <= $i + 5; $j++) {
                    $anotations[] = " * @method   \ChainObject  $f{$j}({$implode(', ', $args)})";
                }
                continue;
            }
            array_splice($args, $i, 1);
            $anotations[] = " * @method   \ChainObject  $f{$i}({$implode(', ', $args)})";
        }
    }
    $anotations[] = " *";
}

$vars = [
    'annotation' => $implode("\n", $anotations),
];

foreach (glob(__DIR__ . '/../stub/*.php') as $phpfile) {
    $contents = file_get_contents($phpfile);
    foreach ($vars as $tagname => $tagvalue) {
        $contents = preg_replace_callback("#(\\{{$tagname}\\})(.+)(\{\/{$tagname}\\})#smu", function ($m) use ($tagvalue) {
            return "{$m[1]}\n{$tagvalue}\n * {$m[3]}";
        }, $contents);
    }
    file_put_contents($phpfile, $contents);
}
