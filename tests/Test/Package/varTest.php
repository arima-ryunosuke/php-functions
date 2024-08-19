<?php

namespace ryunosuke\Test\Package;

use AbstractConcrete;
use ArrayObject;
use Concrete;
use Exception as Ex;
use Invoker;
use ryunosuke\Functions\Package\Caller;
use ryunosuke\Test\Package\files\enums\IntEnum;
use ryunosuke\Test\Package\files\enums\StringEnum;
use SerialMethod;
use SleepWakeupMethod;
use stdClass;
use function gettype as gt;
use function ryunosuke\Functions\Package\arrayable_key_exists;
use function ryunosuke\Functions\Package\arrayval;
use function ryunosuke\Functions\Package\attr_get;
use function ryunosuke\Functions\Package\decrypt;
use function ryunosuke\Functions\Package\encrypt;
use function ryunosuke\Functions\Package\flagval;
use function ryunosuke\Functions\Package\hashvar;
use function ryunosuke\Functions\Package\is_arrayable;
use function ryunosuke\Functions\Package\is_decimal;
use function ryunosuke\Functions\Package\is_empty;
use function ryunosuke\Functions\Package\is_exportable;
use function ryunosuke\Functions\Package\is_primitive;
use function ryunosuke\Functions\Package\is_recursive;
use function ryunosuke\Functions\Package\is_resourcable;
use function ryunosuke\Functions\Package\is_stringable;
use function ryunosuke\Functions\Package\is_typeof;
use function ryunosuke\Functions\Package\numberify;
use function ryunosuke\Functions\Package\numval;
use function ryunosuke\Functions\Package\phpval;
use function ryunosuke\Functions\Package\si_prefix;
use function ryunosuke\Functions\Package\si_unprefix;
use function ryunosuke\Functions\Package\stringify;
use function ryunosuke\Functions\Package\var_apply;
use function ryunosuke\Functions\Package\var_applys;
use function ryunosuke\Functions\Package\var_export2;
use function ryunosuke\Functions\Package\var_export3;
use function ryunosuke\Functions\Package\var_hash;
use function ryunosuke\Functions\Package\var_pretty;
use function ryunosuke\Functions\Package\var_type;
use function ryunosuke\Functions\Package\varcmp;
use const ryunosuke\Functions\Package\IS_OWNSELF;
use const ryunosuke\Functions\Package\SI_UNITS;
use const ryunosuke\Functions\Package\SORT_STRICT;
use const SORT_REGULAR as SR;

class varTest extends AbstractTestCase
{
    function test_arrayable_key_exists()
    {
        $array = [
            'ok'    => 'OK',
            'null'  => null,
            'false' => false,
        ];
        that(arrayable_key_exists('ok', $array))->isTrue();
        that(arrayable_key_exists('null', $array))->isTrue();
        that(arrayable_key_exists('false', $array))->isTrue();
        that(arrayable_key_exists('notfound', $array))->isFalse();

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

            public function offsetGet($offset): mixed
            {
                if ($offset === 'ex') {
                    throw new \OutOfBoundsException();
                }
                return $this->holder[$offset];
            }

            public function offsetSet($offset, $value): void { }

            public function offsetUnset($offset): void { }
        };
        that(arrayable_key_exists('ok', $object))->isTrue();
        that(arrayable_key_exists('null', $object))->isTrue();
        that(arrayable_key_exists('false', $object))->isTrue();
        that(arrayable_key_exists('notfound', $object))->isFalse();
        that(arrayable_key_exists('ex', $object))->isFalse();

        that(self::resolveFunction('arrayable_key_exists'))(null, new \stdClass())->wasThrown('must be array or ArrayAccess');
    }

    function test_arrayval()
    {
        that(arrayval('str'))->is(['str']);
        that(arrayval(['array']))->is(['array']);
        that(array_map(self::resolveFunction('arrayval'), [1, 'str', ['array']]))->is([
            [1],
            ['str'],
            ['array'],
        ]);

        $ao = new \ArrayObject([1, 2, 3]);
        that(arrayval([
            'k'  => 'v',
            'ao' => $ao,
        ]))->isSame([
            'k'  => 'v',
            'ao' => [1, 2, 3],
        ]);
        that(arrayval([
            'k'  => 'v',
            'ao' => $ao,
        ], false))->isSame([
            'k'  => 'v',
            'ao' => $ao,
        ]);

        $inner = (object) [
            'inner-scalar2',
            (object) [
                'lastleaf',
            ],
        ];
        $stdclass = (object) [
            'key'   => 'inner-scalar1',
            'inner' => $inner,
        ];

        that(arrayval($stdclass, true))->isSame([
            'key'   => 'inner-scalar1',
            'inner' => [
                'inner-scalar2',
                [
                    'lastleaf',
                ],
            ],
        ]);

        that(arrayval($stdclass, false))->isSame([
            'key'   => 'inner-scalar1',
            'inner' => $inner,
        ]);
    }

    function test_attr_get()
    {
        $array = [
            'ok'    => 'OK',
            'null'  => null,
            'false' => false,
        ];
        that(attr_get('ok', $array))->isSame('OK');
        that(attr_get('null', $array))->isSame(null);
        that(attr_get('false', $array))->isSame(false);
        that(attr_get('notfound', $array, 'default'))->isSame('default');

        $object = (object) $array;
        that(attr_get('ok', $object))->isSame('OK');
        that(attr_get('null', $object))->isSame(null);
        that(attr_get('false', $object))->isSame(false);
        that(attr_get('notfound', $object, 'default'))->isSame('default');

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

            public function offsetGet($offset): mixed
            {
                if ($offset === 'ex') {
                    throw new \OutOfBoundsException();
                }
                return $this->holder[$offset];
            }

            public function offsetSet($offset, $value): void { }

            public function offsetUnset($offset): void { }
        };
        that(attr_get('ok', $object))->isSame('OK');
        that(attr_get('null', $object))->isSame(null);
        that(attr_get('false', $object))->isSame(false);
        that(attr_get('notfound', $object, 'default'))->isSame('default');
        that(attr_get('ex', $object, 'default'))->isSame('default');

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
        that(attr_get('ok', $object))->isSame('OK');
        that(attr_get('null', $object))->isSame(null);
        that(attr_get('false', $object))->isSame(false);
        that(attr_get('notfound', $object, 'default'))->isSame('default');
        that(attr_get('ex', $object, 'default'))->isSame('default');

        $closure = function () { };
        that(attr_get('ok', $closure))->isSame(null);
        that(attr_get('ok', $closure, 'default'))->isSame('default');

        that(self::resolveFunction('attr_get'))(null, 'dummy')->wasThrown('must be array or object');
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

        $rewrite = function ($eitherTagIv, $encrypted) {
            $cipherdata = base64_decode(strtr($encrypted, ['-' => '+', '_' => '/']));
            if ($eitherTagIv === 'tag') {
                $cipherdata[0] = "\0";
            }
            if ($eitherTagIv === 'iv') {
                $cipherdata[16] = "\0";
            }
            return strtr(base64_encode($cipherdata), ['+' => '-', '/' => '_']);
        };

        $encrypted = encrypt($data, 'secret');
        that(decrypt($encrypted, 'secret'))->isSame($data);              // password が同じなら復号できる
        that(decrypt($encrypted, ['invalid', 'secret']))->isSame($data); // password は配列でもよい
        that(decrypt($encrypted, 'invalid'))->isNull();                  // password が異なれば複合できない
        that(decrypt($rewrite('tag', $encrypted), 'secret'))->isNull();  // tag が不正なら複合できない
        that(decrypt($rewrite('iv', $encrypted), 'secret'))->isNull();   // iv が不正なら複合できない
        that(decrypt('this is invalid=4', 'secret'))->isNull();          // data が不正なら複合できない
        that(encrypt($data, 'secret'))->isNotSame($encrypted);           // gcm なので異なる暗号文が生成される
    }

    function test_encrypt_decrypt_invalid()
    {
        that(decrypt('', 'secret', 'aes-128-ecb'))->isNull();
        that(decrypt('=0', 'secret', 'aes-128-ecb'))->isNull();
        that(decrypt('=1', 'secret', 'aes-128-ecb'))->isNull();
        that(decrypt('v=1', 'secret', 'aes-128-ecb'))->isNull();
        that(decrypt('v3', 'secret', 'aes-128-ecb'))->isNull();
        that(decrypt('v4', 'secret'))->isNull();
        that(decrypt('xxxxxxxxxxxxxxxxxxxx', 'secret', 'aes-128-ecb'))->isNull();
        that(decrypt(base64_encode('xxxxxxxxxxxxxxxxxxxx') . '=1', 'secret', 'aes-128-ecb'))->isNull();
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

        $encrypted = encrypt($data, 'secret', 'aes-128-ecb');                 // IV なし, TAG なし
        that(decrypt($encrypted, 'secret'))->isSame($data);                   // password が同じなら復号できる
        that(decrypt($encrypted, ['invalid', 'secret']))->isSame($data);      // password は配列でもよい
        that(decrypt($encrypted, 'invalid'))->isNull();                       // password が異なれば複合できない
        that(decrypt('this is invalid', 'secret'))->isNull();                 // data が不正なら複合できない
        that(encrypt($data, 'secret', 'aes-128-ecb'))->isSame($encrypted);    // ecb なので同じ暗号文が生成される

        $encrypted = encrypt($data, 'secret', 'aes-256-cbc');                 // IV あり, TAG なし
        that(decrypt($encrypted, 'secret'))->isSame($data);                   // password が同じなら復号できる
        that(decrypt($encrypted, ['invalid', 'secret']))->isSame($data);      // password は配列でもよい
        that(decrypt($encrypted, 'invalid'))->isNull();                       // password が異なれば複合できない
        that(decrypt('this is invalid', 'secret'))->isNull();                 // data が不正なら複合できない
        that(encrypt($data, 'secret', 'aes-256-cbc'))->isNotSame($encrypted); // cbc なので異なる暗号文が生成される

        $encrypted = encrypt($data, 'secret', 'aes-256-ccm');                 // IV あり, TAG あり
        that(decrypt($encrypted, 'secret'))->isSame($data);                   // password が同じなら復号できる
        that(decrypt($encrypted, ['invalid', 'secret']))->isSame($data);      // password は配列でもよい
        that(decrypt($encrypted, 'invalid'))->isNull();                       // password が異なれば複合できない
        that(decrypt('this is invalid=2', 'secret'))->isNull();               // data が不正なら複合できない
        that(encrypt($data, 'secret', 'aes-256-ccm'))->isNotSame($encrypted); // ccm なので異なる暗号文が生成される

        that(self::resolveFunction('encrypt'))('dummy', 'pass', 'unknown')->wasThrown('undefined cipher algorithm');

        $v1 = "uuz9p1tBXG3jFKV_y2PN_23s549iyppC5TsUeC4uOe5vdDNkot8DjuXL9kWzmDUlmPH4k0VP05nlHazteEQndsClvXVt_LztaTFno0Y0tg8=1";
        that(decrypt($v1, 'secret', 'aes-128-ecb'))->isSame($data);

        $v2 = "YWVzLTEyOC1lY2I6uuz9p1tBXG3jFKV_y2PN_23s549iyppC5TsUeC4uOe5vdDNkot8DjuXL9kWzmDUlmPH4k0VP05nlHazteEQndsClvXVt_LztaTFno0Y0tg8=2";
        that(decrypt($v2, 'secret', 'aes-128-ecb'))->isSame($data);
        that(decrypt($v2, 'invalid', 'aes-128-ecb'))->isNull();

        $v3 = "KkEchcWXN6ckkhx0xtooSRTttT4A9phKRAICrW9BoGgDb8H3H4pP1c9X57sOigLRrQDJ53soq3j9tvs-pwGtKZR-HK2WgD24VmB0jNVUxcKJbFpIogiNJ_a-U26tqjo6YWVzLTI1Ni1jY203";
        that(decrypt($v3, 'secret', 'aes-128-ecb'))->isSame($data);
        that(decrypt($v3, 'invalid', 'aes-128-ecb'))->isNull();
    }

    function test_flagval()
    {
        that(flagval(true))->isTrue();
        that(flagval(false))->isFalse();

        that(flagval(1))->isTrue();
        that(flagval(0))->isFalse();
        that(flagval(-0))->isFalse();
        that(flagval(0.0))->isFalse();
        that(flagval(-0.0))->isFalse();

        that(flagval(NAN))->isTrue();
        that(flagval(INF))->isTrue();

        that(flagval([0]))->isTrue();
        that(flagval([]))->isFalse();

        that(flagval((object) []))->isTrue();
        that(flagval(new \ArrayObject([])))->isTrue();

        that(flagval(''))->isFalse();
        that(flagval("\t \n"))->isTrue();
        that(flagval("\t \n", true))->isFalse();
        that(flagval(' false '))->isTrue();
        that(flagval(' false ', true))->isFalse();

        that(flagval('1'))->isTrue();
        that(flagval('0.0'))->isTrue();
        that(flagval("0"))->isFalse();

        that(flagval('true'))->isTrue();
        that(flagval('tRUE'))->isTrue();
        that(flagval('false'))->isFalse();
        that(flagval('fALSE'))->isFalse();

        that(flagval('on'))->isTrue();
        that(flagval('oN'))->isTrue();
        that(flagval('off'))->isFalse();
        that(flagval('oFF'))->isFalse();

        that(flagval('yes'))->isTrue();
        that(flagval('yES'))->isTrue();
        that(flagval('no'))->isFalse();
        that(flagval('nO'))->isFalse();

        that(flagval('hoge'))->isTrue();
        that(flagval('null'))->isTrue();
        that(flagval('nil'))->isTrue();
    }

    function test_hashvar()
    {
        $hoge = 1;
        $fuga = 2;
        $piyo = 3;
        that(hashvar($hoge))->is(compact('hoge'));
        that(hashvar($piyo, $fuga))->is(compact('piyo', 'fuga'));

        // 同一行で2回呼んでも引数の数が異なれば区別できる
        that([hashvar($hoge), hashvar($piyo, $fuga)])->is([compact('hoge'), compact('piyo', 'fuga')]);

        // 引数の数が同じでも行が異なれば区別できる
        that([
            hashvar($hoge),
            hashvar($fuga),
        ])->is([compact('hoge'), compact('fuga')]);

        // 即値は使用できない
        that(function () {
            $hoge = 1;
            hashvar($hoge, 1);
        })()->wasThrown(new \UnexpectedValueException('variable'));

        // 同一行に同じ引数2つだと区別出来ない
        that(function () {
            $hoge = 1;
            $fuga = 2;
            [hashvar($hoge), hashvar($fuga)];
        })()->wasThrown(new \UnexpectedValueException('ambiguous'));
    }

    function test_is_arrayable()
    {
        that(is_arrayable([]))->isTrue();
        that(is_arrayable(new \ArrayObject()))->isTrue();

        that(is_arrayable(1))->isFalse();
        that(is_arrayable(new \stdClass()))->isFalse();
    }

    function test_is_decimal()
    {
        that(is_decimal(''))->isFalse();
        that(is_decimal(null))->isFalse();
        that(is_decimal('hoge'))->isFalse();
        that(is_decimal('1f'))->isFalse();
        that(is_decimal('12.'))->isFalse();
        that(is_decimal('.12'))->isFalse();
        that(is_decimal('1e2'))->isFalse();
        that(is_decimal('012'))->isFalse();
        that(is_decimal(' 12'))->isFalse();
        that(is_decimal('12 '))->isFalse();
        that(is_decimal('-+12'))->isFalse();
        that(is_decimal('+1-2'))->isFalse();

        that(is_decimal('0'))->isTrue();
        that(is_decimal('0.00'))->isTrue();
        that(is_decimal('12.34'))->isTrue();
        that(is_decimal('12.30'))->isTrue();
        that(is_decimal('-12.30'))->isTrue();
        that(is_decimal('+12.30'))->isTrue();

        that(is_decimal('12.3', false))->isFalse();
        that(is_decimal('12', false))->isTrue();
    }

    function test_is_empty()
    {
        $stdclass = new \stdClass();
        $arrayo1 = new \ArrayObject([1]);
        $arrayo2 = new \ArrayObject([]);
        // この辺は empty と全く同じ（true）
        that(is_empty(null))->isSame(empty(null));
        that(is_empty(false))->isSame(empty(false));
        that(is_empty(0))->isSame(empty(0));
        that(is_empty(0.0))->isSame(empty(0.0));
        that(is_empty(''))->isSame(empty(''));
        that(is_empty([]))->isSame(empty([]));
        // この辺は empty と全く同じ（false）
        that(is_empty($stdclass))->isSame(empty($stdclass));
        that(is_empty($arrayo1))->isSame(empty($arrayo1));
        that(is_empty(true))->isSame(empty(true));
        that(is_empty(1))->isSame(empty(1));
        that(is_empty(1.0))->isSame(empty(1.0));
        that(is_empty('0.0'))->isSame(empty('0.0'));
        that(is_empty('00'))->isSame(empty('00'));
        that(is_empty([1]))->isSame(empty([1]));
        // この辺は差異がある
        that(is_empty('0'))->isNotSame(empty('0'));
        that(is_empty($arrayo2))->isNotSame(empty($arrayo2));

        /// stdClass だけは引数で分岐できる
        $stdclass = new \stdClass();
        $stdClassEx = new class extends stdClass { };

        // 空 stdClass は空
        that(is_empty($stdclass, true))->isTrue();
        // 空でなければ空ではない
        $stdclass->hoge = 123;
        that(is_empty($stdclass, true))->isFalse();
        // 継承していれば空でも空ではない
        that(is_empty($stdClassEx, true))->isFalse();
        // 自明だが継承して空でなければ空ではない
        $stdClassEx->hoge = 123;
        that(is_empty($stdClassEx, true))->isFalse();
    }

    function test_is_exportable()
    {
        // scalar
        that(is_exportable(null))->isTrue();
        that(is_exportable(false))->isTrue();
        that(is_exportable(123))->isTrue();
        that(is_exportable(3.14))->isTrue();
        that(is_exportable('string'))->isTrue();

        // resource
        $resource = tmpfile();
        that(is_exportable($resource))->isFalse();
        fclose($resource);
        that(is_exportable($resource))->isFalse();

        // recursive
        $array = [];
        $array['recur'] = &$array;
        that(is_exportable($array))->isFalse();
        $object = new \stdClass();
        $object->recur = $object;
        that(is_exportable($object))->isFalse();

        // array
        that(is_exportable([]))->isTrue();
        that(is_exportable([null, false, 123, 3.14, 'string']))->isTrue();
        that(is_exportable([null, false, 123, 3.14, $resource]))->isFalse();
        that(is_exportable([[[[[null, false, 123, 3.14, 'string']]]]]))->isTrue();
        that(is_exportable([[[[$resource]]]]))->isFalse();

        // object
        that(is_exportable(new \DateTime()))->isTrue();
        that(is_exportable(new \stdClass()))->isTrue();
        that(is_exportable(curl_init()))->isFalse();
        that(is_exportable(new class() {
            public static function __set_state(array $an_array): object
            {
                return new static();
            }
        }))->isFalse();
        that(is_exportable(function () { }))->isFalse();
        that(is_exportable((function () { yield 1; })()))->isFalse();
        that(is_exportable(IntEnum::Case1()))->isTrue();
        that(is_exportable(StringEnum::CaseHoge()))->isTrue();
    }

    function test_is_primitive()
    {
        that(is_primitive(null))->isTrue();
        that(is_primitive(false))->isTrue();
        that(is_primitive(true))->isTrue();
        that(is_primitive(123))->isTrue();
        that(is_primitive(123.456))->isTrue();
        that(is_primitive('hoge'))->isTrue();
        that(is_primitive(STDIN))->isTrue();

        that(is_primitive(['array']))->isFalse();
        that(is_primitive(new \stdClass()))->isFalse();
    }

    function test_is_recursive()
    {
        that(is_recursive(null))->isFalse();
        that(is_recursive(false))->isFalse();
        that(is_recursive(true))->isFalse();
        that(is_recursive(123))->isFalse();
        that(is_recursive(123.456))->isFalse();
        that(is_recursive('hoge'))->isFalse();
        that(is_recursive(STDIN))->isFalse();
        that(is_recursive(['hoge']))->isFalse();
        that(is_recursive((object) ['hoge' => 'hoge']))->isFalse();

        $rarray = [];
        $rarray = ['rec' => &$rarray];
        that(is_recursive($rarray))->isTrue();

        $rnestarray = [];
        $rnestarray = [
            'parent' => [
                'child' => [
                    'grand' => &$rnestarray,
                ],
            ],
        ];
        that(is_recursive($rnestarray))->isTrue();

        $robject = new \stdClass();
        $robject->rec = $robject;
        that(is_recursive($robject))->isTrue();

        $rnestobject = new \stdClass();
        $rnestobject->parent = new \stdClass();
        $rnestobject->parent->child = new \stdClass();
        $rnestobject->parent->child->grand = $rnestobject;
        that(is_recursive($rnestobject))->isTrue();
    }

    function test_is_resourcable()
    {
        that(is_resourcable(null))->isFalse();
        that(is_resourcable(false))->isFalse();
        that(is_resourcable(true))->isFalse();
        that(is_resourcable(123))->isFalse();
        that(is_resourcable(123.456))->isFalse();
        that(is_resourcable('hoge'))->isFalse();
        that(is_resourcable(['array']))->isFalse();
        that(is_resourcable(new \stdClass()))->isFalse();
        that(is_resourcable(new \Concrete('hoge')))->isFalse();
        that(is_resourcable(STDIN))->isTrue();
        that(is_resourcable(STDOUT))->isTrue();

        $resource = tmpfile();
        that(is_resourcable($resource))->isTrue();
        fclose($resource);
        that(is_resourcable($resource))->isTrue();
    }

    function test_is_stringable()
    {
        that(is_stringable(null))->isTrue();
        that(is_stringable(false))->isTrue();
        that(is_stringable(true))->isTrue();
        that(is_stringable(123))->isTrue();
        that(is_stringable(123.456))->isTrue();
        that(is_stringable('hoge'))->isTrue();
        that(is_stringable(STDIN))->isTrue();
        that(is_stringable(['array']))->isFalse();
        that(is_stringable(new \stdClass()))->isFalse();
        that(is_stringable(new \Concrete('hoge')))->isTrue();
    }

    function test_is_typeof()
    {
        $typestring = 'null';
        that(is_typeof(null, $typestring))->isTrue();
        that(is_typeof(1, $typestring))->isFalse();

        $typestring = 'false|true';
        that(is_typeof(false, $typestring))->isTrue();
        that(is_typeof(true, $typestring))->isTrue();
        that(is_typeof(1, $typestring))->isFalse();

        $typestring = '?int';
        that(is_typeof(1, $typestring))->isTrue();
        that(is_typeof('s', $typestring))->isFalse();
        that(is_typeof(null, $typestring))->isTrue();

        $typestring = 'string';
        that(is_typeof('s', $typestring))->isTrue();
        that(is_typeof(1, $typestring))->isFalse();
        that(is_typeof(null, $typestring))->isFalse();

        $typestring = 'null|int|string';
        that(is_typeof(null, $typestring))->isTrue();
        that(is_typeof(1, $typestring))->isTrue();
        that(is_typeof('s', $typestring))->isTrue();
        that(is_typeof([], $typestring))->isFalse();

        $typestring = 'null|int|string';
        that(is_typeof(null, $typestring))->isTrue();
        that(is_typeof(1, $typestring))->isTrue();
        that(is_typeof('s', $typestring))->isTrue();
        that(is_typeof([], $typestring))->isFalse();

        $typestring = 'countable';
        that(is_typeof(new \ArrayObject(), $typestring))->isTrue();
        that(is_typeof([], $typestring))->isTrue();
        that(is_typeof('s', $typestring))->isFalse();

        $typestring = 'Countable';
        that(is_typeof(new \ArrayObject(), $typestring))->isTrue();
        that(is_typeof([], $typestring))->isFalse();
        that(is_typeof('s', $typestring))->isFalse();

        $typestring = 'Exception|static';
        that(is_typeof(new \RuntimeException(), $typestring))->isTrue();
        that(is_typeof(new \Error(), $typestring, \Error::class))->isTrue();
        that(is_typeof(new \Error(), $typestring))->isFalse();

        $typestring = 'iterable&Countable';
        that(is_typeof(new \ArrayObject(), $typestring))->isTrue();
        that(is_typeof([], $typestring))->isFalse();
        that(is_typeof(new \EmptyIterator(), $typestring))->isFalse();
        that(is_typeof(new \stdClass(), $typestring))->isFalse();
        that(is_typeof(null, $typestring))->isFalse();

        $typestring = 'array|(iterable&Countable)';
        that(is_typeof([], $typestring))->isTrue();
        that(is_typeof(new \ArrayObject(), $typestring))->isTrue();
        that(is_typeof(new \EmptyIterator(), $typestring))->isFalse();
        that(is_typeof(new \stdClass(), $typestring))->isFalse();
        that(is_typeof(null, $typestring))->isFalse();

        // カバレッジ用とかの雑多なもの
        that(is_typeof(STDOUT, 'mixed'))->isTrue();
        that(is_typeof(3.14, 'mixed'))->isTrue();
        that(is_typeof(new \stdClass(), 'mixed'))->isTrue();
        that(is_typeof(fn() => null, 'callable'))->isTrue();
        that(is_typeof('strlen', 'callable'))->isTrue();
        that(is_typeof('undefined_function', 'callable'))->isFalse();
        that(is_typeof(STDOUT, 'resource'))->isTrue();
        that(is_typeof(new \stdClass(), 'object'))->isTrue();
        that(is_typeof(3.14, 'float'))->isTrue();
        that(is_typeof(new \RuntimeException(), 'Exception'))->isTrue();
        that(is_typeof(new \DomainException(), 'RuntimeException'))->isFalse();
    }

    function test_numberize()
    {
        that(numberify(null))->isSame(0);
        that(numberify(false))->isSame(0);
        that(numberify(true))->isSame(1);
        that(numberify(null, true))->isSame(0.0);
        that(numberify(false, true))->isSame(0.0);
        that(numberify(true, true))->isSame(1.0);
        that(numberify([1, 2, 3]))->isSame(3);
        that(numberify([1, 2, 3], true))->isSame(3.0);
        that(numberify(STDIN))->isSame((int) STDIN);
        that(numberify(new \Concrete('a12s3b')))->isSame(123);

        that(numberify(123))->isSame(123);
        that(numberify(12.3))->isSame(12);

        that(numberify(123, true))->isSame(123.0);
        that(numberify(12.3, true))->isSame(12.3);

        that(numberify('aaa123bbb'))->isSame(123);
        that(numberify('a1b2c3'))->isSame(123);
        that(numberify('-a1b2c3'))->isSame(-123);

        that(numberify('aaa12.3bbb'))->isSame(12);
        that(numberify('a1b2.c3'))->isSame(12);
        that(numberify('-a1b2c.3'))->isSame(-12);

        that(numberify('aaa12.3bbb', true))->isSame(12.3);
        that(numberify('a1b2.c3', true))->isSame(12.3);
        that(numberify('-a1b2c.3', true))->isSame(-12.3);

        that(self::resolveFunction('numberify'))('aaa')->wasThrown('is not numeric');
        that(self::resolveFunction('numberify'))('a.a')->wasThrown('is not numeric');
        that(self::resolveFunction('numberify'))('1.2.3', true)->wasThrown('is not numeric');
    }

    function test_numval()
    {
        that(numval(3))->isSame(3);
        that(numval(3.14))->isSame(3.14);
        that(numval('3'))->isSame(3);
        that(numval('3.14'))->isSame(3.14);
        that(numval('3.'))->isSame(3.0);
        that(numval('.3'))->isSame(0.3);
        that(numval(new \Concrete('3.14')))->isSame(3.14);
        that(numval([]))->isSame(0);
        that(numval([1, 2]))->isSame(1);

        that(numval(30, 8))->isSame(30);
        that(numval(30.0, 8))->isSame(30.0);
        that(numval("30", 8))->isSame(24);
        that(numval("30", 16))->isSame(48);
    }

    function test_phpval()
    {
        that(phpval("null"))->isSame(null);
        that(phpval("true"))->isSame(true);
        that(phpval("FALSE"))->isSame(false);
        that(phpval("PHP_INT_SIZE"))->isSame(PHP_INT_SIZE);
        that(phpval("\\PHP_INT_SIZE"))->isSame(PHP_INT_SIZE);
        that(phpval("ArrayObject::ARRAY_AS_PROPS"))->isSame(ArrayObject::ARRAY_AS_PROPS);
        that(phpval("ArrayObject::class"))->isSame(ArrayObject::class);

        that(phpval("-1"))->isSame(-1);
        that(phpval("+1"))->isSame(+1);
        that(phpval("0.0"))->isSame(0.0);
        that(phpval("-1.23"))->isSame(-1.23);

        that(phpval("hoge"))->isSame("hoge");
        that(phpval("bare string"))->isSame("bare string");
        that(phpval("return"))->isSame("return");
        that(phpval("strtoupper('a')"))->isSame("A");

        that(phpval("strtoupper(\$a)", ['a' => 'a']))->isSame("A");
        that(phpval("\$a + \$b", ['a' => 1, 'b' => 2]))->isSame(3);

        that(phpval($object = new \stdClass()))->isSame($object);
        that(phpval("strtoupper(\$undefined)"))->isSame("");
    }

    function test_si_prefix()
    {
        foreach (SI_UNITS as $exp => $units) {
            $unit = $units[0] ?? ' ';
            that(si_prefix(+pow(1000, $exp)))
                ->stringContains('1.000')
                ->stringEndsWith($unit);

            that(si_prefix(-pow(1000, $exp)))
                ->stringContains('-1.000')
                ->stringEndsWith($unit);

            that(si_prefix(+pow(2, $exp * 10), 1024))
                ->stringContains('1.000')
                ->stringEndsWith($unit);

            that(si_prefix(-pow(2, $exp * 10), 1024))
                ->stringContains('-1.000')
                ->stringEndsWith($unit);
        }

        that(si_prefix("0.0"))->is('0.000 ');
        that(si_prefix("0"))->is('0.000 ');
        that(si_prefix(0))->is('0.000 ');
        that(si_prefix(0.0))->is('0.000 ');
        that(si_prefix(999))->is('999.000 ');
        that(si_prefix(1000))->is('1.000 k');
        that(si_prefix(1001))->is('1.001 k');
        that(si_prefix(1023, 1024))->is('1023.000 ');
        that(si_prefix(1024, 1024))->is('1.000 k');
        that(si_prefix(1025, 1024))->is('1.001 k');
        that(si_prefix(0, 1000, null))->is([0, '']);
        that(si_prefix(12345, 1000, null))->is([12.345, 'k']);
        that(si_prefix(12345, 1000, fn($v, $u) => number_format($v, 2) . $u))->is('12.35k');

        that(self::resolveFunction('si_prefix'))(pow(10, 30))->wasThrown('too large or small');
    }

    function test_si_unprefix()
    {
        foreach (SI_UNITS as $exp => $units) {
            foreach ($units as $unit) {
                that(si_unprefix("1$unit"))->is(+pow(1000, $exp));
                that(si_unprefix("-1$unit"))->is(-pow(1000, $exp));

                that(si_unprefix("1$unit", 1024))->is(+pow(2, $exp * 10));
                that(si_unprefix("-1$unit", 1024))->is(-pow(2, $exp * 10));
            }
        }

        that(si_unprefix("0.0"))->is(0);
        that(si_unprefix("0"))->is(0);
        that(si_unprefix(0))->is(0);
        that(si_unprefix(0.0))->is(0);
        that(si_unprefix('999'))->is(999);
        that(si_unprefix('1k'))->is(1000);
        that(si_unprefix('1023', 1024))->is(1023);
        that(si_unprefix('1k', 1024))->is(1024);
        that(si_unprefix('1K', 1024))->is(1024);
        that(si_unprefix('1 K', 1024, '%d %s'))->is(1024);
    }

    function test_stringify()
    {
        that(stringify(null))->is('null');
        that(stringify(false))->is('false');
        that(stringify(true))->is('true');
        that(stringify(123))->is('123');
        that(stringify(123.456))->is('123.456');
        that(stringify('hoge'))->is('hoge');
        that(stringify(STDIN))->is('Resource id #1');
        that(stringify(['array']))->is('["array"]');
        that(stringify(new \stdClass()))->is('stdClass');
        that(stringify(new \Concrete('hoge')))->is('hoge');
        that(stringify(new \SerialObject(['hoge'])))->is('O:12:"SerialObject":1:{i:0;s:4:"hoge";}');
        that(stringify(new \JsonObject(['hoge'])))->is('JsonObject:["hoge"]');
    }

    function test_var_apply()
    {
        // 単値であればそのまま適用される
        that(var_apply('123', self::resolveFunction('numval')))->isSame(123);
        that(var_apply('123', self::resolveFunction('numval'), 8))->isSame(83);
        // 配列なら中身に適用される
        that(var_apply(['123', '456'], self::resolveFunction('numval')))->isSame([123, 456]);
        that(var_apply(['123', '456'], self::resolveFunction('numval'), 8))->isSame([83, 302]);
        // 再帰で処理される
        that(var_apply(['123', '456', 'a' => ['789']], self::resolveFunction('numval')))->isSame([123, 456, 'a' => [789]]);
        // よくあるやつ
        that(var_apply(['<x>', ['<y>']], 'htmlspecialchars', ENT_QUOTES, 'utf-8'))->isSame(['&lt;x&gt;', ['&lt;y&gt;']]);
    }

    function test_var_applys()
    {
        $upper = fn($array) => array_map('strtoupper', $array);
        that(var_applys('a', $upper))->isSame('A');
        that(var_applys(['a', 'b'], $upper))->isSame(['A', 'B']);
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
            'string'      => "ABC\nXYZ",
            'object'      => new \Concrete('hoge'),
        ];
        $a1 = var_export($value, true);
        $a2 = var_export2($value, true);
        that(phpval($a2))->is(phpval($a1));

        $a2 = var_export2($value, ['return' => true, 'minify' => true]);
        that(phpval($a2))->is(phpval($a1));
        that($a2)->is('[' . implode(',', [
                '"array"=>[1,2,3]',
                '"hash"=>["a"=>"A","b"=>"B"]',
                '"empty"=>[]',
                '"emptyempty"=>[[]]',
                '"emptyempty1"=>[[[1]]]',
                '"nest"=>["hash"=>["a"=>"A","b"=>"B","hash"=>["x"=>"X"]]',
                '"array"=>[[1,2,3,["X"]]]]',
                '"null"=>null',
                '"int"=>123',
                '"string"=>"ABC\nXYZ"',
                '"object"=>Concrete::__set_state(["value"=>null,"proptectedField"=>3.14,"privateField"=>"Concrete","name"=>"hoge"])',
            ]) . ']');

        that(var_export2([
            '$var'   => '$var',
            '${var}' => '${var}',
            '{$var}' => '{$var}',
            "\n1"    => "\n1",
            "\n2"    => "\nTEXT",
            "\r\n"   => "\r\n",
            "\\"     => "\\",
            '"'      => '"',
            'key'    => 456,
            'null'   => null,
            'nulls'  => [null],
        ], true))->isSame(<<<'EXPECTED'
        [
            "\$var"   => "\$var",
            "\${var}" => "\${var}",
            "{\$var}" => "{\$var}",
            "\n1"     => <<<TEXT
            
            1
            TEXT,
            "\n2"     => <<<TEXT_
            
            TEXT
            TEXT_,
            "\r\n"    => "\r\n",
            "\\"      => "\\",
            "\""      => "\"",
            "key"     => 456,
            "null"    => null,
            "nulls"   => [null],
        ]
        EXPECTED
        );
        that(var_export2(["'\0\"" => "'\0\""], true))->isSame("[\n    \"'\\0\\\"\" => \"'\\0\\\"\",\n]");

        $val = [
            "'\0\""  => "'\0\"",
            '$var'   => '$var',
            '${var}' => '${var}',
            '{$var}' => '{$var}',
            "\n"     => "\n",
            "\\"     => "\\",
            '"'      => '"',
            'key'    => 456,
            'null'   => null,
            'nulls'  => [null],
        ];
        that(eval("return " . var_export2($val, true) . ";"))->isSame($val);

        that(self::resolveFunction('var_export2'))->fn('hoge')->outputMatches('#hoge#');
    }

    function test_var_export2_private()
    {
        $concrete = new \Concrete('hoge');

        that(var_export2($concrete, true))->is(<<<'VAR'
        Concrete::__set_state([
            "value"           => null,
            "proptectedField" => 3.14,
            "privateField"    => "Concrete",
            "name"            => "hoge",
        ])
        VAR
        );

        $concrete->external = 'aaa';
        that(var_export2($concrete, true))->is(<<<'VAR'
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
        that(var_export2($rarray, true))->is(<<<'VAR'
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
        that(var_export2($robject, true))->is(<<<'VAR'
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
        $exported = var_export3($values, ['outmode' => 'eval']);
        that(serialize(eval($exported)))->isSame(serialize($values));
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
            'closure1'  => \Closure::fromCallable([$anonymous, 'method']),
            'closure2'  => (new \ReflectionMethod($anonymous, 'method'))->getClosure($anonymous),
            'resolve'   => new class ( ) extends ArrayObject { },
            'internal'  => (function () {
                $object = new class () {
                    private \PDO $private_pdo;
                    public       $pdo1;
                    public \PDO  $pdo2;
                    public array $array;

                    public function __construct()
                    {
                        $this->private_pdo = new \PDO('sqlite::memory:');
                        $this->pdo1 = new \PDO('sqlite::memory:');
                        $this->pdo2 = new \PDO('sqlite::memory:');
                        $this->array = ['A', 'B', 'C'];
                    }

                    public function getPDO()
                    {
                        return $this->private_pdo;
                    }
                };
                $object->array = array_merge($object->array, ['Z']);
                return $object;
            })(),
        ];
        $exported = var_export3($objects, ['outmode' => 'eval']);
        $objects2 = eval($exported);
        that($objects2['anonymous']())->is([1, 2, 3]);
        that($objects2['closure1']())->is([1, 2, 3]);
        that($objects2['closure2']())->is([1, 2, 3]);
        that($objects2['resolve'])->isInstanceOf(ArrayObject::class);
        that($objects2['internal'])->getPDO()->getAttribute(\PDO::ATTR_DRIVER_NAME)->is('sqlite');
        that($objects2['internal'])->pdo1->getAttribute(\PDO::ATTR_DRIVER_NAME)->is('sqlite');
        that($objects2['internal'])->pdo2->getAttribute(\PDO::ATTR_DRIVER_NAME)->is('sqlite');
        that($objects2['internal'])->array->is(['A', 'B', 'C', 'Z']);
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
        $exported = var_export3($values, ['outmode' => 'eval']);
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
        $exported = var_export3($values, ['outmode' => 'eval']);
        that(serialize($values2 = eval($exported)))->isSame(serialize($values));
        $values2['recur1'][1] = 9;
        that($values2['recur1'][1])->is(9);
        that($values2['recur2'][1])->is(9);
    }

    function test_var_export3_generator()
    {
        $object = new Concrete('hoge');
        $values = [
            'byFunction'       => range1_9(),
            'byClosure'        => (static function () {
                yield 'c1';
                yield 'c2';
            })(),
            'byStaticMethod'   => Concrete::staticGenerate(),
            'byInstanceMethod' => $object->instanceGenerate(),
            'byClosureMethod'  => $object->closureGenerate()(),
        ];
        $exported = var_export3($values, ['outmode' => 'eval']);
        $values2 = eval($exported);
        that(iterator_to_array($values2['byFunction']))->is(range(1, 9));
        that(iterator_to_array($values2['byClosure']))->is(['c1', 'c2']);
        that(iterator_to_array($values2['byStaticMethod']))->is(['s1', 's2']);
        that(iterator_to_array($values2['byInstanceMethod']))->is(['i1', 'i2']);
        that(iterator_to_array($values2['byClosureMethod']))->is(['i1', 'i2']);
    }

    function test_var_export3_closure()
    {
        require __DIR__ . '/files/classes/namespace.php';

        function dummy_function($id)
        {
            return $id + 1;
        }

        define(__NAMESPACE__ . '\\DUMMY_CONST', 1);
        $object = new \DateTime('2014/12/24 12:34:56');
        $closures = [
            'object'    => $object,
            'simple'    => static function () { return 123; },
            'declare'   => static function (?Ex $e = null, $c = SR): Ex { return $e; },
            'alias'     => static function () { return [SR, Ex::class, gt(123)]; },
            'use'       => static function () use ($object) { return $object; },
            'resolve'   => static function () { return dummy_function(DUMMY_CONST); },
            'const'     => static function () { return [__NAMESPACE__, __DIR__, __FILE__]; },
            'arrow'     => static fn($format): string => $object->format($format),
            'bind'      => \Closure::bind(function () { return $this; }, $object),
            'method'    => \Closure::fromCallable([new class ( ) extends Caller { }, 'arrayize']),
            'internal1' => \Closure::fromCallable('strlen'),
            'internal2' => \Closure::fromCallable('Closure::fromCallable'),
            'internal3' => (new \ReflectionClass($object))->getMethod('format')->getClosure($object),
            'internal4' => (new \ReflectionClass($object))->getMethod('format')->getClosure(new \DateTime('2012/12/24 12:34:56')),
        ];
        $exported = var_export3($closures, ['outmode' => 'eval']);
        $closures = eval($exported);
        that($closures['simple']())->is(123);
        that($closures['declare'](new \Exception('yyy')))->is(new \Exception('yyy'));
        that($closures['alias']())->is([SR, Ex::class, 'integer']);
        that($closures['use']())->is($object);
        that($closures['resolve']())->is(2);
        that($closures['const']())->is([__NAMESPACE__, __DIR__, __FILE__]);
        that($closures['arrow']('Y-m-dTH:i:s'))->is('2014-12-24T12:34:56');
        that($closures['bind']())->is($object);
        that($closures['method'](1, 2, 3))->is([IS_OWNSELF, 1, 2, 3]);
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
        $exported = var_export3($closures, ['outmode' => 'eval']);
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
        $exported = var_export3($closure, ['outmode' => 'eval']);
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
        $exported = var_export3($fibonacci, ['outmode' => 'eval']);
        that($exported)->contains('static $memo = [];');
        $fibonacci2 = eval($exported);
        that($fibonacci2(10))->is(55);
    }

    function test_var_export3_misc()
    {
        that(var_export3([1, 2, 3], ['outmode' => 'file', 'return' => true]))->stringStartsWith('<?php return (function () {');
        that(var_export3([1, 2, 3], ['outmode' => 'eval', 'return' => true]))->stringStartsWith('return (function () {');
        that(var_export3([1, 2, 3], ['format' => 'minify', 'return' => true]))->notContains("\n");

        $generator = (function ($a) { yield $a; })(1);
        that(self::resolveFunction('var_export3'))($generator)->wasThrown('is not support');

        that(self::resolveFunction('var_export3'))->fn([1, 2, 3])->outputMatches('#newInstanceWithoutConstructor#');
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
        $exported = var_export3($objects, ['outmode' => 'eval']);
        $objects2 = eval($exported);
        that($objects2['sleepwakeup']->getPdo())->isInstanceOf(\PDO::class);
        that($objects2['concreate']->getPrivate())->is('Changed/Concrete');

        that(serialize($objects2))->isSame(serialize(unserialize(serialize($objects))));
    }

    function test_var_export3_enum()
    {
        $values = [
            'int-enum'    => IntEnum::Case1(),
            'string-enum' => StringEnum::CaseHoge(),
        ];
        $exported = var_export3($values, ['outmode' => 'eval']);
        $values2 = eval($exported);

        that($values2['int-enum'])->isSame(IntEnum::Case1());
        that($values2['string-enum'])->isSame(StringEnum::CaseHoge());
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
        $exported = var_export3($values, ['outmode' => 'eval']);
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

    function test_var_export3_weak()
    {
        $object1 = new \stdClass();
        $object2 = new \stdClass();
        $object3 = new \stdClass();

        $reference1 = \WeakReference::create($object1);
        $reference2 = \WeakReference::create($object2);
        $reference3 = \WeakReference::create($object3);

        $weakmap = new \WeakMap();
        $weakmap[$object1] = 1;
        $weakmap[$object2] = 2;
        $weakmap[$object3] = 3;

        unset($object3);
        $values = [
            $object1,
            'ref1' => $reference1,
            'ref2' => $reference2,
            'ref3' => $reference3,
            'map'  => $weakmap,
        ];
        $exported = var_export3($values, ['outmode' => 'eval']);
        $values2 = eval($exported);

        // 型は同じ
        that($values2['ref1'])->isInstanceOf(\WeakReference::class);
        that($values2['ref2'])->isInstanceOf(\WeakReference::class);
        that($values2['ref3'])->isInstanceOf(\WeakReference::class);
        that($values2['map'])->isInstanceOf(\WeakMap::class);

        // object1 は生き残っているし、エクスポート内にあるので復元できる
        that($values2['ref1']->get())->isObject();
        // object2 は生き残っているが、エクスポート内にないので復元できない
        that($values2['ref2']->get())->isNull();
        // object3 はそもそもエクスポート時点で参照が切れている
        that($values2['ref3']->get())->isNull();

        // 同上（object1 しか復元できない）
        that(iterator_to_array($values2['map'], false))->is([1]);
        // 変に復元されても困るので出力されていないこと自体を担保
        that($exported)->contains(' = 1;');
        that($exported)->contains(' = 2;');
        that($exported)->notContains(' = 3;');
    }

    function test_var_export3_resource()
    {
        $tmp = tempnam(sys_get_temp_dir(), 've3');
        $file = fopen($tmp, 'r+', false, stream_context_create(['file' => ['hoge' => 'HOGE']]));
        fwrite($file, 'Hello');

        $memory = fopen('php://memory', 'rw');
        fwrite($memory, 'Hello');
        fseek($memory, 2);

        $temp = fopen('php://temp/maxmemory:1024', 'rw');
        fwrite($temp, 'Hello');
        fseek($temp, 2);

        $values = [
            'file'   => $file,
            'memory' => $memory,
            'temp'   => $temp,
            'stdout' => STDOUT,
            'output' => fopen('php://output', 'w'),
        ];
        $exported = var_export3($values, ['outmode' => 'eval']);
        $values2 = eval($exported);

        that($values2['file'])->isResource();
        that($values2['memory'])->isResource();
        that($values2['temp'])->isResource();
        that($values2['stdout'])->isResource();
        that($values2['output'])->isResource();

        that(self::resolveFunction('var_export3'))(fopen(TESTWEBSERVER, 'r'))->wasThrown('stream resource');

        // that(stream_context_get_options($values2['file']))->is(['file' => ['hoge' => 'HOGE']]);
        that(ftell($values2['file']))->is(5);
        fwrite($values2['file'], 'World');
        that(file_get_contents($tmp))->is('HelloWorld');

        fwrite($values2['memory'], 'World');
        that(stream_get_contents($values2['memory'], null, 0))->is('HeWorld');

        fwrite($values2['temp'], 'World');
        that(stream_get_contents($values2['temp'], null, 0))->is('HeWorld');

        $this->expectOutputString('this is output string');
        fwrite($values2['output'], 'this is output string');
    }

    function test_var_hash()
    {
        that(var_hash([1, 2, 3], ['md5'], false))->isSame('262bbc0aa0dc62a93e350f1f7df792b9');
        that(var_hash([1, 2, 3], ['sha1'], false))->isSame('899a999da95e9f021fc63c6af006933fd4dc3aa1');
        that(var_hash([1, 2, 3], ['md5', 'sha1'], false))->isSame('262bbc0aa0dc62a93e350f1f7df792b9899a999da95e9f021fc63c6af006933fd4dc3aa1');
        that(var_hash([1, 2, 3], ['md5', 'sha1'], true))->isSame('Jiu8CqDcYqk-NQ8fffeSuYmamZ2pXp8CH8Y8avAGkz_U3Dqh');
        that(var_hash([1, 2, 3], ['md5', 'sha1'], null))->stringLengthEquals(36);
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
        that(self::resolveFunction('var_html'))->fn($value)->outputMatches('#<pre class=\'var_html\'>#');
    }

    function test_var_pretty()
    {
        that(self::resolveFunction('var_pretty'))(null, ['context' => 'hoge'])->wasThrown('is not supported');

        $recur = ['a' => 'A'];
        $recur['r'] = &$recur;
        $closure = (fn() => $recur)->bindTo(new class ( ) { });
        $sclosure = static fn() => $recur;
        $value = [
            (object) [
                'A' => (object) [
                    'X' => new \stdClass(),
                ],
            ],
            'E'     => new \Concrete('hoge'),
            'A'     => ["str", 1, 2, 3, true, null],
            'H'     => ['a' => 'A', 'b' => 'B'],
            'C'     => $closure,
            'c1'    => [$sclosure, $sclosure],
            'g'     => [
                (function () {
                    yield 1 => 'scalar';
                    yield [1] => ['array'];
                    yield (object) ['a' => 'A'] => (object) ['p' => 'object'];
                    yield 'x';
                })(),
            ],
            'R'     => STDOUT,
            'empty' => [],
            'ex'    => $GLOBALS['exception'],
        ];
        that(var_pretty($value, [
            'context'      => 'plain',
            'return'       => true,
            'trace'        => 3,
            'table'        => false,
            'excludeclass' => [\Exception::class],
        ]))
            ->stringContains(__FILE__)
            ->stringContains("  0: stdClass#")
            ->stringContains("      X: stdClass#")
            ->stringContains("  E: Concrete#")
            ->stringContains("    info: \"this is __debugInfo\"")
            ->stringContains("  A: [\"str\", 1, 2, 3, true, null]")
            ->stringContains("class@anonymous")
            ->stringContains("    recur: {")
            ->stringContains("    Closure#")
            ->stringContains("    Generator#")
            ->stringContains('      yield 1 => "scalar"')
            ->stringContains('      yield [1] => ["array"]')
            ->stringContains('      yield stdClass#')
            ->stringContains('        p: "object"')
            ->stringContains('      (more yields)')
            ->stringContains("  R: Resource id #2 of type (stream)")
            ->stringContains("  empty: []")
            ->stringNotContains("trace: [");

        that(var_pretty([
            'list' => [str_repeat('s', 20), str_repeat('s', 20)],
            'hash' => ['a' => str_repeat('s', 20), 'b' => str_repeat('s', 20)],
        ], [
            'context'   => 'plain',
            'return'    => true,
            'maxcolumn' => 30,
        ]))
            ->stringContains('	  "ssss');

        that(var_pretty([
            'list' => range(1, 10),
            'hash' => array_combine(range(1, 10), range(1, 10)),
        ], [
            'context'  => 'plain',
            'return'   => true,
            'maxcount' => 5,
        ]))
            ->stringContains('  list: [1, 2, 3, 4, 5 (more 5 elements)],')
            ->stringContains('    (more 5 elements)');

        that(var_pretty([
            'list' => [[[[[[[[['Z']]]]]]]]],
            'hash' => ['a' => ['b' => ['c' => ['d' => ['e' => ['f' => ['g' => ['h' => ['i' => 'Z']]]]]]]]],
        ], [
            'context'  => 'plain',
            'return'   => true,
            'maxdepth' => 5,
        ]))
            ->stringContains('          (too deep),')
            ->stringContains('          d: (too deep),');

        that(var_pretty([
            'list1'  => [str_repeat('s', 10)],
            'list2'  => [str_repeat('s', 20), str_repeat('s', 20)],
            'list5'  => [str_repeat('s', 50)],
            'hash1'  => ['a' => str_repeat('s', 10), 'b' => str_repeat('s', 10)],
            'hash2'  => ['a' => str_repeat('d', 20), 'b' => str_repeat('d', 20)],
            'string' => str_repeat('s', 40),
        ], [
            'context'   => 'plain',
            'return'    => true,
            'maxlength' => 30,
        ]))
            ->stringContains('  list1: ["ssssssssss"],')
            ->stringContains('  list2: [...(too length)..., "ssssssssssssssssssss"],')
            ->stringContains('  list5: [...(too length)..., ],')
            ->stringContains('    ...(too length)...,')
            ->stringContains('    a: "ssssssssss",')
            ->stringNotContains('    a: "dddddddddd",')
            ->stringContains('  string: "ssssss...(too length)...ssssss",');

        that(var_pretty([
            'list' => [str_repeat('s', 20), str_repeat('s', 20)],
            'hash' => ['a' => str_repeat('s', 20), 'b' => str_repeat('s', 20)],
        ], [
            'context'       => 'plain',
            'return'        => true,
            'maxlistcolumn' => 30,
        ]))
            ->stringContains('    "ssssssssssssssssssss",')
            ->stringContains('    a: "ssssssssssssssssssss",');

        that(var_pretty([
            'arrays'  => [
                ['a' => 'A1', 'b' => 'B1', 'c' => 'C1', 'x' => ['y' => ['z' => 1]]],
                ['a' => 'A2', 'b' => 'B2', 'c' => 'C2', 'x' => ['y' => ['z' => 2]]],
                ['a' => 'A3', 'b' => 'B3', 'c' => 'C3', 'x' => ['y' => ['z' => 3]]],
            ],
            'objects' => [
                'h' => (object) ['a' => 'A1', 'b' => 'B1', 'c' => 'C1', 'x' => ['y' => ['z' => 1]]],
                'f' => (object) ['a' => 'A2', 'b' => 'B2', 'c' => 'C2', 'x' => ['y' => ['z' => 2]]],
                'p' => (object) ['a' => 'A3', 'b' => 'B3', 'c' => 'C3', 'x' => ['y' => ['z' => 3]]],
            ],
            'onerow'  => [
                ['a' => 'A1', 'b' => 'B1', 'c' => 'C1', 'x' => ['y' => ['z' => 1]]],
            ],
            'intkey'  => [
                ['A1', 'B1', 'C1'],
                ['A2', 'B2', 'C2'],
            ],
        ], [
            'context' => 'plain',
            'return'  => true,
            'table'   => true,
        ]))
            ->stringContains(<<<MD
              arrays: array[]
                |   # | a   | b   | c   | x         |
                | --: | --- | --- | --- | --------- |
                |   0 | A1  | B1  | C1  | {         |
                |     |     |     |     |   y: {    |
                |     |     |     |     |     z: 1, |
                |     |     |     |     |   },      |
                |     |     |     |     | }         |
                |   1 | A2  | B2  | C2  | {         |
                |     |     |     |     |   y: {    |
                |     |     |     |     |     z: 2, |
                |     |     |     |     |   },      |
                |     |     |     |     | }         |
                |   2 | A3  | B3  | C3  | {         |
                |     |     |     |     |   y: {    |
                |     |     |     |     |     z: 3, |
                |     |     |     |     |   },      |
                |     |     |     |     | }         |
            MD,)
            ->stringContains(<<<MD
              objects: stdClass[]
                | #   | a   | b   | c   | x         |
                | --- | --- | --- | --- | --------- |
                | h   | A1  | B1  | C1  | {         |
                |     |     |     |     |   y: {    |
                |     |     |     |     |     z: 1, |
                |     |     |     |     |   },      |
                |     |     |     |     | }         |
                | f   | A2  | B2  | C2  | {         |
                |     |     |     |     |   y: {    |
                |     |     |     |     |     z: 2, |
                |     |     |     |     |   },      |
                |     |     |     |     | }         |
                | p   | A3  | B3  | C3  | {         |
                |     |     |     |     |   y: {    |
                |     |     |     |     |     z: 3, |
                |     |     |     |     |   },      |
                |     |     |     |     | }         |
            MD,)
            ->stringContains(<<<MD
              onerow: [
                {
                  a: "A1",
                  b: "B1",
                  c: "C1",
                  x: {
                    y: {
                      z: 1,
                    },
                  },
                },
              ],
            MD,)
            ->stringContains(<<<MD
              intkey: [
                ["A1", "B1", "C1"],
                ["A2", "B2", "C2"],
              ],
            MD,);

        that(var_pretty([
            'arrays'  => [
                ['a' => 'A1', 'b' => 'B1', 'c' => 'C1', 'x' => ['y' => ['z' => 1]]],
                ['a' => 'A2', 'b' => 'B2', 'c' => 'C2', 'x' => ['y' => ['z' => 2]]],
                ['a' => 'A3', 'b' => 'B3', 'c' => 'C3', 'x' => ['y' => ['z' => 3]]],
            ],
            'objects' => [
                'h' => (object) ['a' => 'A1', 'b' => 'B1', 'c' => 'C1', 'x' => ['y' => ['z' => 1]]],
                'f' => (object) ['a' => 'A2', 'b' => 'B2', 'c' => 'C2', 'x' => ['y' => ['z' => 2]]],
                'p' => (object) ['a' => 'A3', 'b' => 'B3', 'c' => 'C3', 'x' => ['y' => ['z' => 3]]],
            ],
        ], [
            'context' => 'plain',
            'return'  => true,
            'table'   => fn($v) => var_export($v, true),
        ]))
            ->stringContains(<<<MD
              arrays: array[]
            array (
              0 => 
              array (
                'a' => 'A1',
                'b' => 'B1',
                'c' => 'C1',
                'x' => 
                array (
                  'y' => 
                  array (
                    'z' => 1,
                  ),
                ),
              ),
              1 => 
              array (
                'a' => 'A2',
                'b' => 'B2',
                'c' => 'C2',
                'x' => 
                array (
                  'y' => 
                  array (
                    'z' => 2,
                  ),
                ),
              ),
              2 => 
              array (
                'a' => 'A3',
                'b' => 'B3',
                'c' => 'C3',
                'x' => 
                array (
                  'y' => 
                  array (
                    'z' => 3,
                  ),
                ),
              ),
            )  ,
            MD,)
            ->stringContains(<<<MD
              objects: stdClass[]
            array (
              'h' => 
              array (
                'a' => 'A1',
                'b' => 'B1',
                'c' => 'C1',
                'x' => 
                array (
                  'y' => 
                  array (
                    'z' => 1,
                  ),
                ),
              ),
              'f' => 
              array (
                'a' => 'A2',
                'b' => 'B2',
                'c' => 'C2',
                'x' => 
                array (
                  'y' => 
                  array (
                    'z' => 2,
                  ),
                ),
              ),
              'p' => 
              array (
                'a' => 'A3',
                'b' => 'B3',
                'c' => 'C3',
                'x' => 
                array (
                  'y' => 
                  array (
                    'z' => 3,
                  ),
                ),
              ),
            )  ,
            MD,);

        that(var_pretty($value, [
            'context' => 'plain',
            'return'  => true,
            'limit'   => 60,
        ]))
            ->stringContains("      X: (...omitted)");

        $ckeys = [];
        that(var_pretty($value, [
            'context'  => 'plain',
            'return'   => true,
            'callback' => function (&$string, $var, $nest, $keys) use (&$ckeys) {
                if (array_slice($keys, 0, 2) === ["ex", "trace"]) {
                    return;
                }
                $ckeys[] = $keys;
                if (is_resource($var)) {
                    $string = "this is custom resource($nest)";
                }
            },
        ]))
            ->stringContains("R: this is custom resource(1)");
        that($ckeys)->is([
            [0, "A", "X"],
            [0, "A"],
            [0],
            ["E", "privateField"],
            ["E", "proptectedField"],
            ["E", "name"],
            ["E", "value"],
            ["E", "info"],
            ["E"],
            ["A", 0],
            ["A", 1],
            ["A", 2],
            ["A", 3],
            ["A", 4],
            ["A", 5],
            ["A"],
            ["H", "a"],
            ["H", "b"],
            ["H"],
            ["C", "recur", "a"],
            ["C", "recur", "r"],
            ["C", "recur"],
            ["C"],
            ["c1"],
            ["g", 0, 2],
            ["g", 0],
            ["g"],
            ["R"],
            ["empty"],
            ["ex", "message"],
            ["ex", "code"],
            ["ex", "file"],
            ["ex", "line"],
            ["ex", "string"],
            ["ex", "previous"],
            ["ex"],
            [],
        ], null, true);

        that(var_pretty($value, [
            'context' => 'plain',
            'return'  => true,
            'minify'  => true,
        ]))
            ->stringNotContains("\n")
            ->stringNotContains("0:stdClass#")
            ->stringContains("E:Concrete#")
            ->stringContains("A:[\"str\", 1, 2, 3, true, null]")
            ->stringContains("R:Resource id #2 of type (stream)")
            ->stringContains("empty:[]");

        that(var_pretty($value, ['context' => 'cli', 'return' => true]))->stringContains("\033");
        that(var_pretty($value, ['context' => 'html', 'return' => true]))->stringContains("<span");

        that(self::resolveFunction('var_pretty'))->fn($value)->outputMatches('#Concrete#');
    }

    function test_var_type()
    {
        that(var_type(null))->is('null');
        that(var_type(true))->is('bool');
        that(var_type(123))->is('int');
        that(var_type(123.456))->is('float');
        that(var_type('hoge'))->is('string');
        that(var_type(STDIN))->is('resource');
        that(var_type(['array']))->is('array');
        that(var_type(new \stdClass()))->is('\\' . \stdClass::class);
        that(var_type(new \Concrete('hoge')))->is('\\' . \Concrete::class);

        that(var_type(new class extends \stdClass implements \JsonSerializable {
            public function jsonSerialize(): string { return ''; }
        }))->is('\stdClass');
        that(var_type(new class implements \JsonSerializable {
            public function jsonSerialize(): string { return ''; }
        }))->is('\JsonSerializable');
        that(var_type(new class extends \stdClass { }))->is('\stdClass');
        that(var_type(new class { }))->stringContains('anonymous');
    }

    function test_varcmp()
    {
        // strict
        that(varcmp(['b' => 'B', 'a' => 'A'], ['a' => 'A', 'b' => 'B'], SORT_STRICT))->lessThan(0); // 推移律が成り立ってない
        that(varcmp(['a' => 'A', 'b' => 'B'], ['b' => 'B', 'a' => 'A'], SORT_STRICT))->lessThan(0);
        that(varcmp(['a' => 'A', 'b' => 'B'], ['a' => 'A', 'b' => 'B'], SORT_STRICT))->is(0);

        // regular int
        that(varcmp(1, 0))->greaterThan(0);
        that(varcmp(0, 1))->lessThan(0);
        that(varcmp(0, 0))->is(0);
        that(varcmp(1, 1))->is(0);

        // regular float
        that(varcmp(1.1, 1))->greaterThan(0);
        that(varcmp(1, 1.1))->lessThan(0);
        that(varcmp(1.1, 1.1))->is(0);
        that(varcmp(0.1 + 0.2, 0.3, SORT_NUMERIC, 11))->isSame(0);

        // regular string
        that(varcmp('1.1', '1'))->greaterThan(0);
        that(varcmp('1', '1.1'))->lessThan(0);
        that(varcmp('1.1', '1.1'))->is(0);

        // string int
        that(varcmp('1', '0', SORT_NUMERIC))->greaterThan(0);
        that(varcmp('0', '1', SORT_NUMERIC))->lessThan(0);
        that(varcmp('0', '0', SORT_NUMERIC))->is(0);
        that(varcmp('1', '1', SORT_NUMERIC))->is(0);

        // string int(reverse)
        that(varcmp('1', '0', -SORT_NUMERIC))->lessThan(0);
        that(varcmp('0', '1', -SORT_NUMERIC))->greaterThan(0);
        that(varcmp('0', '0', -SORT_NUMERIC))->is(0);
        that(varcmp('1', '1', -SORT_NUMERIC))->is(0);

        // string float
        that(varcmp('1.1', '1', SORT_NUMERIC))->greaterThan(0);
        that(varcmp('1', '1.1', SORT_NUMERIC))->lessThan(0);
        that(varcmp('1.1', '1.1', SORT_NUMERIC))->is(0);

        // string
        that(varcmp('a', 'A', SORT_STRING))->greaterThan(0);
        that(varcmp('A', 'a', SORT_STRING))->lessThan(0);
        that(varcmp('abc', 'abc', SORT_STRING))->is(0);

        // string(icase)
        that(varcmp('A2', 'a1', SORT_STRING | SORT_FLAG_CASE))->greaterThan(0);
        that(varcmp('a1', 'A2', SORT_STRING | SORT_FLAG_CASE))->lessThan(0);
        that(varcmp('ABC', 'abc', SORT_STRING | SORT_FLAG_CASE))->is(0);

        // string natural
        that(varcmp('12', '2', SORT_NATURAL))->greaterThan(0);
        that(varcmp('2', '12', SORT_NATURAL))->lessThan(0);
        that(varcmp('0', '0', SORT_NATURAL))->is(0);

        // string natural(icase)
        that(varcmp('a12', 'A2', SORT_NATURAL | SORT_FLAG_CASE))->greaterThan(0);
        that(varcmp('A2', 'a12', SORT_NATURAL | SORT_FLAG_CASE))->lessThan(0);
        that(varcmp('ABC', 'abc', SORT_NATURAL | SORT_FLAG_CASE))->is(0);

        // string(SORT_FLAG_CASE only)
        that(varcmp('A2', 'a1', SORT_FLAG_CASE))->greaterThan(0);
        that(varcmp('a1', 'A2', SORT_FLAG_CASE))->lessThan(0);
        that(varcmp('ABC', 'abc', SORT_FLAG_CASE))->is(0);

        // string(transitive)
        $a = '1f1';
        $b = '1E1';
        $c = '9';
        that(varcmp($a, $b, SORT_FLAG_CASE))->greaterThan(0);
        that(varcmp($c, $a, SORT_FLAG_CASE))->greaterThan(0);
        that(varcmp($c, $b, SORT_FLAG_CASE))->greaterThan(0);

        // array
        $a = [1, 2, 3, 9];
        $b = [1, 2, 3, 0];
        $x = [1, 2, 3, 9];
        that(varcmp($a, $b))->greaterThan(0);
        that(varcmp($b, $a))->lessThan(0);
        that(varcmp($a, $x))->is(0);

        // object
        $a = (object) ['a' => 1, 'b' => 2, 'c' => 3, 'x' => 9];
        $b = (object) ['a' => 1, 'b' => 2, 'c' => 3, 'x' => 0];
        $x = (object) ['a' => 1, 'b' => 2, 'c' => 3, 'x' => 9];
        that(varcmp($a, $b))->greaterThan(0);
        that(varcmp($b, $a))->lessThan(0);
        that(varcmp($a, $x))->is(0);

        // DateTime
        $a = new \DateTime('2011/12/23 12:34:56');
        $b = new \DateTime('2010/12/23 12:34:56');
        $x = new \DateTime('2011/12/23 12:34:56');
        that(varcmp($a, $b))->greaterThan(0);
        that(varcmp($b, $a))->lessThan(0);
        that(varcmp($a, $x))->is(0);
    }
}
