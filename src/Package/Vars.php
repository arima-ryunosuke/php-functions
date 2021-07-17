<?php

namespace ryunosuke\Functions\Package;

/**
 * 変数関連のユーティリティ
 */
class Vars
{
    /** SI 接頭辞 */
    const SI_UNITS = [
        -8 => ['y'],           // ヨクト
        -7 => ['z'],           // ゼプト
        -6 => ['a'],           // アト
        -5 => ['f'],           // フェムト
        -4 => ['p'],           // ピコ
        -3 => ['n'],           // ナノ
        -2 => ['u', 'μ', 'µ'], // マイクロ（u で代用されることが多く、さらに μ は2つの文字体系がある）
        -1 => ['m'],           // ミリ
        0  => [],              // なし
        1  => ['k', 'K'],      // キロ（歴史的に k が使われるが、他の倍量は大文字なので K が使われることもある）
        2  => ['M'],           // メガ
        3  => ['G'],           // ギガ
        4  => ['T'],           // テラ
        5  => ['P'],           // ペタ
        6  => ['E'],           // エクサ
        7  => ['Z'],           // ゼタ
        8  => ['Y'],           // ヨタ
    ];

    /** SORT_XXX 定数の厳密版 */
    const SORT_STRICT = 256;

    /**
     * 値を何とかして文字列化する
     *
     * この関数の出力は互換性を考慮しない。頻繁に変更される可能性がある。
     *
     * @param mixed $var 文字列化する値
     * @return string $var を文字列化したもの
     */
    public static function stringify($var)
    {
        $type = gettype($var);
        switch ($type) {
            case 'NULL':
                return 'null';
            case 'boolean':
                return $var ? 'true' : 'false';
            case 'array':
                return (var_export2)($var, true);
            case 'object':
                if (method_exists($var, '__toString')) {
                    return (string) $var;
                }
                if ($var instanceof \Serializable) {
                    return serialize($var);
                }
                if ($var instanceof \JsonSerializable) {
                    return get_class($var) . ':' . json_encode($var, JSON_UNESCAPED_UNICODE);
                }
                return get_class($var);

            default:
                return (string) $var;
        }
    }

    /**
     * 値を何とかして数値化する
     *
     * - 配列は要素数
     * - int/float はそのまま（ただし $decimal に応じた型にキャストされる）
     * - resource はリソースID（php 標準の int キャスト）
     * - null/bool はその int 値（php 標準の int キャストだが $decimal を見る）
     * - それ以外（文字列・オブジェクト）は文字列表現から数値以外を取り除いたもの
     *
     * 文字列・オブジェクト以外の変換は互換性を考慮しない。頻繁に変更される可能性がある（特に配列）。
     *
     * -記号は受け入れるが+記号は受け入れない。
     *
     * Example:
     * ```php
     * // 配列は要素数となる
     * that(numberify([1, 2, 3]))->isSame(3);
     * // int/float は基本的にそのまま
     * that(numberify(123))->isSame(123);
     * that(numberify(123.45))->isSame(123);
     * that(numberify(123.45, true))->isSame(123.45);
     * // 文字列は数値抽出
     * that(numberify('a1b2c3'))->isSame(123);
     * that(numberify('a1b2.c3', true))->isSame(12.3);
     * ```
     *
     * @param mixed $var 対象の値
     * @param bool $decimal 小数として扱うか
     * @return int|float 数値化した値
     */
    public static function numberify($var, $decimal = false)
    {
        // resource はその int 値を返す
        if (is_resource($var)) {
            return (int) $var;
        }

        // 配列は要素数を返す・・・が、$decimal を見るので後段へフォールスルー
        if (is_array($var)) {
            $var = count($var);
        }
        // null/bool はその int 値を返す・・・が、$decimal を見るので後段へフォールスルー
        if ($var === null || $var === false || $var === true) {
            $var = (int) $var;
        }

        // int はそのまま返す・・・と言いたいところだが $decimal をみてキャストして返す
        if (is_int($var)) {
            if ($decimal) {
                $var = (float) $var;
            }
            return $var;
        }
        // float はそのまま返す・・・と言いたいところだが $decimal をみてキャストして返す
        if (is_float($var)) {
            if (!$decimal) {
                $var = (int) $var;
            }
            return $var;
        }

        // 上記以外は文字列として扱い、数値のみでフィルタする（__toString 未実装は標準に任せる。多分 fatal error）
        $number = preg_replace("#[^-.0-9]#u", '', $var);

        // 正規表現レベルでチェックもできそうだけど大変な匂いがするので is_numeric に日和る
        if (!is_numeric($number)) {
            throw new \UnexpectedValueException("$var to $number, this is not numeric.");
        }

        if ($decimal) {
            return (float) $number;
        }
        return (int) $number;
    }

    /**
     * 値を数値化する
     *
     * int か float ならそのまま返す。
     * 文字列の場合、一言で言えば「.を含むなら float、含まないなら int」を返す。
     * int でも float でも stringable でもない場合は実装依存（ただの int キャスト）。
     *
     * Example:
     * ```php
     * that(numval(3.14))->isSame(3.14);   // int や float はそのまま返す
     * that(numval('3.14'))->isSame(3.14); // . を含む文字列は float を返す
     * that(numval('11', 8))->isSame(9);   // 基数が指定できる
     * ```
     *
     * @param mixed $var 数値化する値
     * @param int $base 基数。int 的な値のときしか意味をなさない
     * @return int|float 数値化した値
     */
    public static function numval($var, $base = 10)
    {
        if (is_int($var) || is_float($var)) {
            return $var;
        }
        if (is_object($var)) {
            $var = (string) $var;
        }
        if (is_string($var) && strpos($var, '.') !== false) {
            return (float) $var;
        }
        return intval($var, $base);
    }

    /**
     * array キャストの関数版
     *
     * intval とか strval とかの array 版。
     * ただキャストするだけだが、関数なのでコールバックとして使える。
     *
     * $recursive を true にすると再帰的に適用する（デフォルト）。
     * 入れ子オブジェクトを配列化するときなどに使える。
     *
     * Example:
     * ```php
     * // キャストなので基本的には配列化される
     * that(arrayval(123))->isSame([123]);
     * that(arrayval('str'))->isSame(['str']);
     * that(arrayval([123]))->isSame([123]); // 配列は配列のまま
     *
     * // $recursive = false にしない限り再帰的に適用される
     * $stdclass = stdclass(['key' => 'val']);
     * that(arrayval([$stdclass], true))->isSame([['key' => 'val']]); // true なので中身も配列化される
     * that(arrayval([$stdclass], false))->isSame([$stdclass]);       // false なので中身は変わらない
     * ```
     *
     * @param mixed $var array 化する値
     * @param bool $recursive 再帰的に行うなら true
     * @return array array 化した配列
     */
    public static function arrayval($var, $recursive = true)
    {
        // return json_decode(json_encode($var), true);

        // 無駄なループを回したくないので非再帰で配列の場合はそのまま返す
        if (!$recursive && is_array($var)) {
            return $var;
        }

        if ((is_primitive)($var)) {
            return (array) $var;
        }

        $result = [];
        foreach ($var as $k => $v) {
            if ($recursive && !(is_primitive)($v)) {
                $v = (arrayval)($v, $recursive);
            }
            $result[$k] = $v;
        }
        return $result;
    }

    /**
     * 文字列を php の式として評価して値を返す
     *
     * 実質的には `eval("return $var;")` とほぼ同義。
     * ただ、 eval するまでもない式はそのまま返し、bare な文字列はそのまま文字列として返す（7.2 以前の未定義定数のような動作）。
     *
     * Example:
     * ```php
     * that(phpval('strtoupper($var)', ['var' => 'string']))->isSame('STRING');
     * that(phpval('bare string'))->isSame('bare string');
     * ```
     *
     * @param mixed $var 評価する式
     * @param array $contextvars eval される場合のローカル変数
     * @return mixed 評価した値
     */
    public static function phpval($var, $contextvars = [])
    {
        if (!is_string($var)) {
            return $var;
        }

        if (defined($var)) {
            return constant($var);
        }
        if (ctype_digit(ltrim($var, '+-'))) {
            return (int) $var;
        }
        if (is_numeric($var)) {
            return (double) $var;
        }

        set_error_handler(function () { });
        try {
            return (evaluate)("return $var;", $contextvars);
        }
        catch (\Throwable $t) {
            return $var;
        }
        finally {
            restore_error_handler();
        }
    }

    /**
     * 配列・ArrayAccess にキーがあるか調べる
     *
     * 配列が与えられた場合は array_key_exists と同じ。
     * ArrayAccess は一旦 isset で確認した後 null の場合は実際にアクセスして試みる。
     *
     * Example:
     * ```php
     * $array = [
     *     'k' => 'v',
     *     'n' => null,
     * ];
     * // 配列は array_key_exists と同じ
     * that(arrayable_key_exists('k', $array))->isTrue();  // もちろん存在する
     * that(arrayable_key_exists('n', $array))->isTrue();  // isset ではないので null も true
     * that(arrayable_key_exists('x', $array))->isFalse(); // 存在しないので false
     * that(isset($array['n']))->isFalse();                // isset だと null が false になる（参考）
     *
     * $object = new \ArrayObject($array);
     * // ArrayAccess は isset + 実際に取得を試みる
     * that(arrayable_key_exists('k', $object))->isTrue();  // もちろん存在する
     * that(arrayable_key_exists('n', $object))->isTrue();  // isset ではないので null も true
     * that(arrayable_key_exists('x', $object))->isFalse(); // 存在しないので false
     * that(isset($object['n']))->isFalse();                // isset だと null が false になる（参考）
     * ```
     *
     * @param string|int $key キー
     * @param array|\ArrayAccess $arrayable 調べる値
     * @return bool キーが存在するなら true
     */
    public static function arrayable_key_exists($key, $arrayable)
    {
        if (is_array($arrayable) || $arrayable instanceof \ArrayAccess) {
            return (attr_exists)($key, $arrayable);
        }

        throw new \InvalidArgumentException(sprintf('%s must be array or ArrayAccess (%s).', '$arrayable', (var_type)($arrayable)));
    }

    /**
     * 配列・オブジェクトを問わずキーやプロパティの存在を確認する
     *
     * 配列が与えられた場合は array_key_exists と同じ。
     * オブジェクトは一旦 isset で確認した後 null の場合は実際にアクセスして試みる。
     *
     * Example:
     * ```php
     * $array = [
     *     'k' => 'v',
     *     'n' => null,
     * ];
     * // 配列は array_key_exists と同じ
     * that(attr_exists('k', $array))->isTrue();  // もちろん存在する
     * that(attr_exists('n', $array))->isTrue();  // isset ではないので null も true
     * that(attr_exists('x', $array))->isFalse(); // 存在しないので false
     *
     * $object = (object) $array;
     * // オブジェクトでも使える
     * that(attr_exists('k', $object))->isTrue();  // もちろん存在する
     * that(attr_exists('n', $object))->isTrue();  // isset ではないので null も true
     * that(attr_exists('x', $object))->isFalse(); // 存在しないので false
     * ```
     *
     * @param int|string $key 調べるキー
     * @param array|object $value 調べられる配列・オブジェクト
     * @return bool $key が存在するなら true
     */
    public static function attr_exists($key, $value)
    {
        return (attr_get)($key, $value, $dummy = new \stdClass()) !== $dummy;
    }

    /**
     * 配列・オブジェクトを問わずキーやプロパティの値を取得する
     *
     * 配列が与えられた場合は array_key_exists でチェック。
     * オブジェクトは一旦 isset で確認した後 null の場合は実際にアクセスして取得する。
     *
     * Example:
     * ```php
     * $array = [
     *     'k' => 'v',
     *     'n' => null,
     * ];
     * that(attr_get('k', $array))->isSame('v');                  // もちろん存在する
     * that(attr_get('n', $array))->isSame(null);                 // isset ではないので null も true
     * that(attr_get('x', $array, 'default'))->isSame('default'); // 存在しないのでデフォルト値
     *
     * $object = (object) $array;
     * // オブジェクトでも使える
     * that(attr_get('k', $object))->isSame('v');                  // もちろん存在する
     * that(attr_get('n', $object))->isSame(null);                 // isset ではないので null も true
     * that(attr_get('x', $object, 'default'))->isSame('default'); // 存在しないのでデフォルト値
     * ```
     *
     * @param int|string $key 取得するキー
     * @param array|object $value 取得される配列・オブジェクト
     * @param mixed $default なかった場合のデフォルト値
     * @return mixed $key の値
     */
    public static function attr_get($key, $value, $default = null)
    {
        if (is_array($value)) {
            // see https://www.php.net/manual/function.array-key-exists.php#107786
            return isset($value[$key]) || array_key_exists($key, $value) ? $value[$key] : $default;
        }

        if ($value instanceof \ArrayAccess) {
            // あるならあるでよい
            if (isset($value[$key])) {
                return $value[$key];
            }
            // 問題は「ない場合」と「あるが null だった場合」の区別で、ArrayAccess の実装次第なので一元的に確定するのは不可能
            // ここでは「ない場合はなんらかのエラー・例外が出るはず」という前提で実際に値を取得して確認する
            try {
                error_clear_last();
                $result = @$value[$key];
                return error_get_last() ? $default : $result;
            }
            catch (\Throwable $t) {
                return $default;
            }
        }

        // 上記のプロパティ版
        if (is_object($value)) {
            try {
                if (isset($value->$key)) {
                    return $value->$key;
                }
                error_clear_last();
                $result = @$value->$key;
                return error_get_last() ? $default : $result;
            }
            catch (\Throwable $t) {
                return $default;
            }
        }

        throw new \InvalidArgumentException(sprintf('%s must be array or object (%s).', '$value', (var_type)($value)));
    }

    /**
     * 数値に SI 接頭辞を付与する
     *
     * 値は 1 <= $var < 1000(1024) の範囲内に収められる。
     * ヨクト（10^24）～ヨタ（1024）まで。整数だとしても 64bit の範囲を超えるような値の精度は保証しない。
     *
     * Example:
     * ```php
     * // シンプルに k をつける
     * that(si_prefix(12345))->isSame('12.345 k');
     * // シンプルに m をつける
     * that(si_prefix(0.012345))->isSame('12.345 m');
     * // 書式フォーマットを指定できる
     * that(si_prefix(12345, 1000, '%d%s'))->isSame('12k');
     * that(si_prefix(0.012345, 1000, '%d%s'))->isSame('12m');
     * // ファイルサイズを byte で表示する
     * that(si_prefix(12345, 1000, '%d %sbyte'))->isSame('12 kbyte');
     * // ファイルサイズを byte で表示する（1024）
     * that(si_prefix(10240, 1024, '%.3f %sbyte'))->isSame('10.000 kbyte');
     * // フォーマットに null を与えると sprintf せずに配列で返す
     * that(si_prefix(12345, 1000, null))->isSame([12.345, 'k']);
     * // フォーマットにクロージャを与えると実行して返す
     * that(si_prefix(12345, 1000, function ($v, $u) {
     *     return number_format($v, 2) . $u;
     * }))->isSame('12.35k');
     * ```
     *
     * @param mixed $var 丸める値
     * @param int $unit 桁単位。実用上は 1000, 1024 の2値しか指定することはないはず
     * @param string|\Closure $format 書式フォーマット。 null を与えると sprintf せずに配列で返す
     * @return string|array 丸めた数値と SI 接頭辞で sprintf した文字列（$format が null の場合は配列）
     */
    public static function si_prefix($var, $unit = 1000, $format = '%.3f %s')
    {
        assert($unit > 0);

        $result = function ($format, $var, $unit) {
            if ($format instanceof \Closure) {
                return $format($var, $unit);
            }
            if ($format === null) {
                return [$var, $unit];
            }
            return sprintf($format, $var, $unit);
        };

        if ($var == 0) {
            return $result($format, $var, '');
        }

        $original = $var;
        $var = abs($var);
        $n = 0;
        while (!(1 <= $var && $var < $unit)) {
            if ($var < 1) {
                $n--;
                $var *= $unit;
            }
            else {
                $n++;
                $var /= $unit;
            }
        }
        if (!isset(SI_UNITS[$n])) {
            throw new \InvalidArgumentException("$original is too large or small ($n).");
        }
        return $result($format, ($original > 0 ? 1 : -1) * $var, SI_UNITS[$n][0] ?? '');
    }

    /**
     * SI 接頭辞が付与された文字列を数値化する
     *
     * 典型的な用途は ini_get で得られた値を数値化したいとき。
     * ただし、 ini は 1m のように小文字で指定することもあるので大文字化する必要はある。
     *
     * Example:
     * ```php
     * // 1k = 1000
     * that(si_unprefix('1k'))->isSame(1000);
     * // 1k = 1024
     * that(si_unprefix('1k', 1024))->isSame(1024);
     * // m はメガではなくミリ
     * that(si_unprefix('1m'))->isSame(0.001);
     * // M がメガ
     * that(si_unprefix('1M'))->isSame(1000000);
     * // K だけは特別扱いで大文字小文字のどちらでもキロになる
     * that(si_unprefix('1K'))->isSame(1000);
     * ```
     *
     * @param mixed $var 数値化する値
     * @param int $unit 桁単位。実用上は 1000, 1024 の2値しか指定することはないはず
     * @return int|float SI 接頭辞を取り払った実際の数値
     */
    public static function si_unprefix($var, $unit = 1000)
    {
        assert($unit > 0);

        $var = trim($var);

        foreach (SI_UNITS as $exp => $sis) {
            foreach ($sis as $si) {
                if (strpos($var, $si) === (strlen($var) - strlen($si))) {
                    return (numval)($var) * pow($unit, $exp);
                }
            }
        }

        return (numval)($var);
    }

    /**
     * 値が空か検査する
     *
     * `empty` とほぼ同じ。ただし
     *
     * - string: "0"
     * - countable でない object
     * - countable である object で count() > 0
     *
     * は false 判定する。
     * ただし、 $empty_stcClass に true を指定すると「フィールドのない stdClass」も true を返すようになる。
     * これは stdClass の立ち位置はかなり特殊で「フィールドアクセスできる組み込み配列」のような扱いをされることが多いため。
     * （例えば `json_decode('{}')` は stdClass を返すが、このような状況は空判定したいことが多いだろう）。
     *
     * なお、関数の仕様上、未定義変数を true 判定することはできない。
     * 未定義変数をチェックしたい状況は大抵の場合コードが悪いが `$array['key1']['key2']` を調べたいことはある。
     * そういう時には使えない（?? する必要がある）。
     *
     * 「 `if ($var) {}` で十分なんだけど "0" が…」という状況はまれによくあるはず。
     *
     * Example:
     * ```php
     * // この辺は empty と全く同じ
     * that(is_empty(null))->isTrue();
     * that(is_empty(false))->isTrue();
     * that(is_empty(0))->isTrue();
     * that(is_empty(''))->isTrue();
     * // この辺だけが異なる
     * that(is_empty('0'))->isFalse();
     * // 第2引数に true を渡すと空の stdClass も empty 判定される
     * $stdclass = new \stdClass();
     * that(is_empty($stdclass, true))->isTrue();
     * // フィールドがあれば empty ではない
     * $stdclass->hoge = 123;
     * that(is_empty($stdclass, true))->isFalse();
     * ```
     *
     * @param mixed $var 判定する値
     * @param bool $empty_stdClass 空の stdClass を空とみなすか
     * @return bool 空なら true
     */
    public static function is_empty($var, $empty_stdClass = false)
    {
        // object は is_countable 次第
        if (is_object($var)) {
            // が、 stdClass だけは特別扱い（stdClass は継承もできるので、クラス名で判定する（継承していたらそれはもう stdClass ではないと思う））
            if ($empty_stdClass && get_class($var) === 'stdClass') {
                return !(array) $var;
            }
            if ((is_countable)($var)) {
                return !count($var);
            }
            return false;
        }

        // "0" は false
        if ($var === '0') {
            return false;
        }

        // 上記以外は empty に任せる
        return empty($var);
    }

    /**
     * 値が複合型でないか検査する
     *
     * 「複合型」とはオブジェクトと配列のこと。
     * つまり
     *
     * - is_scalar($var) || is_null($var) || is_resource($var)
     *
     * と同義（!is_array($var) && !is_object($var) とも言える）。
     *
     * Example:
     * ```php
     * that(is_primitive(null))->isTrue();
     * that(is_primitive(false))->isTrue();
     * that(is_primitive(123))->isTrue();
     * that(is_primitive(STDIN))->isTrue();
     * that(is_primitive(new \stdClass))->isFalse();
     * that(is_primitive(['array']))->isFalse();
     * ```
     *
     * @param mixed $var 調べる値
     * @return bool 複合型なら false
     */
    public static function is_primitive($var)
    {
        return is_scalar($var) || is_null($var) || is_resource($var);
    }

    /**
     * 変数が再帰参照を含むか調べる
     *
     * Example:
     * ```php
     * // 配列の再帰
     * $array = [];
     * $array['recursive'] = &$array;
     * that(is_recursive($array))->isTrue();
     * // オブジェクトの再帰
     * $object = new \stdClass();
     * $object->recursive = $object;
     * that(is_recursive($object))->isTrue();
     * ```
     *
     * @param mixed $var 調べる値
     * @return bool 再帰参照を含むなら true
     */
    public static function is_recursive($var)
    {
        $core = function ($var, $parents) use (&$core) {
            // 複合型でないなら間違いなく false
            if ((is_primitive)($var)) {
                return false;
            }

            // 「親と同じ子」は再帰以外あり得ない。よって === で良い（オブジェクトに関してはそもそも等値比較で絶対に一致しない）
            // sql_object_hash とか serialize でキーに保持して isset の方が速いか？
            // → ベンチ取ったところ in_array の方が10倍くらい速い。多分生成コストに起因
            // raw な比較であれば瞬時に比較できるが、isset だと文字列化が必要でかなり無駄が生じていると考えられる
            foreach ($parents as $parent) {
                if ($parent === $var) {
                    return true;
                }
            }

            // 全要素を再帰的にチェック
            $parents[] = $var;
            foreach ($var as $v) {
                if ($core($v, $parents)) {
                    return true;
                }
            }
            return false;
        };
        return $core($var, []);
    }

    /**
     * 変数が文字列化できるか調べる
     *
     * 「配列」「__toString を持たないオブジェクト」が false になる。
     * （厳密に言えば配列は "Array" になるので文字列化できるといえるがここでは考えない）。
     *
     * Example:
     * ```php
     * // こいつらは true
     * that(is_stringable(null))->isTrue();
     * that(is_stringable(true))->isTrue();
     * that(is_stringable(3.14))->isTrue();
     * that(is_stringable(STDOUT))->isTrue();
     * that(is_stringable(new \Exception()))->isTrue();
     * // こいつらは false
     * that(is_stringable(new \ArrayObject()))->isFalse();
     * that(is_stringable([1, 2, 3]))->isFalse();
     * ```
     *
     * @param mixed $var 調べる値
     * @return bool 文字列化できるなら true
     */
    public static function is_stringable($var)
    {
        if (is_array($var)) {
            return false;
        }
        if (is_object($var) && !method_exists($var, '__toString')) {
            return false;
        }
        return true;
    }

    /**
     * 変数が配列アクセス可能か調べる
     *
     * Example:
     * ```php
     * that(is_arrayable([]))->isTrue();
     * that(is_arrayable(new \ArrayObject()))->isTrue();
     * that(is_arrayable(new \stdClass()))->isFalse();
     * ```
     *
     * @param array|object $var 調べる値
     * @return bool 配列アクセス可能なら true
     */
    public static function is_arrayable($var)
    {
        return is_array($var) || $var instanceof \ArrayAccess;
    }

    /**
     * 変数が count でカウントできるか調べる
     *
     * 要するに {@link http://php.net/manual/function.is-countable.php is_countable} の polyfill。
     *
     * Example:
     * ```php
     * that(is_countable([1, 2, 3]))->isTrue();
     * that(is_countable(new \ArrayObject()))->isTrue();
     * that(is_countable((function () { yield 1; })()))->isFalse();
     * that(is_countable(1))->isFalse();
     * that(is_countable(new \stdClass()))->isFalse();
     * ```
     *
     * @polyfill
     *
     * @param mixed $var 調べる値
     * @return bool count でカウントできるなら true
     */
    public static function is_countable($var)
    {
        return is_array($var) || $var instanceof \Countable;
    }

    /**
     * 指定されたパスワードとアルゴリズムで暗号化する
     *
     * データは json を経由して base64（URL セーフ） して返す。
     * $tag を与えると認証タグが設定される。
     *
     * Example:
     * ```php
     * $plaindata = ['a', 'b', 'c'];
     * $encrypted = encrypt($plaindata, 'password');
     * $decrypted = decrypt($encrypted, 'password');
     * // 暗号化されて base64 の文字列になる
     * that($encrypted)->isString();
     * // 復号化されて元の配列になる
     * that($decrypted)->isSame(['a', 'b', 'c']);
     * // password が異なれば失敗して null を返す
     * that(decrypt($encrypted, 'invalid'))->isSame(null);
     *
     * $encrypted = encrypt($plaindata, 'password', 'aes-256-gcm', $tag);
     * // タグが設定される
     * that($tag)->isString();
     * // タグが正しければ復号化されて元の配列になる
     * that(decrypt($encrypted, 'password', 'aes-256-gcm', $tag))->isSame(['a', 'b', 'c']);
     * // タグが不正なら失敗して null を返す
     * that(decrypt($encrypted, 'password', 'aes-256-gcm', 'invalid'))->isSame(null);
     * ```
     *
     * @param mixed $plaindata 暗号化するデータ
     * @param string $password パスワード
     * @param string $cipher 暗号化方式（openssl_get_cipher_methods で得られるもの）
     * @param string $tag 認証タグ
     * @return string 暗号化された文字列
     */
    public static function encrypt($plaindata, $password, $cipher = 'aes-256-cbc', &$tag = '')
    {
        $jsondata = json_encode($plaindata, JSON_UNESCAPED_UNICODE);

        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = $ivlen ? random_bytes($ivlen) : '';
        $payload = openssl_encrypt($jsondata, $cipher, $password, OPENSSL_RAW_DATA, $iv, ...func_num_args() < 4 ? [] : [&$tag]);

        return rtrim(strtr(base64_encode($iv . $payload), ['+' => '-', '/' => '_']), '=');
    }

    /**
     * 指定されたパスワードとアルゴリズムで復号化する
     *
     * $cipher は配列で複数与えることができる。
     * 複数与えた場合、順に試みて複合できた段階でその値を返す。
     *
     * 復号に失敗すると null を返す。
     * 単体で使うことはないと思うので詳細は encrypt を参照。
     *
     * @param string $cipherdata 復号化するデータ
     * @param string $password パスワード
     * @param string|array $cipher 暗号化方式（openssl_get_cipher_methods で得られるもの）
     * @param string $tag 認証タグ
     * @return mixed 復号化されたデータ
     */
    public static function decrypt($cipherdata, $password, $cipher = 'aes-256-cbc', $tag = '')
    {
        $cipherdata = base64_decode(strtr($cipherdata, ['-' => '+', '_' => '/']));

        foreach ((array) $cipher as $c) {
            $ivlen = openssl_cipher_iv_length($c);
            if (strlen($cipherdata) <= $ivlen) {
                continue;
            }
            $iv = substr($cipherdata, 0, $ivlen);
            $payload = substr($cipherdata, $ivlen);

            $jsondata = openssl_decrypt($payload, $c, $password, OPENSSL_RAW_DATA, $iv, $tag);
            if ($jsondata !== false) {
                return json_decode($jsondata, true);
            }
        }
        return null;
    }

    /**
     * php7 の `<=>` の関数版
     *
     * 引数で大文字小文字とか自然順とか型モードとかが指定できる。
     * さらに追加で SORT_STRICT という厳密比較フラグを渡すことができる。
     *
     * Example:
     * ```php
     * // 'a' と 'z' なら 'z' の方が大きい
     * that(varcmp('z', 'a') > 0)->isTrue();
     * that(varcmp('a', 'z') < 0)->isTrue();
     * that(varcmp('a', 'a') === 0)->isTrue();
     *
     * // 'a' と 'Z' なら 'a' の方が大きい…が SORT_FLAG_CASE なので 'Z' のほうが大きい
     * that(varcmp('Z', 'a', SORT_FLAG_CASE) > 0)->isTrue();
     * that(varcmp('a', 'Z', SORT_FLAG_CASE) < 0)->isTrue();
     * that(varcmp('a', 'A', SORT_FLAG_CASE) === 0)->isTrue();
     *
     * // '2' と '12' なら '2' の方が大きい…が SORT_NATURAL なので '12' のほうが大きい
     * that(varcmp('12', '2', SORT_NATURAL) > 0)->isTrue();
     * that(varcmp('2', '12', SORT_NATURAL) < 0)->isTrue();
     *
     * // SORT_STRICT 定数が使える（下記はすべて宇宙船演算子を使うと 0 になる）
     * that(varcmp(['a' => 'A', 'b' => 'B'], ['b' => 'B', 'a' => 'A'], SORT_STRICT) < 0)->isTrue();
     * that(varcmp((object) ['a'], (object) ['a'], SORT_STRICT) < 0)->isTrue();
     * ```
     *
     * @param mixed $a 比較する値1
     * @param mixed $b 比較する値2
     * @param ?int $mode 比較モード（SORT_XXX）。省略すると型でよしなに選択
     * @param ?int $precision 小数比較の際の誤差桁
     * @return int 等しいなら 0、 $a のほうが大きいなら > 0、 $bのほうが大きいなら < 0
     */
    public static function varcmp($a, $b, $mode = null, $precision = null)
    {
        // 負数は逆順とみなす
        $reverse = 1;
        if ($mode < 0) {
            $reverse = -1;
            $mode = -$mode;
        }

        // null が来たらよしなにする（なるべく型に寄せるが SORT_REGULAR はキモいので避ける）
        if ($mode === null || $mode === SORT_FLAG_CASE) {
            if ((is_int($a) || is_float($a)) && (is_int($b) || is_float($b))) {
                $mode = SORT_NUMERIC;
            }
            elseif (is_string($a) && is_string($b)) {
                $mode = SORT_STRING | $mode; // SORT_FLAG_CASE が単品で来てるかもしれないので混ぜる
            }
        }

        $flag_case = $mode & SORT_FLAG_CASE;
        $mode = $mode & ~SORT_FLAG_CASE;

        if ($mode === SORT_NUMERIC) {
            $delta = $a - $b;
            if ($precision > 0 && abs($delta) < pow(10, -$precision)) {
                return 0;
            }
            return $reverse * (0 < $delta ? 1 : ($delta < 0 ? -1 : 0));
        }
        if ($mode === SORT_STRING) {
            if ($flag_case) {
                return $reverse * strcasecmp($a, $b);
            }
            return $reverse * strcmp($a, $b);
        }
        if ($mode === SORT_NATURAL) {
            if ($flag_case) {
                return $reverse * strnatcasecmp($a, $b);
            }
            return $reverse * strnatcmp($a, $b);
        }
        if ($mode === SORT_STRICT) {
            return $reverse * ($a === $b ? 0 : ($a > $b ? 1 : -1));
        }

        // for SORT_REGULAR
        return $reverse * ($a == $b ? 0 : ($a > $b ? 1 : -1));
    }

    /**
     * 値の型を取得する（gettype + get_class）
     *
     * プリミティブ型（gettype で得られるやつ）はそのまま、オブジェクトのときのみクラス名を返す。
     * ただし、オブジェクトの場合は先頭に '\\' が必ず付く。
     * また、 $valid_name を true にするとタイプヒントとして正当な名前を返す（integer -> int, double -> float など）。
     * 互換性のためデフォルト false になっているが、将来的にこの引数は削除されるかデフォルト true に変更される。
     *
     * 無名クラスの場合は extends, implements の優先順位でその名前を使う。
     * 継承も実装もされていない場合は標準の get_class の結果を返す。
     *
     * Example:
     * ```php
     * // プリミティブ型は gettype と同義
     * that(var_type(false))->isSame('boolean');
     * that(var_type(123))->isSame('integer');
     * that(var_type(3.14))->isSame('double');
     * that(var_type([1, 2, 3]))->isSame('array');
     * // オブジェクトは型名を返す
     * that(var_type(new \stdClass))->isSame('\\stdClass');
     * that(var_type(new \Exception()))->isSame('\\Exception');
     * // 無名クラスは継承元の型名を返す（インターフェース実装だけのときはインターフェース名）
     * that(var_type(new class extends \Exception{}))->isSame('\\Exception');
     * that(var_type(new class implements \JsonSerializable{
     *     public function jsonSerialize() { return ''; }
     * }))->isSame('\\JsonSerializable');
     * ```
     *
     * @param mixed $var 型を取得する値
     * @param bool $valid_name タイプヒントとして有効な名前を返すか
     * @return string 型名
     */
    public static function var_type($var, $valid_name = false)
    {
        if (is_object($var)) {
            $ref = new \ReflectionObject($var);
            if ($ref->isAnonymous()) {
                if ($pc = $ref->getParentClass()) {
                    return '\\' . $pc->name;
                }
                if ($is = $ref->getInterfaceNames()) {
                    return '\\' . reset($is);
                }
            }
            return '\\' . get_class($var);
        }
        $type = gettype($var);
        if (!$valid_name) {
            return $type;
        }
        switch ($type) {
            default:
                return $type;
            case 'NULL':
                return 'null';
            case 'boolean':
                return 'bool';
            case 'integer':
                return 'int';
            case 'double':
                return 'float';
        }
    }

    /**
     * 値にコールバックを適用する
     *
     * 普通のスカラー値であれば `$callback($var)` と全く同じ。
     * この関数は「$var が配列だったら中身に適用して返す（再帰）」という点で上記とは異なる。
     *
     * 「配列が与えられたら要素に適用して配列で返す、配列じゃないなら直に適用してそれを返す」という状況はまれによくあるはず。
     *
     * Example:
     * ```php
     * // 素の値は素の呼び出しと同じ
     * that(var_apply(' x ', 'trim'))->isSame('x');
     * // 配列は中身に適用して配列で返す（再帰）
     * that(var_apply([' x ', ' y ', [' z ']], 'trim'))->isSame(['x', 'y', ['z']]);
     * // 第3引数以降は残り引数を意味する
     * that(var_apply(['!x!', '!y!'], 'trim', '!'))->isSame(['x', 'y']);
     * // 「まれによくある」の具体例
     * that(var_apply(['<x>', ['<y>']], 'htmlspecialchars', ENT_QUOTES, 'utf-8'))->isSame(['&lt;x&gt;', ['&lt;y&gt;']]);
     * ```
     *
     * @param mixed $var $callback を適用する値
     * @param callable $callback 値変換コールバック
     * @param mixed ...$args $callback の残り引数（可変引数）
     * @return mixed|array $callback が適用された値。元が配列なら配列で返す
     */
    public static function var_apply($var, $callback, ...$args)
    {
        $iterable = is_iterable($var);
        if ($iterable) {
            $result = [];
            foreach ($var as $k => $v) {
                $result[$k] = (var_apply)($v, $callback, ...$args);
            }
            return $result;
        }

        return $callback($var, ...$args);
    }

    /**
     * 配列にコールバックを適用する
     *
     * 配列であれば `$callback($var)` と全く同じ。
     * この関数は「$var がスカラー値だったら配列化して適用してスカラーで返す」という点で上記とは異なる。
     *
     * 「配列を受け取って配列を返す関数があるが、手元にスカラー値しか無い」という状況はまれによくあるはず。
     *
     * Example:
     * ```php
     * // 配列を受け取って中身を大文字化して返すクロージャ
     * $upper = function($array){return array_map('strtoupper', $array);};
     * // 普通はこうやって使うが・・・
     * that($upper(['a', 'b', 'c']))->isSame(['A', 'B', 'C']);
     * // 手元に配列ではなくスカラー値しか無いときはこうせざるをえない
     * that($upper(['a'])[0])->isSame('A');
     * // var_applys を使うと配列でもスカラーでも統一的に記述することができる
     * that(var_applys(['a', 'b', 'c'], $upper))->isSame(['A', 'B', 'C']);
     * that(var_applys('a', $upper))->isSame('A');
     * # 要するに「大文字化したい」だけなわけだが、$upper が配列を前提としているので、「大文字化」部分を得るには配列化しなければならなくなっている
     * # 「strtoupper だけ切り出せばよいのでは？」と思うかもしれないが、「（外部ライブラリなどで）手元に配列しか受け取ってくれない処理しかない」状況がまれによくある
     * ```
     *
     * @param mixed $var $callback を適用する値
     * @param callable $callback 値変換コールバック
     * @param mixed ...$args $callback の残り引数（可変引数）
     * @return mixed|array $callback が適用された値。元が配列なら配列で返す
     */
    public static function var_applys($var, $callback, ...$args)
    {
        $iterable = is_iterable($var);
        if (!$iterable) {
            $var = [$var];
        }
        $var = $callback($var, ...$args);
        return $iterable ? $var : $var[0];
    }

    /**
     * 変数をリソースのように扱えるファイルポインタを返す
     *
     * 得られたファイルポインタに fread すれば変数の値が見えるし、 fwrite すれば変数の値が書き換わる。
     * 逆に変数を書き換えればファイルポインタで得られる値も書き換わる。
     *
     * 用途は主にテスト用。
     * 例えば「何らかのファイルポインタを要求する処理」に対して fopen や tmpfile を駆使して値の確認をするのは結構めんどくさい。
     * （`rewind` したり `stream_get_contents` したり削除したりする必要がある）。
     * それよりもこの関数で得られたファイルポインタを渡し、 `that($var)->is($expected)` とできる方がテストの視認性が良くなる。
     *
     * Example:
     * ```php
     * // $var のファイルポインタを取得
     * $fp = var_stream($var);
     * // ファイルポインタに書き込みを行うと変数にも反映される
     * fwrite($fp, 'hoge');
     * that($var)->is('hoge');
     * // 変数に追記を行うとファイルポインタで読み取れる
     * $var .= 'fuga';
     * that(fread($fp, 1024))->is('fuga');
     * // 変数をまるっと置換するとファイルポインタ側もまるっと変わる
     * $var = 'hello, world';
     * that(stream_get_contents($fp, -1, 0))->is('hello, world');
     * // ファイルポインタをゴリっと削除すると変数も空になる
     * ftruncate($fp, 0);
     * that($var)->is('');
     * ```
     *
     * @param string|null $var 対象の変数
     * @param string $initial 初期値。与えたときのみ初期化される
     * @return resource 変数のファイルポインタ
     */
    public static function var_stream(&$var, $initial = '')
    {
        static $STREAM_NAME, $stream_class, $registered = false;
        if (!$registered) {
            $STREAM_NAME = $STREAM_NAME ?: get_cfg_var('rfunc.var_stream') ?: 'VarStreamV010000';
            if (in_array($STREAM_NAME, stream_get_wrappers())) {
                throw new \DomainException("$STREAM_NAME is registered already.");
            }

            $registered = true;
            stream_wrapper_register($STREAM_NAME, $stream_class = get_class(new class() {
                private static $ids     = 0;
                private static $entries = [];

                private $id;
                private $entry;
                private $position;

                public static function create(string &$var): int
                {
                    self::$entries[++self::$ids] = &$var;
                    return self::$ids;
                }

                public function stream_open(string $path, string $mode, int $options, &$opened_path): bool
                {
                    assert([$mode, $options, &$opened_path]);
                    $this->id = parse_url($path, PHP_URL_HOST);
                    $this->entry = &self::$entries[$this->id];
                    $this->position = 0;

                    return true;
                }

                public function stream_close()
                {
                    unset(self::$entries[$this->id]);
                }

                public function stream_lock(int $operation): bool
                {
                    assert(is_int($operation));
                    // 競合しないので常に true を返す
                    return true;
                }

                public function stream_flush(): bool
                {
                    // バッファしないので常に true を返す
                    return true;
                }

                public function stream_eof(): bool
                {
                    // 変数の書き換えを検知する術はないので eof は殺しておく
                    return false;
                }

                public function stream_read(int $count): string
                {
                    $result = substr($this->entry, $this->position, $count);
                    $this->position += strlen($result);
                    return $result;
                }

                public function stream_write(string $data): int
                {
                    $datalen = strlen($data);
                    $posision = $this->position;
                    // 一般的に、ファイルの終端より先の位置に移動することも許されています。
                    // そこにデータを書き込んだ場合、ファイルの終端からシーク位置までの範囲を読み込むと 値 0 が埋められたバイトを返します。
                    $current = str_pad($this->entry, $posision, "\0", STR_PAD_RIGHT);
                    $this->entry = substr_replace($current, $data, $posision, $datalen);
                    $this->position += $datalen;
                    return $datalen;
                }

                public function stream_truncate(int $new_size): bool
                {
                    $current = substr($this->entry, 0, $new_size);
                    $this->entry = str_pad($current, $new_size, "\0", STR_PAD_RIGHT);
                    return true;
                }

                public function stream_tell(): int
                {
                    return $this->position;
                }

                public function stream_seek(int $offset, int $whence = SEEK_SET): bool
                {
                    $strlen = strlen($this->entry);
                    switch ($whence) {
                        case SEEK_SET:
                            if ($offset < 0) {
                                return false;
                            }
                            $this->position = $offset;
                            break;

                        // stream_tell を定義していると SEEK_CUR が呼ばれない？（計算されて SEEK_SET に移譲されているような気がする）
                        // @codeCoverageIgnoreStart
                        case SEEK_CUR:
                            $this->position += $offset;
                            break;
                        // @codeCoverageIgnoreEnd

                        case SEEK_END:
                            $this->position = $strlen + $offset;
                            break;
                    }
                    // ファイルの終端から数えた位置に移動するには、負の値を offset に渡して whence を SEEK_END に設定しなければなりません。
                    if ($this->position < 0) {
                        $this->position = $strlen + $this->position;
                        if ($this->position < 0) {
                            $this->position = 0;
                            return false;
                        }
                    }
                    return true;
                }

                public function stream_stat()
                {
                    $size = strlen($this->entry);
                    return [
                        7      => $size,
                        'size' => $size,
                    ];
                }
            }));
        }

        if (func_num_args() > 1) {
            $var = $initial;
        }
        // タイプヒントによる文字列化とキャストによる文字列化は動作が異なるので、この段階で早めに文字列化しておく
        $var = (string) $var;
        return fopen($STREAM_NAME . '://' . $stream_class::create($var), 'r+b');
    }

    /**
     * 組み込みの var_export をいい感じにしたもの
     *
     * 下記の点が異なる。
     *
     * - 配列は 5.4 以降のショートシンタックス（[]）で出力
     * - インデントは 4 固定
     * - ただの配列は1行（[1, 2, 3]）でケツカンマなし、連想配列は桁合わせインデントでケツカンマあり
     * - 文字列はダブルクオート
     * - null は null（小文字）
     * - 再帰構造を渡しても警告がでない（さらに NULL ではなく `'*RECURSION*'` という文字列になる）
     * - 配列の再帰構造の出力が異なる（Example参照）
     *
     * Example:
     * ```php
     * // 単純なエクスポート
     * that(var_export2(['array' => [1, 2, 3], 'hash' => ['a' => 'A', 'b' => 'B', 'c' => 'C']], true))->isSame('[
     *     "array" => [1, 2, 3],
     *     "hash"  => [
     *         "a" => "A",
     *         "b" => "B",
     *         "c" => "C",
     *     ],
     * ]');
     * // 再帰構造を含むエクスポート（標準の var_export は形式が異なる。 var_export すれば分かる）
     * $rarray = [];
     * $rarray['a']['b']['c'] = &$rarray;
     * $robject = new \stdClass();
     * $robject->a = new \stdClass();
     * $robject->a->b = new \stdClass();
     * $robject->a->b->c = $robject;
     * that(var_export2(compact('rarray', 'robject'), true))->isSame('[
     *     "rarray"  => [
     *         "a" => [
     *             "b" => [
     *                 "c" => "*RECURSION*",
     *             ],
     *         ],
     *     ],
     *     "robject" => stdClass::__set_state([
     *         "a" => stdClass::__set_state([
     *             "b" => stdClass::__set_state([
     *                 "c" => "*RECURSION*",
     *             ]),
     *         ]),
     *     ]),
     * ]');
     * ```
     *
     * @param mixed $value 出力する値
     * @param bool $return 返すなら true 出すなら false
     * @return string|null $return=true の場合は出力せず結果を返す
     */
    public static function var_export2($value, $return = false)
    {
        // インデントの空白数
        $INDENT = 4;

        // 再帰用クロージャ
        $export = function ($value, $nest = 0, $parents = []) use (&$export, $INDENT) {
            // 再帰を検出したら *RECURSION* とする（処理に関しては is_recursive のコメント参照）
            foreach ($parents as $parent) {
                if ($parent === $value) {
                    return $export('*RECURSION*');
                }
            }
            // 配列は連想判定したり再帰したり色々
            if (is_array($value)) {
                $spacer1 = str_repeat(' ', ($nest + 1) * $INDENT);
                $spacer2 = str_repeat(' ', $nest * $INDENT);

                $hashed = (is_hasharray)($value);

                // スカラー値のみで構成されているならシンプルな再帰
                if (!$hashed && (array_all)($value, is_primitive)) {
                    return '[' . implode(', ', array_map($export, $value)) . ']';
                }

                // 連想配列はキーを含めて桁あわせ
                if ($hashed) {
                    $keys = array_map($export, array_combine($keys = array_keys($value), $keys));
                    $maxlen = max(array_map('strlen', $keys));
                }
                $kvl = '';
                $parents[] = $value;
                foreach ($value as $k => $v) {
                    $keystr = $hashed ? $keys[$k] . str_repeat(' ', $maxlen - strlen($keys[$k])) . ' => ' : '';
                    $kvl .= $spacer1 . $keystr . $export($v, $nest + 1, $parents) . ",\n";
                }
                return "[\n{$kvl}{$spacer2}]";
            }
            // オブジェクトは単にプロパティを __set_state する文字列を出力する
            elseif (is_object($value)) {
                $parents[] = $value;
                return get_class($value) . '::__set_state(' . $export((get_object_properties)($value), $nest, $parents) . ')';
            }
            // 文字列はダブルクオート
            elseif (is_string($value)) {
                return '"' . addcslashes($value, "\$\"\0\\") . '"';
            }
            // null は小文字で居て欲しい
            elseif (is_null($value)) {
                return 'null';
            }
            // それ以外は標準に従う
            else {
                return var_export($value, true);
            }
        };

        // 結果を返したり出力したり
        $result = $export($value);
        if ($return) {
            return $result;
        }
        echo $result, "\n";
    }

    /**
     * var_export を色々と出力できるようにしたもの
     *
     * php のコードに落とし込むことで serialize と比較してかなり高速に動作する。ただし、要 php7.4.
     *
     * 各種オブジェクトやクロージャ、循環参照を含む配列など様々なものが出力できる。
     * ただし、下記は不可能あるいは復元不可（今度も対応するかは未定）。
     *
     * - 無名クラス
     * - Generator クラス
     * - 特定の内部クラス（PDO など）
     * - リソース
     * - php7.4 以降のアロー関数によるクロージャ
     *
     * オブジェクトは「リフレクションを用いてコンストラクタなしで生成してプロパティを代入する」という手法で復元する。
     * のでクラスによってはおかしな状態で復元されることがある（大体はリソース型のせいだが…）。
     * sleep, wakeup, Serializable などが実装されているとそれはそのまま機能する。
     * set_state だけは呼ばれないので注意。
     *
     * クロージャはコード自体を引っ張ってきて普通に function (){} として埋め込む。
     * クラス名のエイリアスや use, $this バインドなど可能な限り復元するが、おそらくあまりに複雑なことをしてると失敗する。
     *
     * 軽くベンチを取ったところ、オブジェクトを含まない純粋な配列の場合、serialize の 200 倍くらいは速い（それでも var_export の方が速いが…）。
     * オブジェクトを含めば含むほど遅くなり、全要素がオブジェクトになると serialize と同程度になる。
     * 大体 var_export:var_export3:serialize が 1:5:1000 くらい。
     *
     * @param mixed $value エクスポートする値
     * @param bool|array $return 返り値として返すなら true. 配列を与えるとオプションになる
     * @return string エクスポートされた文字列
     */
    public static function var_export3($value, $return = false)
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
        $options['return'] = $options['return'] ?? !!$options['outmode'];

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
                // オブジェクトは明確な ID が取れる（closure/object の区分けに処理的な意味はない）
                if (is_object($var)) {
                    $id = ($var instanceof \Closure ? 'closure' : 'object') . (spl_object_id($var) + 1);
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
        $export = function ($value, $nest = 0) use (&$export, &$vars, $var_manager) {
            $var_export = function ($v) { return var_export($v, true); };
            $spacer0 = str_repeat(" ", 4 * ($nest + 0));
            $spacer1 = str_repeat(" ", 4 * ($nest + 1));

            $vid = $var_manager->varId($value);
            if ($vid) {
                if (isset($vars[$vid])) {
                    return "\$this->$vid";
                }
                $vars[$vid] = $value;
            }

            if (is_array($value)) {
                $hashed = (is_hasharray)($value);
                if (!$hashed && (array_all)($value, is_primitive)) {
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

                $tokens = array_slice((parse_php)(implode(' ', (callable_code)($value)) . ';', TOKEN_PARSE), 1, -1);
                $uses = "";
                $context = [
                    'use' => false,
                ];
                $neighborToken = function ($n, $d) use ($tokens) {
                    for ($i = $n + $d; isset($tokens[$i]); $i += $d) {
                        if ($tokens[$i][0] !== T_WHITESPACE) {
                            return $tokens[$i];
                        }
                    }
                };
                foreach ($tokens as $n => $token) {
                    $prev = $neighborToken($n, -1) ?? [null, null, null];
                    $next = $neighborToken($n, +1) ?? [null, null, null];

                    // use 変数の導出
                    if ($prev[1] === ')' && $token[0] === T_USE) {
                        $context['use'] = true;
                    }
                    if ($context['use'] && $token[0] === T_VARIABLE) {
                        $varname = substr($token[1], 1);
                        $recurself = $statics[$varname] === $value ? '&' : '';
                        $uses .= "$spacer1\$$varname = $recurself{$export($statics[$varname], $nest + 1)};\n";
                    }
                    if ($context['use'] && $token[1] === ')') {
                        $context['use'] = false;
                    }

                    // クラスや関数・定数の use 解決
                    if ($token[0] === T_STRING) {
                        if ($prev[0] === T_NEW || $next[0] === T_DOUBLE_COLON || $next[0] === T_VARIABLE || $next[1] === '{') {
                            $token[1] = (resolve_symbol)($token[1], $ref->getFileName(), 'alias') ?? $token[1];
                        }
                        elseif ($next[1] === '(') {
                            $token[1] = (resolve_symbol)($token[1], $ref->getFileName(), 'function') ?? $token[1];
                        }
                        else {
                            $token[1] = (resolve_symbol)($token[1], $ref->getFileName(), 'const') ?? $token[1];
                        }
                    }
                    $tokens[$n] = $token;
                }

                $code = (indent_php)(implode('', array_column($tokens, 1)), [
                    'indent'   => $spacer1,
                    'baseline' => -1,
                ]);
                if ($bind) {
                    $scope = $var_export($class === 'Closure' ? 'static' : $class);
                    $code = "\Closure::bind($code, {$export($bind, $nest + 1)}, $scope)";
                }

                return "\$this->$vid = (function () {\n{$uses}{$spacer1}return $code;\n$spacer0})->call(\$this)";
            }
            if (is_object($value)) {
                $ref = new \ReflectionObject($value);
                $classname = get_class($value);

                // ジェネレータはどう頑張っても無理
                if ($value instanceof \Generator) {
                    throw new \DomainException('Generator Class is not support.');
                }

                // 無名クラスもほぼ不可能
                // コード自体を持ってくれば行けそうだけど、コンストラクタ引数を考えるとちょっと複雑すぎる
                // `new class(new class(){}, new class(){}, new class(){}){};` みたいのもあり得るわけでパースが難しい
                // `new class($localVar){};` みたいのも $localVar が得られない（コンストラクタに与えてるんだから property で取れなくもないが…）
                if ($ref->isAnonymous()) {
                    throw new \DomainException('Anonymous Class is not support yet.');
                }

                // __serialize があるならそれに従う
                if (method_exists($value, '__serialize')) {
                    $fields = $value->__serialize();
                }
                // __sleep があるならそれをプロパティとする
                elseif (method_exists($value, '__sleep')) {
                    $fields = array_intersect_key((get_object_properties)($value), array_flip($value->__sleep()));
                }
                // それ以外は適当に漁る
                else {
                    $fields = (get_object_properties)($value);
                }

                return "\$this->new(\$this->$vid, \\$classname::class, (function () {\n{$spacer1}return {$export($fields, $nest + 1)};\n{$spacer0}}))";
            }

            return is_null($value) || is_resource($value) ? 'null' : $var_export($value);
        };

        $exported = $export($value, 1);
        $others = "";
        $vars = [];
        foreach ($var_manager->orphan() as $rid => [$isref, $vid, $var]) {
            $declare = $isref ? "&\$this->$vid" : $export($var, 1);
            $others .= "    \$this->$rid = $declare;\n";
        }
        $result = "(function () {
{$others}    return $exported;
" . '})->call(new class() {
    public function new(&$object, $class, $provider)
    {
        $reflection = $this->reflect($class);
        $object = $reflection["self"]->newInstanceWithoutConstructor();
        $fields = $provider();

        if ($reflection["unserialize"]) {
            $object->__unserialize($fields);
            return $object;
        }

        foreach ($reflection["parents"] as $parent) {
            foreach ($this->reflect($parent->name)["properties"] as $name => $property) {
                if (isset($fields[$name]) || array_key_exists($name, $fields)) {
                    $property->setValue($object, $fields[$name]);
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

    private function reflect($class)
    {
        static $cache = [];
        if (!isset($cache[$class])) {
            $refclass = new \ReflectionClass($class);
            $cache[$class] = [
                "self"        => $refclass,
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
})';

        if ($options['format'] === 'minify') {
            $tmp = (memory_path)('var_export3.php');
            file_put_contents($tmp, "<?php $result;");
            $result = substr(php_strip_whitespace($tmp), 6, -1);
        }

        if ($options['outmode'] === 'eval') {
            $result = "return $result;";
        }
        if ($options['outmode'] === 'file') {
            /** @noinspection PhpUnreachableStatementInspection */
            $result = "<?php return $result;\n";
        }

        if (!$options['return']) {
            echo $result;
        }
        return $result;
    }

    /**
     * var_export2 を html コンテキストに特化させたようなもの
     *
     * 下記のような出力になる。
     * - `<pre class='var_html'> ～ </pre>` で囲まれる
     * - php 構文なのでハイライトされて表示される
     * - Content-Type が強制的に text/html になる
     *
     * この関数の出力は互換性を考慮しない。頻繁に変更される可能性がある。
     *
     * @param mixed $value 出力する値
     */
    public static function var_html($value)
    {
        $var_export = function ($value) {
            $result = var_export($value, true);
            $result = highlight_string("<?php " . $result, true);
            $result = preg_replace('#&lt;\\?php(\s|&nbsp;)#u', '', $result, 1);
            $result = preg_replace('#<br />#u', "\n", $result);
            $result = preg_replace('#>\n<#u', '><', $result);
            return $result;
        };

        $export = function ($value, $parents) use (&$export, $var_export) {
            foreach ($parents as $parent) {
                if ($parent === $value) {
                    return '*RECURSION*';
                }
            }
            if (is_array($value)) {
                $count = count($value);
                if (!$count) {
                    return '[empty]';
                }

                $maxlen = max(array_map('strlen', array_keys($value)));
                $kvl = '';
                $parents[] = $value;
                foreach ($value as $k => $v) {
                    $align = str_repeat(' ', $maxlen - strlen($k));
                    $kvl .= $var_export($k) . $align . ' => ' . $export($v, $parents) . "\n";
                }
                $var = "<var style='text-decoration:underline'>$count elements</var>";
                $summary = "<summary style='cursor:pointer;color:#0a6ebd'>[$var]</summary>";
                return "<details style='display:inline;vertical-align:text-top'>$summary$kvl</details>";
            }
            elseif (is_object($value)) {
                $parents[] = $value;
                return get_class($value) . '::' . $export((get_object_properties)($value), $parents);
            }
            elseif (is_null($value)) {
                return 'null';
            }
            elseif (is_resource($value)) {
                return ((string) $value) . '(' . get_resource_type($value) . ')';
            }
            else {
                return $var_export($value);
            }
        };

        // text/html を強制する（でないと見やすいどころか見づらくなる）
        // @codeCoverageIgnoreStart
        if (!headers_sent()) {
            header_remove('Content-Type');
            header('Content-Type: text/html');
        }
        // @codeCoverageIgnoreEnd

        echo "<pre class='var_html'>{$export($value, [])}</pre>";
    }

    /**
     * var_dump の出力を見やすくしたもの
     *
     * var_dump はとても縦に長い上見づらいので色や改行・空白を調整して見やすくした。
     * sapi に応じて自動で色分けがなされる（$context で指定もできる）。
     * また、 xdebug のように呼び出しファイル:行数が先頭に付与される。
     *
     * この関数の出力は互換性を考慮しない。頻繁に変更される可能性がある。
     *
     * Example:
     * ```php
     * // 下記のように出力される（実際は色付きで出力される）
     * $using = 123;
     * var_pretty([
     *     "array"   => [1, 2, 3],
     *     "hash"    => [
     *         "a" => "A",
     *         "b" => "B",
     *         "c" => "C",
     *     ],
     *     "object"  => new \Exception(),
     *     "closure" => function () use($using) { },
     * ]);
     * ?>
     * {
     *   array: [1, 2, 3],
     *   hash: {
     *     a: 'A',
     *     b: 'B',
     *     c: 'C',
     *   },
     *   object: Exception#1 {
     *     message: '',
     *     string: '',
     *     code: 0,
     *     file: '...',
     *     line: 19,
     *     trace: [],
     *     previous: null,
     *   },
     *   closure: Closure#0(static) use {
     *     using: 123,
     *   },
     * }
     * <?php
     * ```
     *
     * @param mixed $value 出力する値
     * @param array|string|null $context 出力コンテキスト（[null, "plain", "cli", "html"]）。 null を渡すと自動判別される
     * @param bool $return 出力するのではなく値を返すなら true
     * @return string $return: true なら値の出力結果
     */
    public static function var_pretty($value, $context = null, $return = false)
    {
        $options = [
            'indent'    => 2,     // インデントの空白数
            'context'   => null,  // html なコンテキストか cli なコンテキストか
            'return'    => false, // 値を戻すか出力するか
            'trace'     => false, // スタックトレースの表示
            'callback'  => null,  // 値1つごとのコールバック（値と文字列表現（参照）が引数で渡ってくる）
            'debuginfo' => true,  // debugInfo を利用してオブジェクトのプロパティを絞るか
            'maxcolumn' => null,  // 1行あたりの文字数
            'maxcount'  => null,  // 複合型の要素の数
            'maxdepth'  => null,  // 複合型の深さ
            'maxlength' => null,  // スカラー・非複合配列の文字数
            'limit'     => null,  // 最終出力の文字数
        ];

        // for compatible
        if (!is_array($context)) {
            $context = [
                'context' => $context,
                'return'  => $return,
            ];
        }
        $options = array_replace($options, $context);

        if ($options['context'] === null) {
            $options['context'] = 'html'; // SAPI でテストカバレッジが辛いので if else ではなくデフォルト代入にしてある
            if (PHP_SAPI === 'cli') {
                $options['context'] = (is_ansi)(STDOUT) && !$options['return'] ? 'cli' : 'plain';
            }
        }

        $appender = new class($options) {
            private $options;
            private $objects;
            private $content;
            private $length;
            private $column;

            public function __construct($options)
            {
                $this->options = $options;
                $this->objects = [];
                $this->content = '';
                $this->length = 0;
                $this->column = 0;
            }

            private function _append($value, $style = null, $data = [])
            {
                $strlen = strlen($value);

                if ($this->options['limit'] && $this->options['limit'] < $this->length += $strlen) {
                    throw new \LengthException($this->content);
                }

                //$current = count($this->content) - 1;
                if ($this->options['maxcolumn'] !== null) {
                    $breakpos = strrpos($value, "\n");
                    if ($breakpos === false) {
                        $this->column += $strlen;
                    }
                    else {
                        $this->column = $strlen - $breakpos - 1;
                    }
                    if ($this->column >= $this->options['maxcolumn']) {
                        preg_match('# +#', $this->content, $m, 0, strrpos($this->content, "\n"));
                        $this->column = 0;
                        $this->content .= "\n\t" . $m[0];
                    }
                }

                if ($style === null || $this->options['context'] === 'plain') {
                    $this->content .= $value;
                }
                elseif ($this->options['context'] === 'cli') {
                    $this->content .= (ansi_colorize)($value, $style);
                }
                elseif ($this->options['context'] === 'html') {
                    // 今のところ bold しか使っていないのでこれでよい
                    $style = $style === 'bold' ? 'font-weight:bold' : "color:$style";
                    $dataattr = (array_sprintf)($data, 'data-%2$s="%1$s"', ' ');
                    $this->content .= "<span style='$style' $dataattr>" . htmlspecialchars($value, ENT_QUOTES) . '</span>';
                }
                else {
                    throw new \InvalidArgumentException("'{$this->options['context']}' is not supported.");
                }
                return $this;
            }

            public function plain($token)
            {
                return $this->_append($token);
            }

            public function index($token)
            {
                if (is_int($token)) {
                    return $this->_append($token, 'bold');
                }
                elseif (is_string($token)) {
                    return $this->_append($token, 'red');
                }
                elseif (is_object($token)) {
                    return $this->_append($this->string($token), 'green', ['type' => 'object-index', 'id' => spl_object_id($token)]);
                }
                else {
                    throw new \DomainException(); // @codeCoverageIgnore
                }
            }

            public function value($token)
            {
                if (is_null($token)) {
                    return $this->_append($this->string($token), 'bold', ['type' => 'null']);
                }
                elseif (is_object($token)) {
                    return $this->_append($this->string($token), 'green', ['type' => 'object', 'id' => spl_object_id($token)]);
                }
                elseif (is_resource($token)) {
                    return $this->_append($this->string($token), 'bold', ['type' => 'resource']);
                }
                elseif (is_string($token)) {
                    return $this->_append($this->string($token), 'magenta', ['type' => 'scalar']);
                }
                elseif (is_bool($token)) {
                    return $this->_append($this->string($token), 'bold', ['type' => 'bool']);
                }
                elseif (is_scalar($token)) {
                    return $this->_append($this->string($token), 'magenta', ['type' => 'scalar']);
                }
                else {
                    throw new \DomainException(); // @codeCoverageIgnore
                }
            }

            public function string($token)
            {
                if (is_null($token)) {
                    return 'null';
                }
                elseif (is_object($token)) {
                    return get_class($token) . "#" . spl_object_id($token);
                }
                elseif (is_resource($token)) {
                    return sprintf('%s of type (%s)', $token, get_resource_type($token));
                }
                elseif (is_string($token)) {
                    if ($this->options['maxlength']) {
                        $token = (str_ellipsis)($token, $this->options['maxlength'], '...(too length)...');
                    }
                    return var_export($token, true);
                }
                elseif (is_scalar($token)) {
                    return var_export($token, true);
                }
                else {
                    throw new \DomainException(gettype($token)); // @codeCoverageIgnore
                }
            }

            public function export($value, $nest, $parents, $callback)
            {
                $position = strlen($this->content);

                // オブジェクトは一度処理してれば無駄なので参照表示
                if (is_object($value)) {
                    $id = spl_object_id($value);
                    if (isset($this->objects[$id])) {
                        $this->index($value);
                        goto FINALLY_;
                    }
                    $this->objects[$id] = $value;
                }

                // 再帰を検出したら *RECURSION* とする（処理に関しては is_recursive のコメント参照）
                foreach ($parents as $parent) {
                    if ($parent === $value) {
                        $this->plain('*RECURSION*');
                        goto FINALLY_;
                    }
                }

                if (is_array($value)) {
                    if ($this->options['maxdepth'] && $nest + 1 > $this->options['maxdepth']) {
                        $this->plain('(too deep)');
                        goto FINALLY_;
                    }

                    $parents[] = $value;

                    $count = count($value);
                    $omitted = false;
                    if ($this->options['maxcount'] && ($omitted = $count - $this->options['maxcount']) > 0) {
                        $value = array_slice($value, 0, $this->options['maxcount'], true);
                    }

                    $is_hasharray = (is_hasharray)($value);
                    $primitive_only = (array_all)($value, is_primitive);
                    $assoc = $is_hasharray || !$primitive_only;

                    $spacer1 = str_repeat(' ', ($nest + 1) * $this->options['indent']);
                    $spacer2 = str_repeat(' ', ($nest + 0) * $this->options['indent']);

                    $key = null;
                    if ($primitive_only && $this->options['maxlength']) {
                        $lengths = [];
                        foreach ($value as $k => $v) {
                            if ($assoc) {
                                $lengths[] = strlen($this->string($spacer1)) + strlen($this->string($k)) + strlen($this->string($v)) + 4;
                            }
                            else {
                                $lengths[] = strlen($this->string($v)) + 2;
                            }
                        }
                        while (count($lengths) > 0 && array_sum($lengths) > $this->options['maxlength']) {
                            $middle = (int) (count($lengths) / 2);
                            $unpos = function ($v, $k, $n) use ($middle) { return $n === $middle; };
                            (array_unset)($value, $unpos);
                            (array_unset)($lengths, $unpos);
                            $key = (int) (count($lengths) / 2);
                        }
                    }

                    if ($count === 0) {
                        $this->plain('[]');
                    }
                    elseif ($assoc) {
                        $n = 0;
                        $this->plain("{\n");
                        if (!$value) {
                            $this->plain($spacer1)->plain('...(too length)...')->plain(",\n");
                        }
                        foreach ($value as $k => $v) {
                            if ($key === $n++) {
                                $this->plain($spacer1)->plain('...(too length)...')->plain(",\n");
                            }
                            $this->plain($spacer1)->index($k)->plain(': ');
                            $this->export($v, $nest + 1, $parents, true);
                            $this->plain(",\n");
                        }
                        if ($omitted > 0) {
                            $this->plain("$spacer1(more $omitted elements)\n");
                        }
                        $this->plain("{$spacer2}}");
                    }
                    else {
                        $lastkey = (last_key)($value);
                        $n = 0;
                        $this->plain('[');
                        if (!$value) {
                            $this->plain('...(too length)...')->plain(', ');
                        }
                        foreach ($value as $k => $v) {
                            if ($key === $n++) {
                                $this->plain('...(too length)...')->plain(', ');
                            }
                            $this->export($v, $nest, $parents, true);
                            if ($k !== $lastkey) {
                                $this->plain(', ');
                            }
                        }
                        if ($omitted > 0) {
                            $this->plain(" (more $omitted elements)");
                        }
                        $this->plain(']');
                    }
                }
                elseif ($value instanceof \Closure) {
                    /** @var \ReflectionFunctionAbstract $ref */
                    $ref = (reflect_callable)($value);
                    $that = $ref->getClosureThis();
                    $properties = $ref->getStaticVariables();

                    $this->value($value)->plain("(");
                    if ($that) {
                        $this->index($that);
                    }
                    else {
                        $this->plain("static");
                    }
                    $this->plain(') use ');
                    if ($properties) {
                        $this->export($properties, $nest, $parents, false);
                    }
                    else {
                        $this->plain('{}');
                    }
                }
                elseif (is_object($value)) {
                    if ($this->options['debuginfo'] && method_exists($value, '__debugInfo')) {
                        $properties = [];
                        foreach (array_reverse($value->__debugInfo(), true) as $k => $v) {
                            $p = strrpos($k, "\0");
                            if ($p !== false) {
                                $k = substr($k, $p + 1);
                            }
                            $properties[$k] = $v;
                        }
                    }
                    else {
                        $properties = (get_object_properties)($value);
                    }

                    $this->value($value)->plain(" ");
                    if ($properties) {
                        $this->export($properties, $nest, $parents, false);
                    }
                    else {
                        $this->plain('{}');
                    }
                }
                else {
                    $this->value($value);
                }

                FINALLY_:
                $content = substr($this->content, $position);
                if ($callback && $this->options['callback']) {
                    ($this->options['callback'])($content, $value, $nest);
                    $this->content = substr_replace($this->content, $content, $position);
                }
                return $content;
            }
        };

        try {
            $content = $appender->export($value, 0, [], false);
        }
        catch (\LengthException $ex) {
            $content = $ex->getMessage() . '(...omitted)';
        }

        if ($options['callback']) {
            ($options['callback'])($content, $value, 0);
        }

        // 結果を返したり出力したり
        $traces = [];
        if ($options['trace']) {
            $traces = (stacktrace)(null, ['format' => "%s:%s", 'args' => false, 'delimiter' => null]);
            $traces = array_reverse(array_slice($traces, 0, $options['trace'] === true ? null : $options['trace']));
            $traces[] = '';
        }
        $result = implode("\n", $traces) . $content;

        if ($options['context'] === 'html') {
            $result = "<pre class='var_pretty'>$result</pre>";
        }
        if ($options['return']) {
            return $result;
        }
        echo $result, "\n";
    }

    /**
     * js の console に値を吐き出す
     *
     * script タグではなく X-ChromeLogger-Data を使用する。
     * したがってヘッダ送信前に呼ぶ必要がある。
     *
     * @see https://craig.is/writing/chrome-logger/techspecs
     *
     * @param mixed ...$values 出力する値（可変引数）
     */
    public static function console_log(...$values)
    {
        // X-ChromeLogger-Data ヘッダを使うので送信済みの場合は不可
        if (headers_sent($file, $line)) {
            throw new \UnexpectedValueException("header is already sent. $file#$line");
        }

        // データ行（最後だけ書き出すので static で保持する）
        static $rows = [];

        // 最終データを一度だけヘッダで吐き出す（replace を false にしても多重で表示してくれないっぽい）
        if (!$rows && $values) {
            // header_register_callback はグローバルで1度しか登録できないのでライブラリ内部で使うべきではない
            // ob_start にコールバックを渡すと ob_end～ の時に呼ばれるので、擬似的に header_register_callback 的なことができる
            ob_start(function () use (&$rows) {
                $header = base64_encode(utf8_encode(json_encode([
                    'version' => '1.0.0',
                    'columns' => ['log', 'backtrace', 'type'],
                    'rows'    => $rows,
                ])));
                header('X-ChromeLogger-Data: ' . $header);
                return false;
            });
        }

        foreach ($values as $value) {
            $rows[] = [[$value], null, 'log'];
        }
    }

    /**
     * 変数指定をできるようにした compact
     *
     * 名前空間指定の呼び出しは未対応。use して関数名だけで呼び出す必要がある。
     *
     * Example:
     * ```php
     * $hoge = 'HOGE';
     * $fuga = 'FUGA';
     * that(hashvar($hoge, $fuga))->isSame(['hoge' => 'HOGE', 'fuga' => 'FUGA']);
     * ```
     *
     * @param mixed ...$vars 変数（可変引数）
     * @return array 引数の変数を変数名で compact した配列
     */
    public static function hashvar(...$vars)
    {
        $num = count($vars);

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
        $file = $trace['file'];
        $line = $trace['line'];
        $function = (function_shorten)($trace['function']);

        $cache = (cache)($file . '#' . $line, function () use ($file, $line, $function) {
            // 呼び出し元の1行を取得
            $lines = file($file, FILE_IGNORE_NEW_LINES);
            $target = $lines[$line - 1];

            // 1行内で複数呼んでいる場合のための配列
            $caller = [];
            $callers = [];

            // php パーシング
            $starting = false;
            $tokens = token_get_all('<?php ' . $target);
            foreach ($tokens as $token) {
                // トークン配列の場合
                if (is_array($token)) {
                    // 自身の呼び出しが始まった
                    if (!$starting && $token[0] === T_STRING && $token[1] === $function) {
                        $starting = true;
                    }
                    // 呼び出し中でかつ変数トークンなら変数名を確保
                    elseif ($starting && $token[0] === T_VARIABLE) {
                        $caller[] = ltrim($token[1], '$');
                    }
                    // 上記以外の呼び出し中のトークンは空白しか許されない
                    elseif ($starting && $token[0] !== T_WHITESPACE) {
                        throw new \UnexpectedValueException('argument allows variable only.');
                    }
                }
                // 1文字単位の文字列の場合
                else {
                    // 自身の呼び出しが終わった
                    if ($starting && $token === ')' && $caller) {
                        $callers[] = $caller;
                        $caller = [];
                        $starting = false;
                    }
                }
            }

            // 同じ引数の数の呼び出しは区別することが出来ない
            $length = count($callers);
            for ($i = 0; $i < $length; $i++) {
                for ($j = $i + 1; $j < $length; $j++) {
                    if (count($callers[$i]) === count($callers[$j])) {
                        throw new \UnexpectedValueException('argument is ambiguous.');
                    }
                }
            }

            return $callers;
        }, __FUNCTION__);

        // 引数の数が一致する呼び出しを返す
        foreach ($cache as $caller) {
            if (count($caller) === $num) {
                return array_combine($caller, $vars);
            }
        }

        // 仕組み上ここへは到達しないはず（呼び出し元のシンタックスが壊れてるときに到達しうるが、それならばそもそもこの関数自体が呼ばれないはず）。
        throw new \DomainException('syntax error.'); // @codeCoverageIgnore
    }
}
