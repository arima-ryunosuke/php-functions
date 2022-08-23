<?php

require __DIR__ . '/../include/global.php';

$V = fn($v) => $v;

$targetDirectory = __DIR__ . '/../stub';
rm_rf("$targetDirectory/extenstions");
@mkdir("$targetDirectory/extenstions");

$targetExtension = [
    'date'     => [
        'timezone*',
    ],
    'hash'     => [],
    'pcre'     => [],
    'standard' => [
        'chroot',
        'lchgrp',
        'lchown',
        'nl_langinfo',
        'ob_*',
        'proc_*',
        'sapi_*',
        'socket_*',
        'stream_*',
        'strptime',
    ],
    'mbstring' => [],
    'user'     => [],
];

/** @var \ReflectionFunction[][] $reffuncs */

// 明らかに不要なものは対象外
$reffuncs = [];
foreach (get_defined_functions(true) as $type => $functions) {
    foreach ($functions as $funcname) {
        $reffunc = new ReflectionFunction($funcname);
        $extension = (string) $reffunc->getExtensionName() ?: 'user';

        // 指定された物以外は除外
        foreach ($targetExtension[$extension] ?? ['*'] as $exclude) {
            if (fnmatch($exclude, $funcname)) {
                continue 2;
            }
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
        // 参照渡しだけの関数は実質呼べないに等しいので除外
        if (array_all($reffunc->getParameters(), fn(ReflectionParameter $p) => $p->isPassedByReference())) {
            continue;
        }

        $reffuncs[$extension][$funcname] = $reffunc;
    }
}

// 特別扱いしてるもの
$reffuncs['user']['map'] = new class(fn(array $array, ?callable $callback) => null) extends ReflectionFunction {
    public function getName() { return 'array_map'; }
};

// ここから本懐。trait を書き出してその trait 名を得る
$traits = [];
foreach ($reffuncs as $extension => $funcs) {
    // 除去やエイリアスで飛び飛びになるので本当の名前でソートする
    uasort($funcs, function ($a, $b) { return strcmp($a->getName(), $b->getName()); });

    // アノテーション文字列を生成する
    $anotations = [];
    foreach ($funcs as $funcname => $reffunc) {
        $fieldable = $reffunc->getNumberOfRequiredParameters() === 1;
        $parameters = array_values(function_parameter($reffunc));
        $hasCallback = array_find($reffunc->getParameters(), function (\ReflectionParameter $p) {
            // package 内部は型宣言が追いついていないので名前でも判定（型宣言が済んだら不要）
            return str_exists($p->getName(), ['callable', 'callback']) || str_exists(reflect_types($p->getType()), ['callable', 'Closure']);
        }, false);

        // エイリアス分生成
        $aliasname = preg_replace('#^(array_|str_)#', '', $funcname);
        $callnames = [$funcname];
        if ($aliasname !== $funcname) {
            $callnames[] = $aliasname;
        }
        foreach ($callnames as $callname) {
            $anotation = [];
            $anotation[] = "    /** @see \\{$reffunc->getName()}() */";

            // 実質引数が1つならフィールド呼び出しが可能
            if ($fieldable) {
                $anotation[] = "    public self \$$callname;";
            }

            // callback を受け取る関数なら P, E も登録
            $variation = [''];
            if ($hasCallback) {
                $variation[] = 'P';
                $variation[] = 'E';
            }
            foreach ($variation as $v) {
                $anotation[] = "    public function $callname{$v}({$V(implode(', ', $parameters))}): self { }";
                foreach (range(0, $reffunc->getNumberOfParameters() - 1) as $i) {
                    $anotation[] = "    public function $callname{$i}{$v}({$V(implode(', ', array_remove($parameters, [$i])))}): self { }";
                }
            }

            $anotations[] = implode("\n", $anotation) . "\n";
        }
    }

    // trait の書き出し（phpstorm がフリーズするので小分けにする）
    foreach (array_chunk($anotations, 64) as $n => $chunks) {
        $traitname = "{$extension}_{$n}";
        $contents = <<<TRAIT
        <?php
        {$V('// @' . 'formatter:off')}
        
        /**
         * @noinspection PhpLanguageLevelInspection
         * @noinspection PhpUnusedParameterInspection
         * @noinspection PhpUndefinedClassInspection
         */
        trait $traitname
        {
        {$V(implode("\n", $chunks))}
        }
        
        TRAIT;
        file_put_contents("$targetDirectory/extenstions/$traitname.php", $contents);

        $traits[] = "    use $traitname;";
    }
}

$mainclass = file_get_contents("$targetDirectory/ChainObject.php");
$mainclass = preg_replace_callback("#(^\s*// \\{annotation\\})(.+)(^\s*// \\{/annotation\\})#smu", fn($m) => <<<USE
    $m[1]
    {$V(implode("\n", $traits))}
    {$m[3]}
    USE, $mainclass);
file_put_contents("$targetDirectory/ChainObject.php", $mainclass);
