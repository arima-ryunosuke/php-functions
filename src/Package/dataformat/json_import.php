<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_explode.php';
require_once __DIR__ . '/../array/array_find_first.php';
require_once __DIR__ . '/../array/first_value.php';
require_once __DIR__ . '/../array/last_value.php';
require_once __DIR__ . '/../misc/php_tokens.php';
require_once __DIR__ . '/../constants.php';
// @codeCoverageIgnoreEnd

/**
 * json_decode のプロキシ関数
 *
 * 引数体系とデフォルト値を変更してある。
 *
 * JSON_ES5 に null か true を渡すと json5 としてでデコードする（null はまず json_decode で試みる、true は json5 のみ）。
 * その場合拡張オプションとして下記がある。
 *
 * - JSON_INT_AS_STRING: 常に整数を文字列で返す
 * - JSON_FLOAT_AS_STRING: 常に小数を文字列で返す
 * - JSON_BARE_AS_STRING: bare string を文字列として扱う
 * - JSON_TEMPLATE_LITERAL: テンプレートリテラルが使用可能になる
 *   - あくまで「文字列の括りに ` が使えるようになる」というものでテンプレートリテラルそのものではない
 *   - 末尾のインデントと同じインデントがすべて除去され、前後の改行は取り除かれる
 *
 * Example:
 * ```php
 * // オプションはこのように [定数 => bool] で渡す。false は指定されていないとみなされる（JSON_MAX_DEPTH 以外）
 * that(json_import('{"a":"A","b":"B"}', [
 *    JSON_OBJECT_AS_ARRAY => true,
 * ]))->is(['a' => 'A', 'b' => 'B']);
 *
 * // json5 が使える
 * that(json_import('{a: "A", b: "B", }'))->is(['a' => 'A', 'b' => 'B']);
 *
 * // テンプレートリテラル
 * that(json_import('`
 *     1
 *     2
 *     3
 *     `', [
 *     JSON_TEMPLATE_LITERAL => true,
 * ]))->is("1\n2\n3");
 * ```
 *
 * @package ryunosuke\Functions\Package\dataformat
 *
 * @param string $value JSON 文字列
 * @param array $options JSON_*** をキーにした連想配列。値が false は指定されていないとみなされる
 * @return mixed decode された値
 */
function json_import($value, $options = [])
{
    $specials = [
        JSON_OBJECT_AS_ARRAY  => true, // 個人的嗜好だが連想配列のほうが扱いやすい
        JSON_MAX_DEPTH        => 512,
        JSON_ES5              => null,
        JSON_INT_AS_STRING    => false,
        JSON_FLOAT_AS_STRING  => false,
        JSON_TEMPLATE_LITERAL => false,
        JSON_BARE_AS_STRING   => false,
    ];
    foreach ($specials as $key => $default) {
        $specials[$key] = $options[$key] ?? $default;
        unset($options[$key]);
    }
    $specials[JSON_THROW_ON_ERROR] = $options[JSON_THROW_ON_ERROR] ?? true;
    $specials[JSON_BIGINT_AS_STRING] = $options[JSON_BIGINT_AS_STRING] ?? false;
    if ($specials[JSON_INT_AS_STRING] || $specials[JSON_FLOAT_AS_STRING] || $specials[JSON_TEMPLATE_LITERAL] || $specials[JSON_BARE_AS_STRING]) {
        $specials[JSON_ES5] = true;
    }

    // true でないならまず json_decode で試行（json が来るならその方が遥かに速い）
    if ($specials[JSON_ES5] === false || $specials[JSON_ES5] === null) {
        $option = array_sum(array_keys(array_filter($options)));
        $result = json_decode($value, $specials[JSON_OBJECT_AS_ARRAY], $specials[JSON_MAX_DEPTH], $option);

        // エラーが出なかったらもうその時点で返せば良い
        if (json_last_error() === JSON_ERROR_NONE) {
            return $result;
        }
        // json5 を試行しないモードならこの時点で例外
        if ($specials[JSON_ES5] === false) {
            throw new \ErrorException(json_last_error_msg(), json_last_error());
        }
    }

    // 上記を通り抜けたら json5 で試行
    $parser = new class($value) {
        private $json_string;
        private $type;
        private $begin_position;
        private $end_position;
        private $keys;
        private $values;

        public function __construct($json_string)
        {
            $this->json_string = "<?php [$json_string]";
        }

        public function parse($options)
        {
            $tokens = php_tokens($this->json_string);
            array_shift($tokens);

            $braces = [];
            for ($i = 0; $i < count($tokens); $i++) {
                $token = $tokens[$i];
                if ($token->text === '{' || $token->text === '[') {
                    if ($options[JSON_MAX_DEPTH] <= count($braces) + 1) {
                        throw $this->exception("Maximum stack depth exceeded", $token);
                    }
                    $braces[] = $i;
                }
                elseif ($token->text === '}' || $token->text === ']') {
                    if (!$braces) {
                        throw $this->exception("Mismatch", $token);
                    }
                    $brace = array_pop($braces);
                    if ($tokens[$brace]->text !== '{' && $token->text === '}' || $tokens[$brace]->text !== '[' && $token->text === ']') {
                        throw $this->exception("Mismatch", $token);
                    }
                    $block = array_filter(array_slice(array_splice($tokens, $brace + 1, $i - $brace, []), 0, -1), fn($token) => !(!$token instanceof $this && in_array($token->id, [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT, T_BAD_CHARACTER], true)));
                    $elements = array_explode($block, fn($token) => !$token instanceof $this && $token->text === ',');
                    // for trailing comma
                    if ($elements && !$elements[count($elements) - 1]) {
                        array_pop($elements);
                    }
                    // check consecutive comma (e.g. [1,,3])
                    if (count(array_filter($elements)) !== count($elements)) {
                        throw $this->exception("Missing element", $token);
                    }
                    $i = $brace;
                    if ($token->text === '}') {
                        $object = $this->token('object', $tokens[$brace]->pos, $token->pos + strlen($token->text));
                        foreach ($elements as $element) {
                            $keyandval = array_explode($element, fn($token) => !$token instanceof $this && $token->text === ':');
                            // check no colon (e.g. {123})
                            if (count($keyandval) !== 2) {
                                throw $this->exception("Missing object key", first_value($keyandval[0]));
                            }
                            // check objective key (e.g. {[1]: 123})
                            if (($k = array_find_first($keyandval[0], fn($v) => $v instanceof $this)) !== null) {
                                throw $this->exception("Unexpected object key", $keyandval[0][$k]);
                            }
                            // check consecutive objective value (e.g. {k: 123 [1]})
                            if (!(count($keyandval[1]) === 1 && count(array_filter($keyandval[1], fn($v) => $v instanceof $this)) === 1 || count(array_filter($keyandval[1], fn($v) => !$v instanceof $this)) === count($keyandval[1]))) {
                                throw $this->exception("Unexpected object value", $token);
                            }
                            $key = first_value($keyandval[0]);
                            $lastkey = last_value($keyandval[0]);
                            $val = first_value($keyandval[1]);
                            $lastval = last_value($keyandval[1]);
                            if (!$val instanceof $this) {
                                $val = $this->token('value', $val->pos, $lastval->pos + strlen($lastval->text));
                            }
                            $object->append($this->token('key', $key->pos, $lastkey->pos + strlen($lastkey->text)), $val);
                        }
                        $tokens[$brace] = $object;
                    }
                    if ($token->text === ']') {
                        $array = $this->token('array', $tokens[$brace]->pos, $token->pos + strlen($token->text));
                        foreach ($elements as $element) {
                            // check consecutive objective value (e.g. [123 [1]])
                            if (!(count($element) === 1 && count(array_filter($element, fn($v) => $v instanceof $this)) === 1 || count(array_filter($element, fn($v) => !$v instanceof $this)) === count($element))) {
                                throw $this->exception("Unexpected array value", $token);
                            }
                            $val = first_value($element);
                            $lastval = last_value($element);
                            if (!$val instanceof $this) {
                                $val = $this->token('value', $val->pos, $lastval->pos + strlen($lastval->text));
                            }
                            $array->append(null, $val);
                        }
                        $tokens[$brace] = $array;
                    }
                }
            }

            if ($braces) {
                throw $this->exception("Mismatch", $tokens[$braces[count($braces) - 1]]);
            }

            /** @var self $root */
            $root = $tokens[0];
            $result = $root->value($options);

            if (count($result) !== 1) {
                throw $this->exception("Mismatch", $tokens[0]);
            }
            return $result[0];
        }

        private function token($type, $begin_position, $end_position)
        {
            $clone = clone $this;
            $clone->type = $type;
            $clone->begin_position = $begin_position;
            $clone->end_position = $end_position;
            $clone->keys = [];
            $clone->values = [];
            return $clone;
        }

        private function append($key, $value)
        {
            assert(($key !== null && $this->type === 'object') || ($key === null && $this->type === 'array'));
            $this->keys[] = $key ?? count($this->keys);
            $this->values[] = $value;
        }

        private function value($options = [])
        {
            $numberify = function ($token) use ($options) {
                if (is_numeric($token[0]) || $token[0] === '-' || $token[0] === '+' || $token[0] === '.') {
                    $sign = 1;
                    if ($token[0] === '+' || $token[0] === '-') {
                        $sign = substr($token, 0, 1) === '-' ? -1 : 1;
                        $token = substr($token, 1);
                    }
                    if (($token[0] ?? null) === '0' && isset($token[1]) && $token[1] !== '.') {
                        if (!($token[1] === 'x' || $token[1] === 'X')) {
                            throw $this->exception("Octal literal", $this);
                        }
                        $token = substr($token, 2);
                        if (!ctype_xdigit($token)) {
                            throw $this->exception("Bad hex number", $this);
                        }
                        $token = hexdec($token);
                    }
                    if (!is_numeric($token) || !is_finite($token)) {
                        throw $this->exception("Bad number", $this);
                    }
                    if (false
                        || ($options[JSON_INT_AS_STRING] && ctype_digit("$token"))
                        || ($options[JSON_FLOAT_AS_STRING] && !ctype_digit("$token"))
                        || ($options[JSON_BIGINT_AS_STRING] && ctype_digit("$token") && is_float(($token + 0)))
                    ) {
                        return $sign === -1 ? "-$token" : $token;
                    }

                    return 0 + $sign * $token;
                }
                return null;
            };
            $stringify = function ($token) use ($options) {
                if (strlen($token) > 1 && ($token[0] === '"' || $token[0] === "'" || ($options[JSON_TEMPLATE_LITERAL] && $token[0] === "`"))) {
                    if (strlen($token) < 2 || $token[0] !== $token[-1]) {
                        throw $this->exception("Bad string", $this);
                    }
                    $rawtoken = $token;
                    $token = substr($token, 1, -1);
                    if ($rawtoken[0] === "`" && $rawtoken[1] === "\n" && preg_match('#\n( +)`#u', $rawtoken, $match)) {
                        $token = substr(preg_replace("#\n{$match[1]}#u", "\n", $token), 1, -1);
                    }
                    $token = preg_replace_callback('/(?:\\\\u[0-9A-Fa-f]{4})+/u', function ($m) { return json_decode('"' . $m[0] . '"'); }, $token);
                    $token = strtr($token, [
                        "\\'"    => "'",
                        "\\`"    => "`",
                        '\\"'    => '"',
                        '\\\\'   => '\\',
                        '\\/'    => '/',
                        "\\\n"   => "",
                        "\\\r"   => "",
                        "\\\r\n" => "",
                        '\\b'    => chr(8),
                        '\\f'    => "\f",
                        '\\n'    => "\n",
                        '\\r'    => "\r",
                        '\\t'    => "\t",
                    ]);
                    return $token;
                }
                return null;
            };

            switch ($this->type) {
                default:
                    throw new \DomainException(); // @codeCoverageIgnore
                case 'array':
                    return array_map(fn($value) => $value->value($options), $this->values);
                case 'object':
                    $array = array_combine(
                        array_map(fn($value) => $value->value($options), $this->keys),
                        array_map(fn($value) => $value->value($options), $this->values)
                    );
                    return $options[JSON_OBJECT_AS_ARRAY] ? $array : (object) $array;
                case 'key':
                    $token = substr($this->json_string, $this->begin_position, $this->end_position - $this->begin_position);
                    $token = trim($token, chr(0xC2) . chr(0xA0) . " \n\r\t\v\x00\x0c");
                    if (preg_match('/^(?:[\$_\p{L}\p{Nl}]|\\\\u[0-9A-Fa-f]{4})(?:[\$_\p{L}\p{Nl}\p{Mn}\p{Mc}\p{Nd}\p{Pc}‌‍]|\\\\u[0-9A-Fa-f]{4})*/u', $token)) {
                        $token = preg_replace_callback('/(?:\\\\u[0-9A-Fa-f]{4})+/u', fn($m) => json_decode('"' . $m[0] . '"'), $token);
                        return $token;
                    }
                    if (($string = $stringify($token)) !== null) {
                        return $string;
                    }
                    throw $this->exception("Bad identifier", $this);
                case 'value':
                    $token = substr($this->json_string, $this->begin_position, $this->end_position - $this->begin_position);
                    $token = trim($token, chr(0xC2) . chr(0xA0) . " \n\r\t\v\x00\x0c");
                    $literals = [
                        'null'      => null,
                        'false'     => false,
                        'true'      => true,
                        'Infinity'  => INF,
                        '+Infinity' => +INF,
                        '-Infinity' => -INF,
                        'NaN'       => NAN,
                        '+NaN'      => +NAN,
                        '-NaN'      => -NAN,
                    ];
                    // literals
                    if (array_key_exists($token, $literals)) {
                        return $literals[$token];
                    }
                    // numbers
                    if (($number = $numberify($token)) !== null) {
                        return $number;
                    }
                    // strings
                    if (($string = $stringify($token)) !== null) {
                        return $string;
                    }
                    if ($options[JSON_BARE_AS_STRING]) {
                        return $token;
                    }
                    throw $this->exception("Bad value", $this);
            }
        }

        private function exception($message, $token)
        {
            if ($token instanceof $this) {
                $line = substr_count($token->json_string, "\n", 0, $token->begin_position) + 1;
                $column = $token->begin_position - strrpos($token->json_string, "\n", $token->begin_position - strlen($token->json_string));
                $word = substr($token->json_string, $token->begin_position, $token->end_position - $token->begin_position);
            }
            else {
                $line = $token->line;
                $column = $token->pos - strrpos($this->json_string, "\n", $token->pos - strlen($this->json_string));
                $word = $token->text;
            }
            return new \ErrorException(sprintf("%s '%s' at line %d column %d of the JSON5 data", $message, $word, $line, $column));
        }
    };

    try {
        return $parser->parse($specials);
    }
    catch (\Throwable $t) {
        if ($specials[JSON_THROW_ON_ERROR]) {
            throw $t;
        }
        // json_last_error を設定する術はないので強制的に Syntax error にする（return することで返り値も統一される）
        return @json_decode('invalid json');
    }
}
