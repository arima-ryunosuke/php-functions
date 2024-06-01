<?php

require __DIR__ . '/../include/global.php';

$V = fn($v) => $v;

$targetDirectory = __DIR__ . '/../stub';
rm_rf("$targetDirectory/ChainObject");
mkdir("$targetDirectory/ChainObject");

$targetFunction = [
    'cpu_timer'        => [],
    'include_stream'   => [],
    'object_storage'   => [],
    'process_async'    => [PHP_BINARY, ['-v']],
    'cacheobject'      => [__DIR__],
    'reflect_callable' => [function () { }],
    'reflect_types'    => [],
];

foreach ($targetFunction as $funcname => $args) {
    $object = $funcname(...$args);
    $refobject = new \ReflectionObject($object);

    $extends = concat(" extends ", get_parent_class($object));
    $implements = concat(" implements ", implode(', ', class_implements($object)));
    $uses = concat("\n    use ", implode(', ', class_uses($object)));

    $doccomment = preg_replace('#^/\*\*\s*|\s*\*/$#ums', '', $refobject->getDocComment() ?: '*');
    $doccomment = preg_replace('#\\R\s+#u', "\n ", $doccomment);
    $classname = pascal_case($funcname);
    $properties = array_map_filter($refobject->getProperties(), function (\ReflectionProperty $property) {
        if ($property->isPublic()) {
            $doccomment = preg_replace('#\\R\s+#u', "\n ", $property->getDocComment());
            $doccomment = concat($doccomment, "\n");
            return "    " . preg_replace('#\\R#u', "\n    ", $doccomment . "public $" . $property->getName() . ";");
        }
    });
    $methods = array_map_filter($refobject->getMethods(), function (\ReflectionMethod $method) {
        if ($method->isPublic() && !$method->isConstructor() && !$method->isDestructor()) {
            $doccomment = preg_replace('#\\R\s+#u', "\n ", $method->getDocComment());
            $doccomment = concat($doccomment, "\n");
            $return = $method->hasReturnType() ? ": {$method->getReturnType()}" : "";
            return "    " . preg_replace('#\\R#u', "\n    ", $doccomment . "public function " . $method->getName() . "(" . implode(", ", function_parameter($method)) . ")$return { }");
        }
    });

    file_put_contents("$targetDirectory/$classname.php", <<<CLASS
    <?php
    {$V('// @' . 'formatter:off')}
    
    /**
     * stub for $funcname
     *
     $doccomment
     *
     * @used-by \\{$funcname}()
     * @used-by \\ryunosuke\\Functions\\{$funcname}()
     * @used-by \\ryunosuke\\Functions\\Package\\{$funcname}()
     */
    class $classname$extends$implements
    {{$uses}
    {$V(implode("\n", $properties))}
    
    {$V(implode("\n", $methods))}
    }
    
    CLASS,);
}

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

$anotations = [];
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

        $parameters = function_parameter($reffunc);
        // 特別扱い1（昔の名残か必須を表すためか、可変引数の引数が分かれている標準関数がある（min,max,array_intersect 等））
        $params = $reffunc->getParameters();
        if (true
            && $reffunc->isVariadic() && count($params) === 2
            && $params[0]->hasType() && $params[1]->hasType()
            && $params[0]->getType()->getName() === $params[1]->getType()->getName()
        ) {
            // echo "{$reffunc->name}({$V(implode(', ', $parameters))})\n";
            array_shift($parameters);
        }
        // 特別扱い2（package 内部は型宣言が追いついていないので名前でも判定（型宣言が済んだら不要））
        foreach ($params as $param) {
            $key = ($param->isPassedByReference() ? '&' : '') . '$' . $param->getName();
            if (!$param->hasType() && str_exists($param->getName(), ['callable', 'callback'])) {
                $parameters[$key] = 'callable ' . $parameters[$key];
            }
            if (!$param->hasType() && str_exists($param->getName(), ['array', 'iterable'])) {
                $parameters[$key] = 'iterable ' . $parameters[$key];
            }
        }
        $parameters = array_values($parameters);

        // エイリアス分生成
        $aliasname = preg_replace('#^(array_|str_)#', '', $funcname);
        $callnames = [$funcname];
        if ($aliasname !== $funcname) {
            $callnames[] = $aliasname;
        }
        foreach ($callnames as $callname) {
            // 多重定義（他言語で言うオーバーロード）になるが、別に実行されないし phpstorm はこれでもよしなに判定してくれる
            $anotations[base_convert(substr(md5($reffunc->getName()), 0, 2), 16, 10) % 10][] = <<<STUB
                /** @see {$reffunc->getName()}() */
                public self \$$callname;
                public function $callname({$V(implode(', ', $parameters))}): self { }
                public function $callname({$V(implode(', ', array_remove($parameters, [0])))}): self { }
            
            STUB;
        }
    }
}
ksort($anotations);

// trait の書き出し（phpstorm がフリーズするので小分けにする）
$traits = [];
foreach ($anotations as $initial => $chunks) {
    $traitname = "ChainObject$initial";
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
    file_put_contents("$targetDirectory/ChainObject/$traitname.php", $contents);

    $traits[] = "    use $traitname;";
}

$mainclass = file_get_contents("$targetDirectory/ChainObject.php");
$mainclass = preg_replace_callback("#(^\s*// \\{annotation\\})(.+)(^\s*// \\{/annotation\\})#smu", fn($m) => <<<USE
    $m[1]
    {$V(implode("\n", $traits))}
    {$m[3]}
    USE, $mainclass);
file_put_contents("$targetDirectory/ChainObject.php", $mainclass);
