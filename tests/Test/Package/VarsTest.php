<?php

namespace ryunosuke\Test\Package;

use AbstractConcrete;
use ArrayObject;
use Concrete;
use Exception as Ex;
use Invoker;
use ryunosuke\Functions\Package\Vars;
use SerialMethod;
use SleepWakeupMethod;
use stdClass;
use function gettype as gt;
use const SORT_REGULAR as SR;

class VarsTest extends AbstractTestCase
{
    function test_stringify()
    {
        that((stringify)(null))->is('null');
        that((stringify)(false))->is('false');
        that((stringify)(true))->is('true');
        that((stringify)(123))->is('123');
        that((stringify)(123.456))->is('123.456');
        that((stringify)('hoge'))->is('hoge');
        that((stringify)(STDIN))->is('Resource id #1');
        that((stringify)(['array']))->is('["array"]');
        that((stringify)(new \stdClass()))->is('stdClass');
        that((stringify)(new \Concrete('hoge')))->is('hoge');
        that((stringify)(new \SerialObject(['hoge'])))->is('O:12:"SerialObject":1:{i:0;s:4:"hoge";}');
        that((stringify)(new \JsonObject(['hoge'])))->is('JsonObject:["hoge"]');
    }

    function test_numberize()
    {
        that((numberify)(null))->isSame(0);
        that((numberify)(false))->isSame(0);
        that((numberify)(true))->isSame(1);
        that((numberify)(null, true))->isSame(0.0);
        that((numberify)(false, true))->isSame(0.0);
        that((numberify)(true, true))->isSame(1.0);
        that((numberify)([1, 2, 3]))->isSame(3);
        that((numberify)([1, 2, 3], true))->isSame(3.0);
        that((numberify)(STDIN))->isSame((int) STDIN);
        that((numberify)(new \Concrete('a12s3b')))->isSame(123);

        that((numberify)(123))->isSame(123);
        that((numberify)(12.3))->isSame(12);

        that((numberify)(123, true))->isSame(123.0);
        that((numberify)(12.3, true))->isSame(12.3);

        that((numberify)('aaa123bbb'))->isSame(123);
        that((numberify)('a1b2c3'))->isSame(123);
        that((numberify)('-a1b2c3'))->isSame(-123);

        that((numberify)('aaa12.3bbb'))->isSame(12);
        that((numberify)('a1b2.c3'))->isSame(12);
        that((numberify)('-a1b2c.3'))->isSame(-12);

        that((numberify)('aaa12.3bbb', true))->isSame(12.3);
        that((numberify)('a1b2.c3', true))->isSame(12.3);
        that((numberify)('-a1b2c.3', true))->isSame(-12.3);

        that(numberify)('aaa')->wasThrown('is not numeric');
        that(numberify)('a.a')->wasThrown('is not numeric');
        that(numberify)('1.2.3', true)->wasThrown('is not numeric');
    }

    function test_numval()
    {
        that((numval)(3))->isSame(3);
        that((numval)(3.14))->isSame(3.14);
        that((numval)('3'))->isSame(3);
        that((numval)('3.14'))->isSame(3.14);
        that((numval)('3.'))->isSame(3.0);
        that((numval)('.3'))->isSame(0.3);
        that((numval)(new \Concrete('3.14')))->isSame(3.14);
        that((numval)([]))->isSame(0);
        that((numval)([1, 2]))->isSame(1);

        that((numval)(30, 8))->isSame(30);
        that((numval)(30.0, 8))->isSame(30.0);
        that((numval)("30", 8))->isSame(24);
        that((numval)("30", 16))->isSame(48);
    }

    function test_flagval()
    {
        that((flagval)(true))->isTrue();
        that((flagval)(false))->isFalse();

        that((flagval)(1))->isTrue();
        that((flagval)(0))->isFalse();
        that((flagval)(-0))->isFalse();
        that((flagval)(0.0))->isFalse();
        that((flagval)(-0.0))->isFalse();

        that((flagval)(NAN))->isTrue();
        that((flagval)(INF))->isTrue();

        that((flagval)([0]))->isTrue();
        that((flagval)([]))->isFalse();

        that((flagval)((object) []))->isTrue();
        that((flagval)(new \ArrayObject([])))->isTrue();

        that((flagval)(''))->isFalse();
        that((flagval)("\t \n"))->isTrue();
        that((flagval)("\t \n", true))->isFalse();
        that((flagval)(' false '))->isTrue();
        that((flagval)(' false ', true))->isFalse();

        that((flagval)('1'))->isTrue();
        that((flagval)('0.0'))->isTrue();
        that((flagval)("0"))->isFalse();

        that((flagval)('true'))->isTrue();
        that((flagval)('tRUE'))->isTrue();
        that((flagval)('false'))->isFalse();
        that((flagval)('fALSE'))->isFalse();

        that((flagval)('on'))->isTrue();
        that((flagval)('oN'))->isTrue();
        that((flagval)('off'))->isFalse();
        that((flagval)('oFF'))->isFalse();

        that((flagval)('yes'))->isTrue();
        that((flagval)('yES'))->isTrue();
        that((flagval)('no'))->isFalse();
        that((flagval)('nO'))->isFalse();

        that((flagval)('hoge'))->isTrue();
        that((flagval)('null'))->isTrue();
        that((flagval)('nil'))->isTrue();
    }

    function test_arrayval()
    {
        that((arrayval)('str'))->is(['str']);
        that((arrayval)(['array']))->is(['array']);
        that(array_map((arrayval), [1, 'str', ['array']]))->is([
            [1],
            ['str'],
            ['array'],
        ]);

        $ao = new \ArrayObject([1, 2, 3]);
        that((arrayval)([
            'k'  => 'v',
            'ao' => $ao,
        ]))->isSame([
            'k'  => 'v',
            'ao' => [1, 2, 3],
        ]);
        that((arrayval)([
            'k'  => 'v',
            'ao' => $ao,
        ], false))->isSame([
            'k'  => 'v',
            'ao' => $ao,
        ]);

        $inner = (stdclass)([
            'inner-scalar2',
            (stdclass)([
                'lastleaf',
            ]),
        ]);
        $stdclass = (stdclass)([
            'key'   => 'inner-scalar1',
            'inner' => $inner,
        ]);

        that((arrayval)($stdclass, true))->isSame([
            'key'   => 'inner-scalar1',
            'inner' => [
                'inner-scalar2',
                [
                    'lastleaf',
                ],
            ],
        ]);

        that((arrayval)($stdclass, false))->isSame([
            'key'   => 'inner-scalar1',
            'inner' => $inner,
        ]);
    }

    function test_phpval()
    {
        that((phpval)("null"))->isSame(null);
        that((phpval)("true"))->isSame(true);
        that((phpval)("FALSE"))->isSame(false);
        that((phpval)("PHP_INT_SIZE"))->isSame(PHP_INT_SIZE);
        that((phpval)("\\PHP_INT_SIZE"))->isSame(PHP_INT_SIZE);
        that((phpval)("ArrayObject::ARRAY_AS_PROPS"))->isSame(ArrayObject::ARRAY_AS_PROPS);
        that((phpval)("ArrayObject::class"))->isSame(ArrayObject::class);

        that((phpval)("-1"))->isSame(-1);
        that((phpval)("+1"))->isSame(+1);
        that((phpval)("0.0"))->isSame(0.0);
        that((phpval)("-1.23"))->isSame(-1.23);

        that((phpval)("hoge"))->isSame("hoge");
        that((phpval)("bare string"))->isSame("bare string");
        that((phpval)("return"))->isSame("return");
        that((phpval)("strtoupper('a')"))->isSame("A");

        that((phpval)("strtoupper(\$a)", ['a' => 'a']))->isSame("A");
        that((phpval)("\$a + \$b", ['a' => 1, 'b' => 2]))->isSame(3);

        that((phpval)($object = new \stdClass()))->isSame($object);
        that((phpval)("strtoupper(\$undefined)"))->isSame("");
    }

    function test_arrayable_key_exists()
    {
        $array = [
            'ok'    => 'OK',
            'null'  => null,
            'false' => false,
        ];
        that((arrayable_key_exists)('ok', $array))->isTrue();
        that((arrayable_key_exists)('null', $array))->isTrue();
        that((arrayable_key_exists)('false', $array))->isTrue();
        that((arrayable_key_exists)('notfound', $array))->isFalse();

        $object = new class implements \ArrayAccess {
            private $holder = [
                'ok'    => 'OK',
                'null'  => null,
                'false' => false,
            ];

            public function offsetExists($offset): bool
            {
                return isset($this->holder[$offset]);
            }

            /** @noinspection PhpLanguageLevelInspection */
            #[\ReturnTypeWillChange]
            public function offsetGet($offset)
            {
                if ($offset === 'ex') {
                    throw new \OutOfBoundsException();
                }
                return $this->holder[$offset];
            }

            public function offsetSet($offset, $value): void { }

            public function offsetUnset($offset): void { }
        };
        that((arrayable_key_exists)('ok', $object))->isTrue();
        that((arrayable_key_exists)('null', $object))->isTrue();
        that((arrayable_key_exists)('false', $object))->isTrue();
        that((arrayable_key_exists)('notfound', $object))->isFalse();
        that((arrayable_key_exists)('ex', $object))->isFalse();

        that(arrayable_key_exists)(null, new \stdClass())->wasThrown('must be array or ArrayAccess');
    }

    function test_attr_get()
    {
        $array = [
            'ok'    => 'OK',
            'null'  => null,
            'false' => false,
        ];
        that((attr_get)('ok', $array))->isSame('OK');
        that((attr_get)('null', $array))->isSame(null);
        that((attr_get)('false', $array))->isSame(false);
        that((attr_get)('notfound', $array, 'default'))->isSame('default');

        $object = (object) $array;
        that((attr_get)('ok', $object))->isSame('OK');
        that((attr_get)('null', $object))->isSame(null);
        that((attr_get)('false', $object))->isSame(false);
        that((attr_get)('notfound', $object, 'default'))->isSame('default');

        $object = new class implements \ArrayAccess {
            private $holder = [
                'ok'    => 'OK',
                'null'  => null,
                'false' => false,
            ];

            public function offsetExists($offset): bool
            {
                return isset($this->holder[$offset]);
            }

            /** @noinspection PhpLanguageLevelInspection */
            #[\ReturnTypeWillChange]
            public function offsetGet($offset)
            {
                if ($offset === 'ex') {
                    throw new \OutOfBoundsException();
                }
                return $this->holder[$offset];
            }

            public function offsetSet($offset, $value): void { }

            public function offsetUnset($offset): void { }
        };
        that((attr_get)('ok', $object))->isSame('OK');
        that((attr_get)('null', $object))->isSame(null);
        that((attr_get)('false', $object))->isSame(false);
        that((attr_get)('notfound', $object, 'default'))->isSame('default');
        that((attr_get)('ex', $object, 'default'))->isSame('default');

        $object = new class {
            private $holder = [
                'ok'    => 'OK',
                'null'  => null,
                'false' => false,
            ];

            public function __get($offset)
            {
                if ($offset === 'ex') {
                    throw new \OutOfBoundsException();
                }
                return $this->holder[$offset];
            }
        };
        that((attr_get)('ok', $object))->isSame('OK');
        that((attr_get)('null', $object))->isSame(null);
        that((attr_get)('false', $object))->isSame(false);
        that((attr_get)('notfound', $object, 'default'))->isSame('default');
        that((attr_get)('ex', $object, 'default'))->isSame('default');

        $closure = function () { };
        that((attr_get)('ok', $closure))->isSame(null);
        that((attr_get)('ok', $closure, 'default'))->isSame('default');

        that(attr_get)(null, 'dummy')->wasThrown('must be array or object');
    }

    function test_si_prefix()
    {
        foreach (Vars::SI_UNITS as $exp => $units) {
            $unit = $units[0] ?? ' ';
            that((si_prefix)(+pow(1000, $exp)))
                ->stringContains('1.000')
                ->stringEndsWith($unit);

            that((si_prefix)(-pow(1000, $exp)))
                ->stringContains('-1.000')
                ->stringEndsWith($unit);

            that((si_prefix)(+pow(2, $exp * 10), 1024))
                ->stringContains('1.000')
                ->stringEndsWith($unit);

            that((si_prefix)(-pow(2, $exp * 10), 1024))
                ->stringContains('-1.000')
                ->stringEndsWith($unit);
        }

        that((si_prefix)("0.0"))->is('0.000 ');
        that((si_prefix)("0"))->is('0.000 ');
        that((si_prefix)(0))->is('0.000 ');
        that((si_prefix)(0.0))->is('0.000 ');
        that((si_prefix)(999))->is('999.000 ');
        that((si_prefix)(1000))->is('1.000 k');
        that((si_prefix)(1001))->is('1.001 k');
        that((si_prefix)(1023, 1024))->is('1023.000 ');
        that((si_prefix)(1024, 1024))->is('1.000 k');
        that((si_prefix)(1025, 1024))->is('1.001 k');
        that((si_prefix)(0, 1000, null))->is([0, '']);
        that((si_prefix)(12345, 1000, null))->is([12.345, 'k']);
        that((si_prefix)(12345, 1000, fn($v, $u) => number_format($v, 2) . $u))->is('12.35k');

        that(si_prefix)(pow(10, 30))->wasThrown('too large or small');
    }

    function test_si_unprefix()
    {
        foreach (Vars::SI_UNITS as $exp => $units) {
            foreach ($units as $unit) {
                that((si_unprefix)("1$unit"))->is(+pow(1000, $exp));
                that((si_unprefix)("-1$unit"))->is(-pow(1000, $exp));

                that((si_unprefix)("1$unit", 1024))->is(+pow(2, $exp * 10));
                that((si_unprefix)("-1$unit", 1024))->is(-pow(2, $exp * 10));
            }
        }

        that((si_unprefix)("0.0"))->is(0);
        that((si_unprefix)("0"))->is(0);
        that((si_unprefix)(0))->is(0);
        that((si_unprefix)(0.0))->is(0);
        that((si_unprefix)('999'))->is(999);
        that((si_unprefix)('1k'))->is(1000);
        that((si_unprefix)('1023', 1024))->is(1023);
        that((si_unprefix)('1k', 1024))->is(1024);
        that((si_unprefix)('1K', 1024))->is(1024);
    }

    function test_is_empty()
    {
        $stdclass = new \stdClass();
        $arrayo1 = new \ArrayObject([1]);
        $arrayo2 = new \ArrayObject([]);
        // この辺は empty と全く同じ（true）
        that((is_empty)(null))->isSame(empty(null));
        that((is_empty)(false))->isSame(empty(false));
        that((is_empty)(0))->isSame(empty(0));
        that((is_empty)(0.0))->isSame(empty(0.0));
        that((is_empty)(''))->isSame(empty(''));
        that((is_empty)([]))->isSame(empty([]));
        // この辺は empty と全く同じ（false）
        that((is_empty)($stdclass))->isSame(empty($stdclass));
        that((is_empty)($arrayo1))->isSame(empty($arrayo1));
        that((is_empty)(true))->isSame(empty(true));
        that((is_empty)(1))->isSame(empty(1));
        that((is_empty)(1.0))->isSame(empty(1.0));
        that((is_empty)('0.0'))->isSame(empty('0.0'));
        that((is_empty)('00'))->isSame(empty('00'));
        that((is_empty)([1]))->isSame(empty([1]));
        // この辺は差異がある
        that((is_empty)('0'))->isNotSame(empty('0'));
        that((is_empty)($arrayo2))->isNotSame(empty($arrayo2));

        /// stdClass だけは引数で分岐できる
        $stdclass = new \stdClass();
        $stdClassEx = new class extends stdClass { };

        // 空 stdClass は空
        that((is_empty)($stdclass, true))->isTrue();
        // 空でなければ空ではない
        $stdclass->hoge = 123;
        that((is_empty)($stdclass, true))->isFalse();
        // 継承していれば空でも空ではない
        that((is_empty)($stdClassEx, true))->isFalse();
        // 自明だが継承して空でなければ空ではない
        $stdClassEx->hoge = 123;
        that((is_empty)($stdClassEx, true))->isFalse();
    }

    function test_is_primitive()
    {
        that((is_primitive)(null))->isTrue();
        that((is_primitive)(false))->isTrue();
        that((is_primitive)(true))->isTrue();
        that((is_primitive)(123))->isTrue();
        that((is_primitive)(123.456))->isTrue();
        that((is_primitive)('hoge'))->isTrue();
        that((is_primitive)(STDIN))->isTrue();

        that((is_primitive)(['array']))->isFalse();
        that((is_primitive)(new \stdClass()))->isFalse();
    }

    function test_is_recursive()
    {
        that((is_recursive)(null))->isFalse();
        that((is_recursive)(false))->isFalse();
        that((is_recursive)(true))->isFalse();
        that((is_recursive)(123))->isFalse();
        that((is_recursive)(123.456))->isFalse();
        that((is_recursive)('hoge'))->isFalse();
        that((is_recursive)(STDIN))->isFalse();
        that((is_recursive)(['hoge']))->isFalse();
        that((is_recursive)((object) ['hoge' => 'hoge']))->isFalse();

        $rarray = [];
        $rarray = ['rec' => &$rarray];
        that((is_recursive)($rarray))->isTrue();

        $rnestarray = [];
        $rnestarray = [
            'parent' => [
                'child' => [
                    'grand' => &$rnestarray,
                ],
            ],
        ];
        that((is_recursive)($rnestarray))->isTrue();

        $robject = new \stdClass();
        $robject->rec = $robject;
        that((is_recursive)($robject))->isTrue();

        $rnestobject = new \stdClass();
        $rnestobject->parent = new \stdClass();
        $rnestobject->parent->child = new \stdClass();
        $rnestobject->parent->child->grand = $rnestobject;
        that((is_recursive)($rnestobject))->isTrue();
    }

    function test_is_stringable()
    {
        that((is_stringable)(null))->isTrue();
        that((is_stringable)(false))->isTrue();
        that((is_stringable)(true))->isTrue();
        that((is_stringable)(123))->isTrue();
        that((is_stringable)(123.456))->isTrue();
        that((is_stringable)('hoge'))->isTrue();
        that((is_stringable)(STDIN))->isTrue();
        that((is_stringable)(['array']))->isFalse();
        that((is_stringable)(new \stdClass()))->isFalse();
        that((is_stringable)(new \Concrete('hoge')))->isTrue();
    }

    function test_is_arrayable()
    {
        that((is_arrayable)([]))->isTrue();
        that((is_arrayable)(new \ArrayObject()))->isTrue();

        that((is_arrayable)(1))->isFalse();
        that((is_arrayable)(new \stdClass()))->isFalse();
    }

    function test_encrypt_decrypt()
    {
        $data = [
            'user_id' => 12345,
            'time'    => '20141224T123456',
            'data'    => [
                'a' => 'あああ',
                'c' => 'ううう',
            ],
        ];

        $encrypted = (encrypt)($data, 'secret', 'aes-128-ecb');                 // IV なし, TAG なし
        that((decrypt)($encrypted, 'secret'))->isSame($data);                   // password が同じなら復号できる
        that((decrypt)($encrypted, 'invalid'))->isNull();                       // password が異なれば複合できない
        that((decrypt)('this is invalid', 'secret'))->isNull();                 // data が不正なら複合できない
        that((encrypt)($data, 'secret', 'aes-128-ecb'))->isSame($encrypted);    // ecb なので同じ暗号文が生成される

        $encrypted = (encrypt)($data, 'secret', 'aes-256-cbc');                 // IV あり, TAG なし
        that((decrypt)($encrypted, 'secret'))->isSame($data);                   // password が同じなら復号できる
        that((decrypt)($encrypted, 'invalid'))->isNull();                       // password が異なれば複合できない
        that((decrypt)('this is invalid', 'secret'))->isNull();                 // data が不正なら複合できない
        that((encrypt)($data, 'secret', 'aes-256-cbc'))->isNotSame($encrypted); // cbc なので異なる暗号文が生成される

        $encrypted = (encrypt)($data, 'secret', 'aes-256-ccm');                 // IV あり, TAG あり
        that((decrypt)($encrypted, 'secret'))->isSame($data);                   // password が同じなら復号できる
        that((decrypt)($encrypted, 'invalid'))->isNull();                       // password が異なれば複合できない
        that((decrypt)('this is invalid=2', 'secret'))->isNull();               // data が不正なら複合できない
        that((encrypt)($data, 'secret', 'aes-256-ccm'))->isNotSame($encrypted); // ccm なので異なる暗号文が生成される

        that(encrypt)('dummy', 'pass', 'unknown')->wasThrown('undefined cipher algorithm');
    }

    function test_encrypt_decrypt_invalid()
    {
        that((decrypt)('', 'secret', 'aes-128-ecb'))->isNull();
        that((decrypt)('=0', 'secret', 'aes-128-ecb'))->isNull();
        that((decrypt)('=1', 'secret', 'aes-128-ecb'))->isNull();
        that((decrypt)('v=1', 'secret', 'aes-128-ecb'))->isNull();
        that((decrypt)('xxxxxxxxxxxxxxxxxxxx', 'secret', 'aes-128-ecb'))->isNull();
        that((decrypt)(base64_encode('xxxxxxxxxxxxxxxxxxxx') . '=1', 'secret', 'aes-128-ecb'))->isNull();
    }

    function test_encrypt_decrypt_regression()
    {
        $data = [
            'user_id' => 12345,
            'time'    => '20141224T123456',
            'data'    => [
                'a' => 'あああ',
                'c' => 'ううう',
            ],
        ];

        $v0 = "yl84hlOoK5fNFIVFyy2IQmCkqq7FEugiqf4VBW9gHLJVHmfFBR5sLulAYKloAAUYKEWNcDt-yPaQ_1_w0uJeYetvgPJUAA7175-VbXi5UaN2MSJAZN3IAhxVhyF7kc-s";
        that((decrypt)($v0, 'secret', 'aes-128-ecb'))->isSame($data);

        $v0 = "yl84hlOoK5fNFIVFyy2IQmCkqq7FEugiqf4VBW9gHLJVHmfFBR5sLulAYKloAAUYKEWNcDt-yPaQ_1_w0uJeYetvgPJUAA7175-VbXi5UaN2MSJAZN3IAhxVhyF7kc-s=0";
        that((decrypt)($v0, 'secret', 'aes-128-ecb'))->isSame($data);

        $v0 = "yl84hlOoK5fNFIVFyy2IQmCkqq7FEugiqf4VBW9gHLJVHmfFBR5sLulAYKloAAUYKEWNcDt-yPaQ_1_w0uJeYetvgPJUAA7175-VbXi5UaN2MSJAZN3IAhxVhyF7kc-s=99";
        that((decrypt)($v0, 'secret', 'aes-128-ecb'))->isSame($data);

        $v1 = "uuz9p1tBXG3jFKV_y2PN_23s549iyppC5TsUeC4uOe5vdDNkot8DjuXL9kWzmDUlmPH4k0VP05nlHazteEQndsClvXVt_LztaTFno0Y0tg8=1";
        that((decrypt)($v1, 'secret', 'aes-128-ecb'))->isSame($data);
    }

    function test_var_hash()
    {
        that((var_hash)([1, 2, 3], ['md5'], false))->isSame('262bbc0aa0dc62a93e350f1f7df792b9');
        that((var_hash)([1, 2, 3], ['sha1'], false))->isSame('899a999da95e9f021fc63c6af006933fd4dc3aa1');
        that((var_hash)([1, 2, 3], ['md5', 'sha1'], false))->isSame('262bbc0aa0dc62a93e350f1f7df792b9899a999da95e9f021fc63c6af006933fd4dc3aa1');
        that((var_hash)([1, 2, 3], ['md5', 'sha1'], true))->isSame('Jiu8CqDcYqk-NQ8fffeSuYmamZ2pXp8CH8Y8avAGkz_U3Dqh');
        that((var_hash)([1, 2, 3], ['md5', 'sha1'], null))->stringLengthEquals(36);
    }

    function test_varcmp()
    {
        // strict
        that((varcmp)(['b' => 'B', 'a' => 'A'], ['a' => 'A', 'b' => 'B'], \ryunosuke\Functions\Package\Vars::SORT_STRICT))->lessThan(0); // 推移律が成り立ってない
        that((varcmp)(['a' => 'A', 'b' => 'B'], ['b' => 'B', 'a' => 'A'], \ryunosuke\Functions\Package\Vars::SORT_STRICT))->lessThan(0);
        that((varcmp)(['a' => 'A', 'b' => 'B'], ['a' => 'A', 'b' => 'B'], \ryunosuke\Functions\Package\Vars::SORT_STRICT))->is(0);

        // regular int
        that((varcmp)(1, 0))->greaterThan(0);
        that((varcmp)(0, 1))->lessThan(0);
        that((varcmp)(0, 0))->is(0);
        that((varcmp)(1, 1))->is(0);

        // regular float
        that((varcmp)(1.1, 1))->greaterThan(0);
        that((varcmp)(1, 1.1))->lessThan(0);
        that((varcmp)(1.1, 1.1))->is(0);
        that((varcmp)(0.1 + 0.2, 0.3, SORT_NUMERIC, 11))->isSame(0);

        // regular string
        that((varcmp)('1.1', '1'))->greaterThan(0);
        that((varcmp)('1', '1.1'))->lessThan(0);
        that((varcmp)('1.1', '1.1'))->is(0);

        // string int
        that((varcmp)('1', '0', SORT_NUMERIC))->greaterThan(0);
        that((varcmp)('0', '1', SORT_NUMERIC))->lessThan(0);
        that((varcmp)('0', '0', SORT_NUMERIC))->is(0);
        that((varcmp)('1', '1', SORT_NUMERIC))->is(0);

        // string int(reverse)
        that((varcmp)('1', '0', -SORT_NUMERIC))->lessThan(0);
        that((varcmp)('0', '1', -SORT_NUMERIC))->greaterThan(0);
        that((varcmp)('0', '0', -SORT_NUMERIC))->is(0);
        that((varcmp)('1', '1', -SORT_NUMERIC))->is(0);

        // string float
        that((varcmp)('1.1', '1', SORT_NUMERIC))->greaterThan(0);
        that((varcmp)('1', '1.1', SORT_NUMERIC))->lessThan(0);
        that((varcmp)('1.1', '1.1', SORT_NUMERIC))->is(0);

        // string
        that((varcmp)('a', 'A', SORT_STRING))->greaterThan(0);
        that((varcmp)('A', 'a', SORT_STRING))->lessThan(0);
        that((varcmp)('abc', 'abc', SORT_STRING))->is(0);

        // string(icase)
        that((varcmp)('A2', 'a1', SORT_STRING | SORT_FLAG_CASE))->greaterThan(0);
        that((varcmp)('a1', 'A2', SORT_STRING | SORT_FLAG_CASE))->lessThan(0);
        that((varcmp)('ABC', 'abc', SORT_STRING | SORT_FLAG_CASE))->is(0);

        // string natural
        that((varcmp)('12', '2', SORT_NATURAL))->greaterThan(0);
        that((varcmp)('2', '12', SORT_NATURAL))->lessThan(0);
        that((varcmp)('0', '0', SORT_NATURAL))->is(0);

        // string natural(icase)
        that((varcmp)('a12', 'A2', SORT_NATURAL | SORT_FLAG_CASE))->greaterThan(0);
        that((varcmp)('A2', 'a12', SORT_NATURAL | SORT_FLAG_CASE))->lessThan(0);
        that((varcmp)('ABC', 'abc', SORT_NATURAL | SORT_FLAG_CASE))->is(0);

        // string(SORT_FLAG_CASE only)
        that((varcmp)('A2', 'a1', SORT_FLAG_CASE))->greaterThan(0);
        that((varcmp)('a1', 'A2', SORT_FLAG_CASE))->lessThan(0);
        that((varcmp)('ABC', 'abc', SORT_FLAG_CASE))->is(0);

        // string(transitive)
        $a = '1f1';
        $b = '1E1';
        $c = '9';
        that((varcmp)($a, $b, SORT_FLAG_CASE))->greaterThan(0);
        that((varcmp)($c, $a, SORT_FLAG_CASE))->greaterThan(0);
        that((varcmp)($c, $b, SORT_FLAG_CASE))->greaterThan(0);

        // array
        $a = [1, 2, 3, 9];
        $b = [1, 2, 3, 0];
        $x = [1, 2, 3, 9];
        that((varcmp)($a, $b))->greaterThan(0);
        that((varcmp)($b, $a))->lessThan(0);
        that((varcmp)($a, $x))->is(0);

        // object
        $a = (stdclass)(['a' => 1, 'b' => 2, 'c' => 3, 'x' => 9]);
        $b = (stdclass)(['a' => 1, 'b' => 2, 'c' => 3, 'x' => 0]);
        $x = (stdclass)(['a' => 1, 'b' => 2, 'c' => 3, 'x' => 9]);
        that((varcmp)($a, $b))->greaterThan(0);
        that((varcmp)($b, $a))->lessThan(0);
        that((varcmp)($a, $x))->is(0);

        // DateTime
        $a = new \DateTime('2011/12/23 12:34:56');
        $b = new \DateTime('2010/12/23 12:34:56');
        $x = new \DateTime('2011/12/23 12:34:56');
        that((varcmp)($a, $b))->greaterThan(0);
        that((varcmp)($b, $a))->lessThan(0);
        that((varcmp)($a, $x))->is(0);
    }

    function test_var_type()
    {
        that((var_type)(null))->is('NULL');
        that((var_type)(false))->is('boolean');
        that((var_type)(true))->is('boolean');
        that((var_type)(123))->is('integer');
        that((var_type)(123.456))->is('double');
        that((var_type)('hoge'))->is('string');
        that((var_type)(STDIN))->is('resource');
        that((var_type)(['array']))->is('array');
        that((var_type)(new \stdClass()))->is('\\' . \stdClass::class);
        that((var_type)(new \Concrete('hoge')))->is('\\' . \Concrete::class);

        that((var_type)(new class extends \stdClass implements \JsonSerializable {
            public function jsonSerialize(): string { return ''; }
        }))->is('\stdClass');
        that((var_type)(new class implements \JsonSerializable {
            public function jsonSerialize(): string { return ''; }
        }))->is('\JsonSerializable');
        that((var_type)(new class extends \stdClass { }))->is('\stdClass');
        that((var_type)(new class { }))->stringContains('anonymous');
    }

    function test_var_type_valid()
    {
        that((var_type)(null, true))->is('null');
        that((var_type)(true, true))->is('bool');
        that((var_type)(123, true))->is('int');
        that((var_type)(123.456, true))->is('float');
        that((var_type)('hoge', true))->is('string');
        that((var_type)(STDIN, true))->is('resource');
        that((var_type)(['array'], true))->is('array');
    }

    function test_var_apply()
    {
        // 単値であればそのまま適用される
        that((var_apply)('123', numval))->isSame(123);
        that((var_apply)('123', numval, 8))->isSame(83);
        // 配列なら中身に適用される
        that((var_apply)(['123', '456'], numval))->isSame([123, 456]);
        that((var_apply)(['123', '456'], numval, 8))->isSame([83, 302]);
        // 再帰で処理される
        that((var_apply)(['123', '456', 'a' => ['789']], numval))->isSame([123, 456, 'a' => [789]]);
        // よくあるやつ
        that((var_apply)(['<x>', ['<y>']], 'htmlspecialchars', ENT_QUOTES, 'utf-8'))->isSame(['&lt;x&gt;', ['&lt;y&gt;']]);
    }

    function test_var_applys()
    {
        $upper = fn($array) => array_map('strtoupper', $array);
        that((var_applys)('a', $upper))->isSame('A');
        that((var_applys)(['a', 'b'], $upper))->isSame(['A', 'B']);
    }

    function test_var_stream()
    {
        $var = null;
        $f = (var_stream)($var);

        // f 系の一連の流れ
        that(flock($f, LOCK_EX))->is(true);
        that(fwrite($f, 'Hello'))->is(5);
        that(fwrite($f, 'World!'))->is(6);
        that(fseek($f, 3, SEEK_SET))->is(0);
        that(ftell($f))->is(3);
        that(feof($f))->is(false);
        that(fread($f, 3))->is('loW');
        that(fread($f, 1024))->is('orld!');
        that(fseek($f, 100, SEEK_SET))->is(0);
        that(fwrite($f, 'x'))->is(1);
        that(fflush($f))->is(true);
        that(ftruncate($f, 16))->is(true);
        that(flock($f, LOCK_UN))->is(true);
        that(stream_get_contents($f, -1, 0))->is("HelloWorld!\0\0\0\0\0");
        that(fclose($f))->is(true);

        that($var)->is("HelloWorld!\0\0\0\0\0");

        $f = (var_stream)($var, 'init');
        that(stream_get_contents($f, -1, 0))->is("init");

        that($var)->is("init");
    }

    function test_var_stream_io()
    {
        $var = "initial\nstring";
        $f = (var_stream)($var);
        that(fread($f, 3))->is("ini");
        that(fgets($f))->is("tial\n");
        that(fgets($f))->is("string");
        that(fgets($f))->isFalse();
        $var .= "append\nstring";
        that(fgets($f))->is("append\n");
        that(fgets($f))->is("string");
        that(fgets($f))->isFalse();
        that(fwrite($f, 'final'))->is(5);
        that($var)->is("initial\nstringappend\nstringfinal");
    }

    function test_var_stream_seek()
    {
        $test = function ($expected, $actual) {
            that(fwrite($expected, '0123456789') === fwrite($actual, '0123456789'))->isTrue();

            that(fseek($expected, 1, SEEK_SET) === fseek($actual, 1, SEEK_SET))->isTrue();
            that(fseek($expected, -1, SEEK_SET) === fseek($actual, -1, SEEK_SET))->isTrue();
            that(ftell($expected) === ftell($actual))->isTrue();

            that(fseek($expected, 1, SEEK_CUR) === fseek($actual, 1, SEEK_CUR))->isTrue();
            that(fseek($expected, -1, SEEK_CUR) === fseek($actual, -1, SEEK_CUR))->isTrue();
            that(fseek($expected, -111, SEEK_CUR) === fseek($actual, -111, SEEK_CUR))->isTrue();
            that(ftell($expected) === ftell($actual))->isTrue();

            that(fseek($expected, 1, SEEK_END) === fseek($actual, 1, SEEK_END))->isTrue();
            that(fseek($expected, -1, SEEK_END) === fseek($actual, -1, SEEK_END))->isTrue();
            that(fseek($expected, -111, SEEK_END) === fseek($actual, -111, SEEK_END))->isTrue();
            that(ftell($expected) === ftell($actual))->isTrue();

            that(fseek($expected, 100, SEEK_SET) === fseek($actual, 100, SEEK_SET))->isTrue();
            that(fwrite($expected, 'x') === fwrite($actual, 'x'))->isTrue();
            that(rewind($expected) === rewind($actual))->isTrue();
            that(fread($expected, 1000) === fread($actual, 1000))->isTrue();
        };
        $var = null;
        $test(tmpfile(), (var_stream)($var));
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function test_var_stream_already()
    {
        stream_wrapper_register('VarStreamV010000', 'stdClass');
        that(function () {
            $var = null;
            (var_stream)($var);
        })()->wasThrown('is registered already');
    }

    function test_var_export2()
    {
        $value = [
            'array'       => [1, 2, 3,],
            'hash'        => [
                'a' => 'A',
                'b' => 'B',
            ],
            'empty'       => [],
            'emptyempty'  => [[]],
            'emptyempty1' => [[[1]]],
            'nest'        => [
                'hash'  => [
                    'a'    => 'A',
                    'b'    => 'B',
                    'hash' => [
                        'x' => 'X',
                    ],
                ],
                'array' => [
                    [1, 2, 3, ['X']],
                ],
            ],
            'null'        => null,
            'int'         => 123,
            'string'      => 'ABC',
            'object'      => new \Concrete('hoge'),
        ];
        $a1 = var_export($value, true);
        $a2 = (var_export2)($value, true);
        that((phpval)($a2))->is((phpval)($a1));

        that((var_export2)([
            "'\0\""  => 123,
            '$var'   => '$var',
            '${var}' => '${var}',
            '{$var}' => '{$var}',
            "\n"     => "\n",
            "\\"     => "\\",
            '"'      => '"',
            'key'    => 456,
            'null'   => null,
            'nulls'  => [null],
        ], true))->isSame(<<<'EXPECTED'
        [
            "'\000\"" => 123,
            "\$var"   => "\$var",
            "\${var}" => "\${var}",
            "{\$var}" => "{\$var}",
            "
        "       => "
        ",
            "\\"      => "\\",
            "\""      => "\"",
            "key"     => 456,
            "null"    => null,
            "nulls"   => [null],
        ]
        EXPECTED
        );

        that(var_export2)->fn('hoge')->outputMatches('#hoge#');
    }

    function test_var_export2_private()
    {
        $concrete = new \Concrete('hoge');

        that((var_export2)($concrete, true))->is(<<<'VAR'
        Concrete::__set_state([
            "value"           => null,
            "proptectedField" => 3.14,
            "privateField"    => "Concrete",
            "name"            => "hoge",
        ])
        VAR
        );

        $concrete->external = 'aaa';
        that((var_export2)($concrete, true))->is(<<<'VAR'
        Concrete::__set_state([
            "value"           => null,
            "external"        => "aaa",
            "proptectedField" => 3.14,
            "privateField"    => "Concrete",
            "name"            => "hoge",
        ])
        VAR
        );
    }

    function test_var_export2_recursive()
    {
        $rarray = [];
        $rarray['parent']['child']['grand'] = &$rarray;
        that((var_export2)($rarray, true))->is(<<<'VAR'
        [
            "parent" => [
                "child" => [
                    "grand" => "*RECURSION*",
                ],
            ],
        ]
        VAR
        );

        $robject = new \stdClass();
        $robject->parent = new \stdClass();
        $robject->parent->child = new \stdClass();
        $robject->parent->child->grand = $robject;
        that((var_export2)($robject, true))->is(<<<'VAR'
        (object) [
            "parent" => (object) [
                "child" => (object) [
                    "grand" => "*RECURSION*",
                ],
            ],
        ]
        VAR
        );
    }

    function test_var_export3()
    {
        $values = [
            'array'       => [1, 2, 3,],
            'hash'        => [
                'a' => 'A',
                'b' => 'B',
            ],
            'empty'       => [],
            'emptyempty'  => [[]],
            'emptyempty1' => [[[1]]],
            'nest'        => [
                'hash'  => [
                    'a'    => 'A',
                    'b'    => 'B',
                    'hash' => [
                        'x' => 'X',
                    ],
                ],
                'array' => [
                    [1, 2, 3, ['X']],
                ],
            ],
            'null'        => null,
            'int'         => 123,
            'string'      => 'ABC',
            'object'      => new \DateTime(),
        ];
        $exported = (var_export3)($values, ['outmode' => 'eval']);
        that(serialize(eval($exported)))->isSame(serialize($values));
    }

    function test_var_export3_array()
    {
        $values = [
            'hash'  => [
                'a' => 'A',
                'b' => 'B',
            ],
            'recur' => &$values,
        ];
        $exported = (var_export3)($values, ['outmode' => 'eval']);
        $values2 = eval($exported);
        $values2['recur']['recur']['recur']['hash']['a'] = 'X';
        that($values2['recur']['recur']['recur']['hash']['a'])->is('X');
        that($values2['hash']['a'])->is('A');

        $recur = [1, 2, 3];
        $vvv = ['X'];
        $values = [
            'y'      => $vvv,
            'vvv'    => &$vvv,
            'recur1' => &$recur,
            'recur2' => &$recur,
        ];
        $exported = (var_export3)($values, ['outmode' => 'eval']);
        that(serialize($values2 = eval($exported)))->isSame(serialize($values));
        $values2['recur1'][1] = 9;
        that($values2['recur1'][1])->is(9);
        that($values2['recur1'][1])->is(9);
    }

    function test_var_export3_closure()
    {
        $object = new \DateTime('2014/12/24 12:34:56');
        $closures = [
            'object'    => $object,
            'simple'    => static function () { return 123; },
            'declare'   => static function (?Ex $e = null, $c = SR): Ex { return $e; },
            'alias'     => static function () { return [SR, Ex::class, gt(123)]; },
            'use'       => static function () use ($object) { return $object; },
            'bind'      => \Closure::bind(function () { return $this; }, $object),
            'internal1' => \Closure::fromCallable('strlen'),
            'internal2' => \Closure::fromCallable('Closure::fromCallable'),
            'internal3' => (new \ReflectionClass($object))->getMethod('format')->getClosure($object),
            'internal4' => (new \ReflectionClass($object))->getMethod('format')->getClosure(new \DateTime('2012/12/24 12:34:56')),
        ];
        $exported = (var_export3)($closures, ['outmode' => 'eval']);
        $closures = eval($exported);
        that($closures['simple']())->is(123);
        that($closures['declare'](new \Exception('yyy')))->is(new \Exception('yyy'));
        that($closures['alias']())->is([SR, Ex::class, 'integer']);
        that($closures['use']())->is($object);
        that($closures['bind']())->is($object);
        that($closures['internal1']('hoge'))->is(4);
        that($closures['internal2']('strlen')('fuga'))->is(4);
        that($closures['internal3']('Ymd'))->is('20141224');
        that($closures['internal4']('Ymd'))->is('20121224');

        $object = new Invoker();
        $closures = [
            'array'  => \Closure::fromCallable([$object, 'm']),
            'static' => \Closure::fromCallable([get_class($object), 'S']),
            'invoke' => \Closure::fromCallable($object),
        ];
        $exported = (var_export3)($closures, ['outmode' => 'eval']);
        $closures = eval($exported);
        that($closures['array'](1))->is(2);
        that($closures['static'](1))->is(3);
        that($closures['invoke'](1))->is(4);

        $closure = static function ($arg) {
            $closure = function ($v) use ($arg) {
                return $v + $arg;
            };
            $object = new class($closure) {
                private $closure;

                public function __construct($closure) { $this->closure = $closure; }

                public function __invoke($arg) { return ($this->closure)($arg); }
            };
            return $object($arg);
        };
        $exported = (var_export3)($closure, ['outmode' => 'eval']);
        $closure = eval($exported);
        that($closure(2))->is(4);

        $fibonacci = (function ($n) use (&$fibonacci) {
            if ($n < 2) {
                return $n;
            }
            static $memo = [];
            return $memo[$n] = $memo[$n] ?? $fibonacci($n - 2) + $fibonacci($n - 1);
        })->bindTo(new \stdClass());
        that($fibonacci(10))->is(55);
        $exported = (var_export3)($fibonacci, ['outmode' => 'eval']);
        that($exported)->contains('static $memo = [];');
        $fibonacci2 = eval($exported);
        that($fibonacci2(10))->is(55);
    }

    function test_var_export3_object()
    {
        $recursive = new \stdClass();
        $recursive->recur = $recursive;
        $setstate = new Concrete('setstate');
        $setstate->value = $setstate;
        (function ($v) { $this->privateField = $v; })->bindTo($setstate, AbstractConcrete::class)('Changed');
        $objects = [
            'sleepwakeup' => new SleepWakeupMethod('sqlite::memory:'),
            'serial'      => new SerialMethod(),
            'concreate'   => $setstate,
        ];
        $exported = (var_export3)($objects, ['outmode' => 'eval']);
        $objects2 = eval($exported);
        that($objects2['sleepwakeup']->getPdo())->isInstanceOf(\PDO::class);
        that($objects2['concreate'])->is($setstate);
        that($objects2['concreate']->getPrivate())->is('Changed/Concrete');

        that(serialize($objects2))->isSame(serialize(unserialize(serialize($objects))));
    }

    function test_var_export3_anonymous()
    {
        $anonymous = new class([1, 2, 3]) extends \ArrayObject {
            function method()
            {
                return parent::getArrayCopy();
            }
        };
        $objects = [
            'anonymous' => new class($anonymous) {
                private $object;

                public function __construct($object)
                {
                    $this->object = $object;
                }

                function __invoke()
                {
                    return $this->object->method();
                }
            },
            'resolve'   => new class ( ) extends Vars { },
        ];
        $exported = (var_export3)($objects, ['outmode' => 'eval']);
        $objects2 = eval($exported);
        that($objects2['anonymous']())->is([1, 2, 3]);
        that($objects2['resolve'])->isInstanceOf(Vars::class);
    }

    function test_var_export3_reference()
    {
        $array1 = [1, 2, 3];
        $array2 = [1, 2, 3];
        $string = 'string';
        $object = (object) ['a' => 'A', 'b' => 'B'];
        $values = [
            'array1'  => &$array1,
            'array2'  => &$array2,
            'string1' => &$string,
            'string2' => &$string,
            'folder1' => [
                'filder2' => [
                    'string3' => &$string,
                ],
            ],
            'object1' => &$object,
            'object2' => &$object,
            'actual1' => ['a' => 'A', 'b' => 'B'],
            'actual2' => (object) ['a' => 'A', 'b' => 'B'],
            'self1'   => &$values,
            'self2'   => &$values,
        ];
        $exported = (var_export3)($values, ['outmode' => 'eval']);
        $values2 = eval($exported);

        $values2['array1'][] = 9;
        that($values2['array1'])->isSame([1, 2, 3, 9]);
        that($values2['array2'])->isSame([1, 2, 3]);

        $values2['string1'] = 'changed!';
        that($values2['string1'])->isSame('changed!');
        that($values2['string2'])->isSame('changed!');

        $values2['object1']->field = 'changed!';
        that($values2['object1']->field)->isSame('changed!');
        that($values2['object2']->field)->isSame('changed!');

        $values2['self1']['new'] = 'new!';
        //that($values2['new'])->isSame('new!'); // eval で参照返しなんてできない
        that($values2['self1']['new'])->isSame('new!');
        that($values2['self2']['new'])->isSame('new!');
    }

    function test_var_export3_misc()
    {
        that((var_export3)([1, 2, 3], ['outmode' => 'file', 'return' => true]))->stringStartsWith('<?php return (function () {');
        that((var_export3)([1, 2, 3], ['outmode' => 'eval', 'return' => true]))->stringStartsWith('return (function () {');
        that((var_export3)([1, 2, 3], ['format' => 'minify', 'return' => true]))->notContains("\n");

        that(var_export3)((function () { yield 1; })())->wasThrown('is not support');

        that(var_export3)->fn([1, 2, 3])->outputMatches('#newInstanceWithoutConstructor#');
    }

    function test_var_html()
    {
        $recur = ['a' => 'A'];
        $recur['r'] = &$recur;
        $value = [
            'array'       => [1, 2, 3,],
            'hash'        => [
                'a' => 'A',
                'b' => 'B',
            ],
            'empty'       => [],
            'emptyempty'  => [[]],
            'emptyempty1' => [[[1]]],
            'nest'        => [
                'hash'  => [
                    'a'    => 'A',
                    'b'    => 'B',
                    'hash' => [
                        'x' => 'X',
                    ],
                ],
                'array' => [
                    [1, 2, 3, ['X']],
                ],
            ],
            'null'        => null,
            'int'         => 123,
            'string'      => 'ABC',
            'object'      => new \DateTime(),
            'resource'    => STDOUT,
            'recur'       => $recur,
        ];
        that(var_html)->fn($value)->outputMatches('#<pre class=\'var_html\'>#');
    }

    function test_var_pretty()
    {
        that(var_pretty)(null, ['context' => 'hoge'])->wasThrown('is not supported');

        $recur = ['a' => 'A'];
        $recur['r'] = &$recur;
        $closure = fn() => $recur;
        $sclosure = static fn() => $recur;
        $value = [
            (stdclass)([
                'A' => (stdclass)([
                    'X' => new \stdClass(),
                ]),
            ]),
            'E'     => new \Concrete('hoge'),
            'A'     => ["str", 1, 2, 3, true, null],
            'H'     => ['a' => 'A', 'b' => 'B'],
            'C'     => $closure,
            'c1'    => [$sclosure, $sclosure],
            'R'     => STDOUT,
            'deep'  => [[[[[[[[['X']]]]]]]]],
            'more1' => range(1, 20),
            'more2' => array_combine(range(1, 20), range(1, 20)),
            'more3' => array_fill_keys(range(0, 19), 'ssssssssss'),
            'more4' => str_repeat('ssssssssss', 32),
            'more5' => [str_repeat('long-string', 64)],
            'more6' => ['x' => str_repeat('long-string', 64)],
            'empty' => [],
        ];
        that((var_pretty)($value, [
            'context'   => 'plain',
            'return'    => true,
            'maxcolumn' => 80,
            'maxdepth'  => 5,
            'maxcount'  => 16,
            'maxlength' => 128,
            'trace'     => 3,
        ]))
            ->stringContains(__FILE__)
            ->stringContains("  0: stdClass#")
            ->stringContains("      X: stdClass#")
            ->stringContains("  E: Concrete#")
            ->stringContains("    info: 'this is __debugInfo'")
            ->stringContains("  A: ['str', 1, 2, 3, true, null]")
            ->stringContains("ryunosuke\\Test\\Package\\VarsTest#")
            ->stringContains("    recur: {")
            ->stringContains("    Closure@")
            ->stringContains("    Closure@")
            ->stringContains("  R: Resource id #2 of type (stream)")
            ->stringContains("          (too deep)")
            ->stringContains("  more1: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16\n\t   (more 4 elements)]")
            ->stringContains("    (more 4 elements)")
            ->stringContains(", \n\t  ...(too length)..., ")
            ->stringContains("s...(too length)...s")
            ->stringContains("  more5: [...(too length)..., ]")
            ->stringContains("  more6: {\n    ...")
            ->stringContains("  empty: []");

        that((var_pretty)($value, [
            'context' => 'plain',
            'return'  => true,
            'limit'   => 64,
        ]))
            ->stringContains("      X: (...omitted)");

        that((var_pretty)($value, [
            'context'  => 'plain',
            'return'   => true,
            'callback' => function (&$string, $var, $nest) {
                if (is_resource($var)) {
                    $string = "this is custom resource($nest)";
                }
            },
        ]))
            ->stringContains("R: this is custom resource(1)");

        that((var_pretty)($value, [
            'context' => 'plain',
            'return'  => true,
            'minify'  => true,
        ]))
            ->stringNotContains("\n")
            ->stringNotContains("0:stdClass#")
            ->stringContains("E:Concrete#")
            ->stringContains("A:['str', 1, 2, 3, true, null]")
            ->stringContains("R:Resource id #2 of type (stream)")
            ->stringContains("empty:[]");

        that((var_pretty)($value, ['context' => 'cli', 'return' => true]))->stringContains("\033");
        that((var_pretty)($value, ['context' => 'html', 'return' => true]))->stringContains("<span");

        that(var_pretty)->fn($value)->outputMatches('#Concrete#');
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function test_console_log()
    {
        $this->expectOutputRegex('#aaa#');
        (console_log)('aaa');
        echo 'aaa';
        ob_end_flush();
    }

    function test_console_log_ex()
    {
        $this->expectExceptionMessage('header is already sent');
        (console_log)('aaa');
    }

    function test_hashvar()
    {
        $hoge = 1;
        $fuga = 2;
        $piyo = 3;
        that((hashvar)($hoge))->is(compact('hoge'));
        that((hashvar)($piyo, $fuga))->is(compact('piyo', 'fuga'));

        // 同一行で2回呼んでも引数の数が異なれば区別できる
        that([(hashvar)($hoge), (hashvar)($piyo, $fuga)])->is([compact('hoge'), compact('piyo', 'fuga')]);

        // 引数の数が同じでも行が異なれば区別できる
        that([
            (hashvar)($hoge),
            (hashvar)($fuga),
        ])->is([compact('hoge'), compact('fuga')]);

        // 即値は使用できない
        that(function () {
            $hoge = 1;
            (hashvar)($hoge, 1);
        })()->wasThrown(new \UnexpectedValueException('variable'));

        // 同一行に同じ引数2つだと区別出来ない
        that(function () {
            $hoge = 1;
            $fuga = 2;
            [(hashvar)($hoge), (hashvar)($fuga)];
        })()->wasThrown(new \UnexpectedValueException('ambiguous'));
    }
}
