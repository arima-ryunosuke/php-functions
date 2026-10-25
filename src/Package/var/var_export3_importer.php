<?php /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * var_export3 の出力を取り込むクラスを定義する
 *
 * 下記の理由で var_export3 内の無名クラスから分離。
 * 原則として内部向けであり、これを外部から使うことは想定していない。
 *
 * - var_export3 の出力の末尾に毎回くっついてくるのが気持ち悪い
 * - 小さいとは言えどクラス定義が為されるので class 領域の無駄
 * - たまに外部から指定したいケースがある
 *
 * @codeCoverageIgnore
 * @package ryunosuke\Functions\Package\var
 */
function var_export3_importer(?string $class_name = null): bool|object
{
    static $factory = null;
    $factory ??= new #[\AllowDynamicProperties] class() {
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
                    if (array_key_exists($name, $fields)) {
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
            if ($metadata['seekable'] && is_string($metadata['buffer'])) {
                fwrite($resource, $metadata['buffer']);
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
    };

    if ($class_name === null) {
        return $factory;
    }

    if (!class_exists($class_name)) {
        $parts = explode('\\', $class_name);
        $classname = array_pop($parts);
        $namespace = trim(implode('\\', $parts), '\\');

        $ref = new \ReflectionObject($factory);
        $file = file($ref->getFileName());
        $sline = $ref->getStartLine();
        $eline = $ref->getEndLine();
        $body = implode("", array_slice($file, $sline, $eline - $sline - 1));

        $declare = <<<CLASS
        namespace $namespace {
            #[\\AllowDynamicProperties]
            class $classname
            {
        $body
            }
        }
        
        CLASS;
        eval($declare);

        return true;
    }
    return false;
}
