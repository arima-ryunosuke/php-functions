<?php /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_all.php';
require_once __DIR__ . '/../array/is_hasharray.php';
require_once __DIR__ . '/../classobj/get_object_properties.php';
require_once __DIR__ . '/../funchand/is_bindable_closure.php';
require_once __DIR__ . '/../misc/indent_php.php';
require_once __DIR__ . '/../misc/parse_php.php';
require_once __DIR__ . '/../misc/resolve_symbol.php';
require_once __DIR__ . '/../reflection/callable_code.php';
require_once __DIR__ . '/../strings/starts_with.php';
require_once __DIR__ . '/../var/is_primitive.php';
require_once __DIR__ . '/../var/is_resourcable.php';
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
 * それ以外のリソースは null で出力される（将来的に例外にするかもしれない）。
 *
 * 軽くベンチを取ったところ、オブジェクトを含まない純粋な配列の場合、serialize の 200 倍くらいは速い（それでも var_export の方が速いが…）。
 * オブジェクトを含めば含むほど遅くなり、全要素がオブジェクトになると serialize と同程度になる。
 * 大体 var_export:var_export3:serialize が 1:5:1000 くらい。
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
        'format'  => 'pretty', // pretty or minify
        'outmode' => null,     // null: 本体のみ, 'eval': return ...;, 'file': <?php return ...;
    ];
    $options['return'] ??= !!$options['outmode'];

    $var_manager = new class() {
        private $vars = [];
        private $refs = [];

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
            static $ids = [];
            $ref = \ReflectionReference::fromArrayElement($array, $k);
            if ($ref) {
                $refid = $ref->getId();
                $ids[$refid] = ($ids[$refid] ?? count($ids) + 1);
                $id = 'reference' . $ids[$refid];
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
        }
    };

    // 再帰用クロージャ
    $vars = [];
    $export = function ($value, $nest = 0, $raw = false) use (&$export, &$vars, $var_manager) {
        $spacer0 = str_repeat(" ", 4 * max(0, $nest + 0));
        $spacer1 = str_repeat(" ", 4 * max(0, $nest + 1));
        $raw_export = fn($v) => $v;
        $var_export = fn($v) => var_export($v, true);
        $neighborToken = function ($n, $d, $tokens) {
            for ($i = $n + $d; isset($tokens[$i]); $i += $d) {
                if ($tokens[$i][0] !== T_WHITESPACE) {
                    return $tokens[$i];
                }
            }
        };
        $resolveSymbol = function ($token, $prev, $next, $ref) use ($var_export) {
            if ($token[0] === T_STRING) {
                if ($prev[0] === T_NEW || $next[0] === T_DOUBLE_COLON || $next[0] === T_VARIABLE || $next[1] === '{') {
                    $token[1] = resolve_symbol($token[1], $ref->getFileName(), 'alias') ?? $token[1];
                }
                elseif ($next[1] === '(') {
                    $token[1] = resolve_symbol($token[1], $ref->getFileName(), 'function') ?? $token[1];
                }
                else {
                    $token[1] = resolve_symbol($token[1], $ref->getFileName(), 'const') ?? $token[1];
                }
            }

            // マジック定数の解決（__CLASS__, __TRAIT__ も書き換えなければならないが、非常に大変なので下記のみ）
            if ($token[0] === T_FILE) {
                $token[1] = $var_export($ref->getFileName());
            }
            if ($token[0] === T_DIR) {
                $token[1] = $var_export(dirname($ref->getFileName()));
            }
            if ($token[0] === T_NS_C) {
                $token[1] = $var_export($ref->getNamespaceName());
            }
            return $token;
        };

        $vid = $var_manager->varId($value);
        if ($vid) {
            if (isset($vars[$vid])) {
                return "\$this->$vid";
            }
            $vars[$vid] = $value;
        }

        if (is_array($value)) {
            $hashed = is_hasharray($value);
            if (!$hashed && array_all($value, fn(...$args) => is_primitive(...$args))) {
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
            $class = $ref->getClosureScopeClass() ? $ref->getClosureScopeClass()->getName() : null;
            $statics = $ref->getStaticVariables();

            // 内部由来はきちんと fromCallable しないと差異が出てしまう
            if ($ref->isInternal()) {
                $receiver = $bind ?? $class;
                $callee = $receiver ? [$receiver, $ref->getName()] : $ref->getName();
                return "\$this->$vid = \\Closure::fromCallable({$export($callee, $nest)})";
            }

            [$meta, $body] = callable_code($value);
            $arrow = starts_with($meta, 'fn') ? ' => ' : ' ';
            $tokens = array_slice(parse_php("$meta{$arrow}$body;", TOKEN_PARSE), 1, -1);

            $uses = [];
            $context = [
                'class' => 0,
                'brace' => 0,
            ];
            foreach ($tokens as $n => $token) {
                $prev = $neighborToken($n, -1, $tokens) ?? [null, null, null];
                $next = $neighborToken($n, +1, $tokens) ?? [null, null, null];

                // クロージャは何でもかける（クロージャ・無名クラス・ジェネレータ etc）のでネスト（ブレース）レベルを記録しておく
                if ($token[1] === '{') {
                    $context['brace']++;
                }
                if ($token[1] === '}') {
                    $context['brace']--;
                }

                // 無名クラスは色々厄介なので読み飛ばすために覚えておく
                if ($prev[0] === T_NEW && $token[0] === T_CLASS) {
                    $context['class'] = $context['brace'];
                }
                // そして無名クラスは色々かける上に終了条件が自明ではない（シンタックスエラーでない限りは {} が一致するはず）
                if ($token[1] === '}' && $context['class'] === $context['brace']) {
                    $context['class'] = 0;
                }

                // fromCallable 由来だと名前がついてしまう
                if (!$context['class'] && $prev[0] === T_FUNCTION && $token[0] === T_STRING) {
                    unset($tokens[$n]);
                    continue;
                }

                // use 変数の導出
                if ($token[0] === T_VARIABLE) {
                    $varname = substr($token[1], 1);
                    // クロージャ内クロージャの use に反応してしまうので存在するときのみとする
                    if (array_key_exists($varname, $statics) && !isset($uses[$varname])) {
                        $recurself = $statics[$varname] === $value ? '&' : '';
                        $uses[$varname] = "$spacer1\$$varname = $recurself{$export($statics[$varname], $nest + 1)};\n";
                    }
                }

                $tokens[$n] = $resolveSymbol($token, $prev, $next, $ref);
            }

            $code = indent_php(implode('', array_column($tokens, 1)), [
                'indent'   => $spacer1,
                'baseline' => -1,
            ]);
            if ($bind) {
                $scope = $var_export($class === 'Closure' ? 'static' : $class);
                $code = "\Closure::bind($code, {$export($bind, $nest + 1)}, $scope)";
            }
            elseif (!is_bindable_closure($value)) {
                $code = "static $code";
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
                    catch (\Throwable $t) { // @codeCoverageIgnore
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
                return "\$this->$vid = new \\__PHP_Incomplete_Class()";
            }

            // 無名クラスは定義がないのでパースが必要
            // さらにコンストラクタを呼ぶわけには行かない（引数を検出するのは不可能）ので潰す必要もある
            if ($ref->isAnonymous()) {
                $fname = $ref->getFileName();
                $sline = $ref->getStartLine();
                $eline = $ref->getEndLine();
                $tokens = parse_php(implode('', array_slice(file($fname), $sline - 1, $eline - $sline + 1)));

                $block = [];
                $starting = false;
                $constructing = 0;
                $nesting = 0;
                foreach ($tokens as $n => $token) {
                    $prev = $neighborToken($n, -1, $tokens) ?? [null, null, null];
                    $next = $neighborToken($n, +1, $tokens) ?? [null, null, null];

                    // 無名クラスは new class で始まるはず
                    if ($token[0] === T_NEW && $next[0] === T_CLASS) {
                        $starting = true;
                    }
                    if (!$starting) {
                        continue;
                    }

                    // コンストラクタの呼び出し引数はスキップする
                    if ($constructing !== null) {
                        if ($token[1] === '(') {
                            $constructing++;
                        }
                        if ($token[1] === ')') {
                            $constructing--;
                            if ($constructing === 0) {
                                $constructing = null;          // null を終了済みマークとして変数を再利用している
                                $block[] = [null, '()', null]; // for psr-12
                                continue;
                            }
                        }
                        if ($constructing) {
                            continue;
                        }
                    }

                    // 引数ありコンストラクタは呼ばないのでリネームしておく
                    if ($token[1] === '__construct' && $ref->getConstructor() && $ref->getConstructor()->getNumberOfRequiredParameters()) {
                        $token[1] = "replaced__construct";
                    }

                    $block[] = $resolveSymbol($token, $prev, $next, $ref);

                    if ($token[1] === '{') {
                        $nesting++;
                    }
                    if ($token[1] === '}') {
                        $nesting--;
                        if ($nesting === 0) {
                            break;
                        }
                    }
                }

                $code = indent_php(implode('', array_column($block, 1)), [
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
                $fields = array_intersect_key(get_object_properties($value, $privates), array_flip($value->__sleep()));
            }
            // それ以外は適当に漁る
            else {
                $fields = get_object_properties($value, $privates);
            }

            return "\$this->new(\$this->$vid, $classname, (function () {\n{$spacer1}return {$export([$fields, $privates], $nest + 1)};\n{$spacer0}}))";
        }
        if (is_resourcable($value)) {
            // スタンダードなリソースなら復元できないこともない
            $meta = stream_get_meta_data($value);
            if (!in_array(strtolower($meta['stream_type']), ['stdio', 'output'], true)) {
                return 'null'; // for compatible. 例外にしたい
            }
            $meta['position'] = @ftell($value);
            $meta['context'] = stream_context_get_options($value);
            return "\$this->$vid = \$this->open({$export($meta, $nest + 1)})";
        }

        return is_null($value) ? 'null' : $var_export($value);
    };

    $exported = $export($value, 1);
    $others = [];
    $vars = [];
    foreach ($var_manager->orphan() as $rid => [$isref, $vid, $var]) {
        $declare = $isref ? "&\$this->$vid" : $export($var, 1);
        $others[] = "\$this->$rid = $declare;";
    }

    static $factory = null;
    if ($factory === null) {
        // @codeCoverageIgnoreStart
        $factory = $export(new class() {
            public function new(&$object, $class, $provider)
            {
                if ($class instanceof \Closure) {
                    $object = $class();
                    $reflection = $this->reflect(get_class($object));
                }
                else {
                    $reflection = $this->reflect($class);
                    if ($reflection["constructor"] && $reflection["constructor"]->getNumberOfRequiredParameters() === 0) {
                        $object = $reflection["self"]->newInstance();
                    }
                    else {
                        $object = $reflection["self"]->newInstanceWithoutConstructor();
                    }
                }
                [$fields, $privates] = $provider();

                if ($reflection["unserialize"]) {
                    $object->__unserialize($fields);
                    return $object;
                }

                foreach ($reflection["parents"] as $parent) {
                    foreach ($this->reflect($parent->name)["properties"] as $name => $property) {
                        if (isset($privates[$parent->name][$name]) && !$privates[$parent->name][$name] instanceof \__PHP_Incomplete_Class) {
                            $property->setValue($object, $privates[$parent->name][$name]);
                        }
                        if ((isset($fields[$name]) || array_key_exists($name, $fields))) {
                            if (!$fields[$name] instanceof \__PHP_Incomplete_Class) {
                                $property->setValue($object, $fields[$name]);
                            }
                            unset($fields[$name]);
                        }
                    }
                }
                foreach ($fields as $name => $value) {
                    $object->$name = $value;
                }

                if ($reflection["wakeup"]) {
                    $object->__wakeup();
                }

                return $object;
            }

            public function open($metadata)
            {
                $resource = fopen($metadata['uri'], $metadata['mode'], false, stream_context_create($metadata['context']));
                if ($resource === false) {
                    return null;
                }
                if ($metadata['seekable'] && is_int($metadata['position'])) {
                    fseek($resource, $metadata['position']);
                }
                return $resource;
            }

            private function reflect($class)
            {
                static $cache = [];
                if (!isset($cache[$class])) {
                    $refclass = new \ReflectionClass($class);
                    $cache[$class] = [
                        "self"        => $refclass,
                        "constructor" => $refclass->getConstructor(),
                        "parents"     => [],
                        "properties"  => [],
                        "unserialize" => $refclass->hasMethod("__unserialize"),
                        "wakeup"      => $refclass->hasMethod("__wakeup"),
                    ];
                    for ($current = $refclass; $current; $current = $current->getParentClass()) {
                        $cache[$class]["parents"][$current->name] = $current;
                    }
                    foreach ($refclass->getProperties() as $property) {
                        if (!$property->isStatic()) {
                            $property->setAccessible(true);
                            $cache[$class]["properties"][$property->name] = $property;
                        }
                    }
                }
                return $cache[$class];
            }
        }, -1, true);
        // @codeCoverageIgnoreEnd
    }

    $E = fn($v) => $v;
    $result = <<<PHP
        (function () {
            {$E(implode("\n    ", $others))}
            return $exported;
        })->call($factory)
        PHP;

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
