<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../classobj/object_properties.php';
require_once __DIR__ . '/../funchand/is_bindable_closure.php';
require_once __DIR__ . '/../reflection/callable_code.php';
// @codeCoverageIgnoreEnd

/**
 * callable から ReflectionFunctionAbstract を生成する
 *
 * 実際には ReflectionFunctionAbstract を下記の独自拡張した Reflection クラスを返す（メソッドのオーバーライド等はしていないので完全互換）。
 * - __invoke: 元となったオブジェクトを $this として invoke する（関数・クロージャは invoke と同義）
 * - call: 実行 $this を指定して invoke する（クロージャ・メソッドのみ）
 *   - 上記二つは __call/__callStatic のメソッドも呼び出せる
 * - getDeclaration: 宣言部のコードを返す
 * - getCode: 定義部のコードを返す
 * - isAnonymous: 無名関数なら true を返す（8.2 の isAnonymous 互換）
 * - isArrow: アロー演算子で定義されたかを返す（クロージャのみ）
 * - isStatic: $this バインド可能かを返す（クロージャのみ）
 * - getUsedVariables: use している変数配列を返す（クロージャのみ）
 * - getClosure: 元となったオブジェクトを $object としたクロージャを返す（メソッドのみ）
 *   - 上記二つは __call/__callStatic のメソッドも呼び出せる
 * - getTraitMethod: トレイト側のリフレクションを返す（メソッドのみ）
 *
 * Example:
 * ```php
 * that(reflect_callable('sprintf'))->isInstanceOf(\ReflectionFunction::class);
 * that(reflect_callable('\Closure::bind'))->isInstanceOf(\ReflectionMethod::class);
 *
 * $x = 1;
 * $closure = function ($a, $b) use (&$x) { return $a + $b; };
 * $reflection = reflect_callable($closure);
 * // 単純実行
 * that($reflection(1, 2))->is(3);
 * // 無名クラスを $this として実行
 * that($reflection->call(new class(){}, 1, 2))->is(3);
 * // 宣言部を返す
 * that($reflection->getDeclaration())->is('function ($a, $b) use (&$x)');
 * // 定義部を返す
 * that($reflection->getCode())->is('{ return $a + $b; }');
 * // static か返す
 * that($reflection->isStatic())->is(false);
 * // use 変数を返す
 * that($reflection->getUsedVariables())->is(['x' => 1]);
 * ```
 *
 * @package ryunosuke\Functions\Package\reflection
 *
 * @param callable $callable 対象 callable
 * @return \ReflectCallable|\ReflectionFunction|\ReflectionMethod リフレクションインスタンス
 */
function reflect_callable($callable)
{
    // callable チェック兼 $call_name 取得
    if (!is_callable($callable, true, $call_name)) {
        throw new \InvalidArgumentException("'$call_name' is not callable");
    }

    if (is_string($call_name) && strpos($call_name, '::') === false) {
        return new class($callable) extends \ReflectionFunction {
            private $definition;

            public function __invoke(...$args): mixed
            {
                return $this->invoke(...$args);
            }

            public function getDeclaration(): string
            {
                return ($this->definition ??= callable_code($this))[0];
            }

            public function getCode(): string
            {
                return ($this->definition ??= callable_code($this))[1];
            }

            public function isAnonymous(): bool
            {
                return false;
            }
        };
    }
    elseif ($callable instanceof \Closure) {
        return new class($callable) extends \ReflectionFunction {
            private $callable;
            private $definition;

            public function __construct($function)
            {
                parent::__construct($function);

                $this->callable = $function;
            }

            public function __invoke(...$args): mixed
            {
                return $this->invoke(...$args);
            }

            public function call($newThis = null, ...$args): mixed
            {
                return ($this->callable)->call($newThis ?? $this->getClosureThis(), ...$args);
            }

            public function getDeclaration(): string
            {
                return ($this->definition ??= callable_code($this))[0];
            }

            public function getCode(): string
            {
                return ($this->definition ??= callable_code($this))[1];
            }

            public function isAnonymous(): bool
            {
                if (method_exists(\ReflectionFunction::class, 'isAnonymous')) {
                    return parent::isAnonymous(); // @codeCoverageIgnore
                }

                return strpos($this->name, '{closure}') !== false;
            }

            public function isArrow(): bool
            {
                // しっかりやるなら PHPToken を使った方がいいけど今の php 構文ならこれで大丈夫のはず
                return str_starts_with($this->getDeclaration(), 'fn') !== false;
            }

            public function isStatic(): bool
            {
                return !is_bindable_closure($this->callable);
            }

            public function getUsedVariables(): array
            {
                if (method_exists(\ReflectionFunction::class, 'getClosureUsedVariables')) {
                    return parent::getClosureUsedVariables(); // @codeCoverageIgnore
                }

                $uses = object_properties($this->callable);
                unset($uses['this']);
                return $uses;
            }
        };
    }
    else {
        [$class, $method] = explode('::', $call_name, 2);
        // for タイプ 5: 相対指定による静的クラスメソッドのコール (PHP 5.3.0 以降)
        if (strpos($method, 'parent::') === 0) {
            [, $method] = explode('::', $method);
            $class = get_parent_class($class);
        }

        $called_name = '';
        if (!method_exists(is_array($callable) && is_object($callable[0]) ? $callable[0] : $class, $method)) {
            $called_name = $method;
            $method = is_array($callable) && is_object($callable[0]) ? '__call' : '__callStatic';
        }

        return new class($class, $method, $callable, $called_name) extends \ReflectionMethod {
            private $callable;
            private $call_name;
            private $definition;

            public function __construct($class, $method, $callable, $call_name)
            {
                parent::__construct($class, $method);

                $this->setAccessible(true); // 8.1 はデフォルトで true になるので模倣する
                $this->callable = $callable;
                $this->call_name = $call_name;
            }

            public function __invoke(...$args): mixed
            {
                if ($this->call_name) {
                    $args = [$this->call_name, $args];
                }
                return $this->invoke($this->isStatic() ? null : $this->callable[0], ...$args);
            }

            public function call($newThis = null, ...$args): mixed
            {
                if ($this->call_name) {
                    $args = [$this->call_name, $args];
                }
                return $this->getClosure($newThis ?? ($this->isStatic() ? null : $this->callable[0]))(...$args);
            }

            public function getDeclaration(): string
            {
                return ($this->definition ??= callable_code($this))[0];
            }

            public function getCode(): string
            {
                return ($this->definition ??= callable_code($this))[1];
            }

            public function isAnonymous(): bool
            {
                return false;
            }

            public function getClosure(?object $object = null): \Closure
            {
                $name = strtolower($this->name);

                if ($this->isStatic()) {
                    if ($name === '__callstatic') {
                        return \Closure::fromCallable([$this->class, $this->call_name]);
                    }
                    return parent::getClosure();
                }

                $object ??= $this->callable[0];
                if ($name === '__call') {
                    return \Closure::fromCallable([$object, $this->call_name]);
                }
                return parent::getClosure($object);
            }

            public function getTraitMethod(): ?\ReflectionMethod
            {
                $name = strtolower($this->name);
                $class = $this->getDeclaringClass();
                $aliases = array_change_key_case($class->getTraitAliases(), CASE_LOWER);

                if (!isset($aliases[$name])) {
                    if ($this->getFileName() === $class->getFileName()) {
                        return null;
                    }
                    else {
                        return $this;
                    }
                }

                [$tname, $mname] = explode('::', $aliases[$name]);
                $result = new self($tname, $mname, $this->callable, $this->call_name);

                // alias を張ったとしても自身で再宣言はエラーなく可能で、その場合自身が採用されるようだ
                if (false
                    || $this->getFileName() !== $result->getFileName()
                    || $this->getStartLine() !== $result->getStartLine()
                    || $this->getEndLine() !== $result->getEndLine()
                ) {
                    return null;
                }

                return $result;
            }
        };
    }
}
