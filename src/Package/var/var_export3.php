<?php /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_and.php';
require_once __DIR__ . '/../array/is_hasharray.php';
require_once __DIR__ . '/../classobj/object_properties.php';
require_once __DIR__ . '/../misc/php_indent.php';
require_once __DIR__ . '/../misc/php_tokens.php';
require_once __DIR__ . '/../reflection/callable_code.php';
require_once __DIR__ . '/../var/is_primitive.php';
require_once __DIR__ . '/../var/is_resourcable.php';
require_once __DIR__ . '/../var/var_export3_importer.php';
// @codeCoverageIgnoreEnd

/**
 * var_export を色々と出力できるようにしたもの
 *
 * php のコードに落とし込むことで serialize と比較してかなり高速に動作する。
 *
 * 各種オブジェクトやクロージャ、循環参照を含む配列など様々なものが出力できる。
 * ただし、下記は不可能あるいは復元不可（今度も対応するかは未定）。
 *
 * - 特定の内部クラス（PDO など）
 * - 大部分のリソース
 *
 * ただし args キーに指定した値は出力されず、import 時にそれらを引数とするクロージャを返すようになるため、疑似的に出力することは可能。
 * vars キーも同様（クロージャではなく、ローカル変数が情報源になる）。
 * args と vars は両立でき、その場合 vars+args が渡ってくるクロージャとなる。
 *
 * オブジェクトは「リフレクションを用いてコンストラクタなしで生成してプロパティを代入する」という手法で復元する。
 * ただしコンストラクタが必須引数無しの場合はコールされる。
 * のでクラスによってはおかしな状態で復元されることがある（大体はリソース型のせいだが…）。
 * sleep, wakeup, Serializable などが実装されているとそれはそのまま機能する。
 * set_state だけは呼ばれないので注意。
 *
 * Generator は元となった関数/メソッドを再コールすることで復元される。
 * その仕様上、引数があると呼べないし、実行位置はリセットされる。
 *
 * クロージャはコード自体を引っ張ってきて普通に function (){} として埋め込む。
 * クラス名のエイリアスや use, $this バインドなど可能な限り復元するが、おそらくあまりに複雑なことをしてると失敗する。
 *
 * リソースはファイル的なリソースであればメタ情報を出力して復元時に再オープンする。
 *
 * 軽くベンチを取ったところ、オブジェクトを含まない純粋な配列の場合、serialize の 200 倍くらいは速い（それでも var_export の方が速いが…）。
 * オブジェクトを含めば含むほど遅くなり、全要素がオブジェクトになると serialize と同程度になる。
 * 大体 var_export:var_export3:serialize が 1:5:1000 くらい。
 *
 * Example:
 * ```php
 * // 出力不可を含む配列
 * $value = [
 *     'stdout' => STDOUT,
 *     'pdo'    => new \PDO('sqlite::memory:'),
 * ];
 *
 * // args を指定すると実際はエクスポートされず、クロージャ表現を返すようになる（値だけ見るのでキーはなんでもよい）
 * $exported = var_export3($value, ['outmode' => 'eval', 'args' => ['k1' => STDOUT, 'k2' => $value['pdo']]]);
 * // import するとクロージャが得られる
 * $closure = eval($exported);
 * that($closure)->isInstanceOf(\Closure::class);
 * // 引数付きで実行すれば値が得られる（この引数のキーは出力時のキーと合わせなければならない）
 * $imported = $closure(['k1' => STDOUT, 'k2' => $value['pdo']]);
 * that($imported['stdout'])->isSame($value['stdout']);
 * that($imported['pdo'])->isSame($value['pdo']);
 * // 要するに実行時に与えられるわけなので、やる気になれば全く関係ない値でも可能
 * $imported = $closure(['k1' => 123, 'k2' => 456]);
 * that($imported['stdout'])->isSame(123);
 * that($imported['pdo'])->isSame(456);
 *
 * // vars を指定すると実際はエクスポートされず、実行時のローカルコンテキストを見るようになる（キーは変数名として valid なもの）
 * $exported = var_export3($value, ['outmode' => 'eval', 'vars' => ['k1' => STDOUT, 'k2' => $value['pdo']]]);
 * // ローカル変数を用意してから import すればその値が得られる
 * $k1 = STDOUT;
 * $k2 = $value['pdo'];
 * $imported = eval($exported);
 * that($imported['stdout'])->isSame($value['stdout']);
 * that($imported['pdo'])->isSame($value['pdo']);
 * ```
 *
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $value エクスポートする値
 * @param bool|array $return 返り値として返すなら true. 配列を与えるとオプションになる
 * @return string エクスポートされた文字列
 */
function var_export3($value, $return = false)
{
    // 原則として var_export に合わせたいのでデフォルトでは bool: false で単に出力するのみとする
    if (is_bool($return)) {
        $return = [
            'return' => $return,
        ];
    }
    $options = $return;
    $options += [
        'format'   => 'pretty', // pretty or minify
        'outmode'  => null,     // null: 本体のみ, 'eval': return ...;, 'file': <?php return ...;
        'callback' => null,     // 値1つごとのコールバック（値とキー配列とネストレベルが引数で渡ってくる）
        'args'     => [],       // ここで指定した値は export に含まれず、import 時に引数で要求されるようになる
        'vars'     => [],       // ここで指定した値は export に含まれず、import 時に変数で要求されるようになる
        'importer' => null,     // importer 指定（普段使いは気にしなくてよい）
    ];
    $options['return'] ??= !!$options['outmode'];

    $var_manager = new class() {
        private $vars = [];
        private $refs = [];
        private $ids  = [];

        private function arrayHasReference($array)
        {
            foreach ($array as $k => $v) {
                $ref = \ReflectionReference::fromArrayElement($array, $k);
                if ($ref) {
                    return true;
                }
                if (is_array($v) && $this->arrayHasReference($v)) {
                    return true;
                }
            }
            return false;
        }

        public function varId($var)
        {
            // オブジェクトは明確な ID が取れる（generator/closure/object の区分けに処理的な意味はない）
            if (is_object($var)) {
                $id = ($var instanceof \Generator ? 'generator' : ($var instanceof \Closure ? 'closure' : 'object')) . (spl_object_id($var) + 1);
                $this->vars[$id] = $var;
                return $id;
            }
            // 配列は明確な ID が存在しないので、貯めて検索して ID を振る（参照さえ含まなければ ID に意味はないので参照込みのみ）
            // 何度か検証してしまったので備忘:
            // ID を振らない方が格段に速いのでそのための分岐の目的もある
            // ID を振ると参照は関係なく・・・
            // - return $this->array1 = [$this->array2 = [$this->array3 = [...]]];
            // のようになり、（多分プロパティの動的作成で）結構遅くなる
            // ID を振らなければ・・・
            // - return [[[...]]];
            // のようになり、実質的に opcache を返すだけになる
            if (is_array($var) && $this->arrayHasReference($var)) {
                $id = array_search($var, $this->vars, true);
                if (!$id) {
                    $id = 'array' . (count($this->vars) + 1);
                }
                $this->vars[$id] = $var;
                return $id;
            }
            // リソースも一応は ID がある
            if (is_resourcable($var)) {
                $id = 'resource' . (int) $var;
                $this->vars[$id] = $var;
                return $id;
            }
        }

        public function refId($array, $k)
        {
            $ref = \ReflectionReference::fromArrayElement($array, $k);
            if ($ref) {
                $refid = $ref->getId();
                $this->ids[$refid] = ($this->ids[$refid] ?? count($this->ids) + 1);
                $id = 'reference' . $this->ids[$refid];
                $this->refs[$id] = $array[$k];
                return $id;
            }
        }

        public function orphan()
        {
            foreach ($this->refs as $rid => $var) {
                $vid = array_search($var, $this->vars, true);
                yield $rid => [!!$vid, $vid, $var];
            }
            return $this->vars || $this->refs;
        }
    };

    // 再帰用クロージャ
    $vars = [];
    $export = function ($value, $nest = 0, $raw = false) use (&$export, &$vars, $var_manager, $options) {
        $spacer0 = str_repeat(" ", 4 * max(0, $nest + 0));
        $spacer1 = str_repeat(" ", 4 * max(0, $nest + 1));
        $raw_export = fn($v) => $v;
        $var_export = fn($v) => var_export($v, true);

        $vid = $var_manager->varId($value);
        if ($vid) {
            if (isset($vars[$vid])) {
                return "\$this->$vid";
            }
            $vars[$vid] = $value;
        }

        if ($options['callback']) {
            $exported = $options['callback']($value, $nest);
            if ($exported !== null) {
                return "\$this->$vid = $exported";
            }
        }

        if (($arg = array_search($value, $options['args'], true)) !== false || ($arg = array_search($value, $options['vars'], true)) !== false) {
            return "\$this->$vid = \$this->args[{$var_export($arg)}]";
        }

        if (is_array($value)) {
            $hashed = is_hasharray($value);
            if (!$hashed && array_and($value, fn(...$args) => is_primitive(...$args))) {
                [$begin, $middle, $end] = ["", ", ", ""];
            }
            else {
                [$begin, $middle, $end] = ["\n{$spacer1}", ",\n{$spacer1}", ",\n{$spacer0}"];
            }

            $keys = array_map($var_export, array_combine($keys = array_keys($value), $keys));
            $maxlen = max(array_map('strlen', $keys ?: ['']));
            $kvl = [];
            foreach ($value as $k => $v) {
                $refid = $var_manager->refId($value, $k);
                $keystr = $hashed ? $keys[$k] . str_repeat(" ", $maxlen - strlen($keys[$k])) . " => " : '';
                $valstr = $refid ? "&\$this->$refid" : $export($v, $nest + 1);
                $kvl[] = $keystr . $valstr;
            }
            $kvl = implode($middle, $kvl);
            $declare = $vid ? "\$this->$vid = " : "";
            return "{$declare}[$begin{$kvl}$end]";
        }
        if ($value instanceof \Generator) {
            $ref = new \ReflectionGenerator($value);
            $reffunc = $ref->getFunction();

            if ($reffunc->getNumberOfRequiredParameters() > 0) {
                throw new \DomainException('required argument Generator is not support.');
            }

            $caller = null;
            if ($reffunc instanceof \ReflectionFunction) {
                if ($reffunc->isClosure()) {
                    $caller = "({$export($reffunc->getClosure(), $nest)})";
                }
                else {
                    $caller = $reffunc->name;
                }
            }
            if ($reffunc instanceof \ReflectionMethod) {
                if ($reffunc->isStatic()) {
                    $caller = "{$reffunc->class}::{$reffunc->name}";
                }
                else {
                    $caller = "{$export($ref->getThis(), $nest)}->{$reffunc->name}";
                }
            }
            return "\$this->$vid = {$caller}()";
        }
        if ($value instanceof \Closure) {
            $ref = new \ReflectionFunction($value);
            $bind = $ref->getClosureThis();
            $class = $ref->getClosureScopeClass();

            // 内部由来はきちんと fromCallable しないと差異が出てしまう
            if ($ref->isInternal()) {
                $receiver = $bind ?? $class?->getName();
                $callee = $receiver ? [$receiver, $ref->getName()] : $ref->getName();
                return "\$this->$vid = \\Closure::fromCallable({$export($callee, $nest)})";
            }

            // use 変数の導出 for compatible php8.1
            $statics = method_exists($ref, 'getClosureUsedVariables') ? null : $ref->getStaticVariables();
            $uses = method_exists($ref, 'getClosureUsedVariables') ? $ref->getClosureUsedVariables() : [];
            $uses = array_map(fn($v, $k) => "$spacer1\$$k = {$raw_export($v === $value ? '&' : '')}{$export($v, $nest + 1)};\n", $uses, array_keys($uses));

            [$meta, $body, $attrs] = callable_code($value, true);
            $arrow = !!array_filter($meta, fn($token) => $token->is(T_FN));
            $tokens = array_merge(
                ...$attrs,
                ...[$meta, [$meta[0]->clone(id: -1, text: $arrow ? ' => ' : ' ')], $body],
            );

            $context = [
                'class' => 0,
                'brace' => 0,
            ];
            foreach ($tokens as $n => $token) {
                $prev = $token->prev() ?? (object) ['id' => null, 'text' => null, 'line' => null];
                $next = $token->next() ?? (object) ['id' => null, 'text' => null, 'line' => null];
                assert([$prev, $next]); // あらかじめ取得しておかないとズレるかもしれない

                // クロージャは何でもかける（クロージャ・無名クラス・ジェネレータ etc）のでネスト（ブレース）レベルを記録しておく
                if ($token->text === '{') {
                    $context['brace']++;
                }
                if ($token->text === '}') {
                    $context['brace']--;
                }

                // 無名クラスは色々厄介なので読み飛ばすために覚えておく
                if ($prev->id === T_NEW && $token->id === T_CLASS) {
                    $context['class'] = $context['brace'];
                }
                // そして無名クラスは色々かける上に終了条件が自明ではない（シンタックスエラーでない限りは {} が一致するはず）
                if ($token->text === '}' && $context['class'] === $context['brace']) {
                    $context['class'] = 0;
                }

                // fromCallable 由来だと名前がついてしまう
                if ($prev->id === T_FUNCTION && $token->id === T_STRING) {
                    if ((!$arrow && $context['class'] === 0) || ($arrow && $context['class'] === 1)) {
                        unset($tokens[$n]);
                        continue;
                    }
                }

                // use 変数の導出 for compatible php8.1
                if ($statics !== null) {
                    if ($token->id === T_VARIABLE) {
                        $varname = substr($token->text, 1);
                        // クロージャ内クロージャの use に反応してしまうので存在するときのみとする
                        if (array_key_exists($varname, $statics) && !isset($uses[$varname])) {
                            $recurself = $statics[$varname] === $value ? '&' : '';
                            $uses[$varname] = "$spacer1\$$varname = $recurself{$export($statics[$varname], $nest + 1)};\n";
                        }
                    }
                }

                $tokens[$n] = $token->clone(text: $token->resolve($ref));
            }

            $code = php_indent(implode('', array_column($tokens, 'text')), [
                'indent'   => $spacer1,
                'baseline' => -1,
            ]);

            if ($bind) {
                $instance = $export($bind, $nest + 1);
                if ($class->isAnonymous()) {
                    $scope = "get_class({$export($bind, $nest + 1)})";
                }
                else {
                    $scope = $var_export($class?->getName() === 'Closure' ? 'static' : $class?->getName());
                }
                $code = "\Closure::bind($code, $instance, $scope)";
            }

            return "\$this->$vid = (function () {\n{$raw_export(implode('', $uses))}{$spacer1}return $code;\n$spacer0})->call(\$this)";
        }
        if (is_object($value)) {
            $ref = new \ReflectionObject($value);

            // enum はリテラルを返せばよい
            if ($value instanceof \UnitEnum) {
                $declare = "\\$ref->name::$value->name";
                if ($ref->getConstant($value->name) === $value) {
                    return "\$this->$vid = $declare";
                }
                // enum の polyfill で、__callStatic を利用して疑似的にエミュレートしているライブラリは多い
                // もっとも、「多い」だけであり、そうとは限らないので値は見る必要はある（例外が飛ぶかもしれないので try も必要）
                if ($ref->hasMethod('__callStatic')) {
                    try {
                        if ($declare() === $value) {
                            return "\$this->$vid = $declare()";
                        }
                    }
                    catch (\Throwable) { // @codeCoverageIgnore
                        // through. treat regular object
                    }
                }
            }

            // 弱参照系は同時に渡ってきていれば復元できる
            if ($value instanceof \WeakReference) {
                $weakreference = $value->get();
                if ($weakreference === null) {
                    $weakreference = new \stdClass();
                }
                return "\$this->$vid = \\WeakReference::create({$export($weakreference, $nest)})";
            }
            if ($value instanceof \WeakMap) {
                $weakmap = "{$spacer1}\$this->$vid = new \\WeakMap();\n";
                foreach ($value as $object => $data) {
                    $weakmap .= "{$spacer1}\$this->{$vid}[{$export($object)}] = {$export($data)};\n";
                }
                return "\$this->$vid = (function () {\n{$weakmap}{$spacer1}return \$this->$vid;\n$spacer0})->call(\$this)";
            }

            // 内部クラスで serialize 出来ないものは __PHP_Incomplete_Class で代替（復元時に無視する）
            try {
                if ($ref->isInternal()) {
                    serialize($value);
                }
            }
            catch (\Exception $e) {
                // ただし無名クラス由来の失敗なら何とかできる（かもしれない。やってみないと分からない）のでスルー
                if (!str_contains($e->getMessage(), '@anonymous')) {
                    return "\$this->$vid = new \\__PHP_Incomplete_Class()";
                }
            }

            // 無名クラスは定義がないのでパースが必要
            // さらにコンストラクタを呼ぶわけには行かない（引数を検出するのは不可能）ので潰す必要もある
            if ($ref->isAnonymous()) {
                $fname = $ref->getFileName();
                $sline = $ref->getStartLine();
                $eline = $ref->getEndLine();
                $tokens = php_tokens('<?php ' . implode('', array_slice(file($fname), $sline - 1, $eline - $sline + 1)));

                $block = [];
                // 無名クラスは new class か new #[Attribute] で始まるはず（new #[A] ClassName は許可されていない）
                $new = $tokens[0]->next(T_NEW);
                if ($new->next()->is(T_CLASS) || $new->next()->is(T_ATTRIBUTE)) {
                    $brace_begin = $new->next(['(', '{']);

                    // コンストラクタの呼び出し引数はスキップする
                    if ($brace_begin->is('(')) {
                        $end = $brace_begin->end();
                        for ($i = $brace_begin->index; $i <= $end->index; $i++) {
                            $tokens[$i]->id = -1;
                            $tokens[$i]->text = '';
                        }
                        $brace_begin = $brace_begin->next('{');
                    }

                    // 引数ありコンストラクタは潰すので昇格プロパティを宣言しなければならない
                    $promoted_properties = [];
                    foreach (array_filter($ref->getProperties(), fn($property) => $property->isPromoted()) as $property) {
                        $modifierBits = [
                            \ReflectionProperty::IS_PUBLIC    => 'public',
                            \ReflectionProperty::IS_PROTECTED => 'protected',
                            \ReflectionProperty::IS_PRIVATE   => 'private',
                            //\ReflectionProperty::IS_READONLY  => 'readonly', // 後から入れる関係上 readonly は対応できない
                        ];

                        $promoted_properties[] = sprintf('%s %s $%s;',
                            implode(' ', array_filter($modifierBits, fn($bit) => $property->getModifiers() & $bit, ARRAY_FILTER_USE_KEY)),
                            $property?->getType() ?? '',
                            $property->getName(),
                        );
                    }

                    // 引数ありコンストラクタは呼ばないので潰しておく
                    $construct = $brace_begin->next('__construct');
                    if ($construct && $ref->getConstructor() && $ref->getConstructor()->getNumberOfRequiredParameters()) {
                        $construct->text = 'replaced__construct';
                        $parenthesis_begin = $construct->next('(');
                        $parenthesis_end = $parenthesis_begin->end();
                        for ($i = $parenthesis_begin->index + 1; $i < $parenthesis_end->index; $i++) {
                            $tokens[$i]->id = -1;
                            $tokens[$i]->text = '';
                        }
                    }

                    $brace_end = $brace_begin->end();
                    foreach (array_slice($tokens, $new->index, $brace_end->index - $new->index + 1) as $token) {
                        $block[] = $token->resolve($ref);
                        if ($token === $brace_begin) {
                            $block[] = implode("", $promoted_properties);
                        }
                    }
                }

                $code = php_indent(implode('', $block), [
                    'indent'   => $spacer1,
                    'baseline' => -1,
                ]);
                if ($raw) {
                    return $code;
                }
                $classname = "(function () {\n{$spacer1}return $code;\n{$spacer0}})";
            }
            else {
                $classname = "\\" . get_class($value) . "::class";
            }

            $privates = [];

            // __serialize があるならそれに従う
            if (method_exists($value, '__serialize')) {
                $fields = $value->__serialize();
            }
            // __sleep があるならそれをプロパティとする
            elseif (method_exists($value, '__sleep')) {
                $fields = array_intersect_key(object_properties($value, $privates), array_flip($value->__sleep()));
            }
            // それ以外は適当に漁る
            else {
                $fields = object_properties($value, $privates);
            }

            return "\$this->new(\$this->$vid, $classname, (function () {\n{$spacer1}return {$export([$fields, $privates], $nest + 1)};\n{$spacer0}}))";
        }
        if (is_resourcable($value)) {
            // スタンダードなリソースなら復元できないこともない
            $meta = stream_get_meta_data($value);
            $stream_type = strtolower($meta['stream_type']);
            if (!in_array($stream_type, ['stdio', 'output', 'temp', 'memory'], true)) {
                throw new \DomainException('resource is supported stream resource only.');
            }
            $meta['position'] = @ftell($value);
            $meta['context'] = stream_context_get_options($value);
            $meta['buffer'] = null;
            if (in_array($stream_type, ['temp', 'memory'], true)) {
                $meta['buffer'] = stream_get_contents($value, null, 0);
            }
            return "\$this->$vid = \$this->open({$export($meta, $nest + 1)})";
        }

        return is_null($value) ? 'null' : $var_export($value);
    };

    $exported = $export($value, 1);
    $others = [];
    $vars = [];
    $orphan = $var_manager->orphan();
    foreach ($orphan as $rid => [$isref, $vid, $var]) {
        $declare = $isref ? "&\$this->$vid" : $export($var, 1);
        $others[] = "\$this->$rid = $declare;";
    }

    $E = fn($v) => $v;
    $function = <<<PHP
        function (\$args) {
            \$this->args = \$args;
            {$E(implode("\n    ", $others))}
            return $exported;
        }
        PHP;

    $importer = var_export3_importer($options['importer']);
    if ($options['importer'] === null) {
        $factory = $export($importer, -1, true);
    }
    else {
        $factory = "new {$options['importer']}()";
    }

    if (!($options['args'] || $options['vars'] || $orphan->getReturn())) {
        $result = $exported;
    }
    elseif ($options['args'] && $options['vars']) {
        $result = "fn(\$args) => ({$function})->call($factory, get_defined_vars() + \$args)";
    }
    elseif ($options['args']) {
        $result = "fn(\$args) => ({$function})->call($factory, \$args)";
    }
    elseif ($options['vars']) {
        $result = "({$function})->call($factory, get_defined_vars())";
    }
    else {
        $result = "({$function})->call($factory, [])";
    }

    if ($options['format'] === 'minify') {
        $tmp = tempnam(sys_get_temp_dir(), 've3');
        file_put_contents($tmp, "<?php $result;");
        $result = substr(php_strip_whitespace($tmp), 6, -1);
    }

    if ($options['outmode'] === 'eval') {
        $result = "return $result;";
    }
    if ($options['outmode'] === 'file') {
        $result = "<?php return $result;\n";
    }

    if (!$options['return']) {
        echo $result;
    }
    return $result;
}
