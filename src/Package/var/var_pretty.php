<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_all.php';
require_once __DIR__ . '/../array/array_any.php';
require_once __DIR__ . '/../array/array_sprintf.php';
require_once __DIR__ . '/../array/array_unset.php';
require_once __DIR__ . '/../array/is_hasharray.php';
require_once __DIR__ . '/../array/last_key.php';
require_once __DIR__ . '/../classobj/get_object_properties.php';
require_once __DIR__ . '/../dataformat/markdown_table.php';
require_once __DIR__ . '/../errorfunc/stacktrace.php';
require_once __DIR__ . '/../info/ansi_colorize.php';
require_once __DIR__ . '/../info/is_ansi.php';
require_once __DIR__ . '/../reflection/reflect_callable.php';
require_once __DIR__ . '/../strings/str_ellipsis.php';
require_once __DIR__ . '/../var/is_primitive.php';
// @codeCoverageIgnoreEnd

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
 *     "closure" => function () use ($using) { },
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
 * @package ryunosuke\Functions\Package\var
 *
 * @param mixed $value 出力する値
 * @param array $options 出力オプション
 * @return string return: true なら値の出力結果
 */
function var_pretty($value, $options = [])
{
    $options += [
        'minify'        => false, // 短縮形で返す（実質的には情報を減らして1行で返す）
        'indent'        => 2,     // インデントの空白数
        'context'       => null,  // html なコンテキストか cli なコンテキストか
        'return'        => false, // 値を戻すか出力するか
        'trace'         => false, // スタックトレースの表示
        'callback'      => null,  // 値1つごとのコールバック（値と文字列表現（参照）が引数で渡ってくる）
        'debuginfo'     => true,  // debugInfo を利用してオブジェクトのプロパティを絞るか
        'table'         => true,  // 連想配列の配列の場合にテーブル表示するか（現状はマークダウン風味固定）
        'maxcolumn'     => null,  // 1行あたりの文字数
        'maxcount'      => null,  // 複合型の要素の数
        'maxdepth'      => null,  // 複合型の深さ
        'maxlength'     => null,  // スカラー・非複合配列の文字数
        'maxlistcolumn' => 120,   // 通常配列を1行化する文字数
        'limit'         => null,  // 最終出力の文字数
        'excludeclass'  => [],    // 除外するクラス名
    ];

    if ($options['context'] === null) {
        $options['context'] = 'html'; // SAPI でテストカバレッジが辛いので if else ではなくデフォルト代入にしてある
        if (PHP_SAPI === 'cli') {
            $options['context'] = is_ansi(STDOUT) && !$options['return'] ? 'cli' : 'plain';
        }
    }

    if ($options['minify']) {
        $options['indent'] = null;
        $options['trace'] = false;
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

        private function _append($value, $style = null, $data = []): self
        {
            if ($this->options['minify']) {
                $value = strtr($value, ["\n" => ' ']);
            }

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
                $this->content .= ansi_colorize($value, $style);
            }
            elseif ($this->options['context'] === 'html') {
                // 今のところ bold しか使っていないのでこれでよい
                $style = $style === 'bold' ? 'font-weight:bold' : "color:$style";
                $dataattr = array_sprintf($data, 'data-%2$s="%1$s"', ' ');
                $this->content .= "<span style='$style' $dataattr>" . htmlspecialchars($value, ENT_QUOTES) . '</span>';
            }
            else {
                throw new \InvalidArgumentException("'{$this->options['context']}' is not supported.");
            }
            return $this;
        }

        public function plain($token, $style = null): self
        {
            return $this->_append($token, $style);
        }

        public function index($token): self
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

        public function value($token): self
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

        public function string($token): string
        {
            if (is_null($token)) {
                return 'null';
            }
            elseif (is_object($token)) {
                if ($token instanceof \Closure) {
                    $ref = new \ReflectionFunction($token);
                    $fname = $ref->getFileName();
                    $sline = $ref->getStartLine();
                    $eline = $ref->getEndLine();
                    if ($fname && $sline && $eline) {
                        $lines = $sline === $eline ? $sline : "$sline~$eline";
                        return get_class($token) . "@$fname:$lines#" . spl_object_id($token);
                    }
                }
                return get_class($token) . "#" . spl_object_id($token);
            }
            elseif (is_resource($token)) {
                return sprintf('%s of type (%s)', $token, get_resource_type($token));
            }
            elseif (is_string($token)) {
                if ($this->options['maxlength']) {
                    $token = str_ellipsis($token, $this->options['maxlength'], '...(too length)...');
                }
                return json_encode($token, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            }
            elseif (is_scalar($token)) {
                return var_export($token, true);
            }
            else {
                throw new \DomainException(gettype($token)); // @codeCoverageIgnore
            }
        }

        public function array($value): array
        {
            if (is_array($value)) {
                return $value;
            }
            if (is_object($value)) {
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
                    $properties = get_object_properties($value);
                }
                return $properties;
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

                $is_hasharray = is_hasharray($value);
                $primitive_only = array_all($value, fn(...$args) => is_primitive(...$args));
                $assoc = !$this->options['minify'] && ($is_hasharray || !$primitive_only);
                $tableofarray = (function () use ($count, $value) {
                    if ($this->options['minify'] || !$this->options['table'] || $count <= 1) {
                        return null;
                    }

                    $first = reset($value);
                    $objective = is_object($first);
                    if ((!is_array($first) && !$objective) || empty($first)) {
                        return null;
                    }

                    // オブジェクトの一致性は完全同一クラス（継承や実装は見ない）、配列はキーが同じものとする
                    if ($objective) {
                        $first_condition = get_class($first);
                    }
                    else {
                        $first_condition = array_keys($first);
                        if (array_any($first_condition, 'is_int')) {
                            return null;
                        }
                    }

                    foreach ($value as $v) {
                        if (true
                            && !(is_array($v) && array_keys($v) === $first_condition)
                            && !(is_object($v) && get_class($v) === $first_condition)
                        ) {
                            return null;
                        }
                    }

                    return $objective ? "{$first_condition}[]" : 'array[]';
                })();

                $spacer1 = $this->options['indent'] === null ? '' : str_repeat(' ', ($nest + 1) * $this->options['indent']);
                $spacer2 = $this->options['indent'] === null ? '' : str_repeat(' ', ($nest + 0) * $this->options['indent']);

                $key = null;
                if ($primitive_only) {
                    $lengths = [];
                    foreach ($value as $k => $v) {
                        if ($assoc) {
                            $lengths[] = strlen($this->string($spacer1)) + strlen($this->string($k)) + strlen($this->string($v)) + 4;
                        }
                        else {
                            $lengths[] = strlen($this->string($v)) + 2;
                        }
                    }
                    if ($this->options['maxlength']) {
                        while (count($lengths) > 0 && array_sum($lengths) > $this->options['maxlength']) {
                            $middle = (int) (count($lengths) / 2);
                            $unpos = fn($v, $k, $n) => $n === $middle;
                            array_unset($value, $unpos);
                            array_unset($lengths, $unpos);
                            $key = (int) (count($lengths) / 2);
                        }
                    }
                    // 要素が1つなら複数行化するメリットがないので2以上とする
                    if (count($lengths) >= 2 && ($this->options['maxlistcolumn'] ?? PHP_INT_MAX) <= array_sum($lengths)) {
                        $assoc = !$this->options['minify'] && true;
                    }
                }

                if ($count === 0) {
                    $this->plain('[]');
                }
                elseif ($tableofarray) {
                    $markdown = markdown_table(array_map(fn($v) => $this->array($v), $value), [
                        'keylabel' => "#",
                        'context'  => $this->options['context'],
                    ]);
                    $this->plain($tableofarray, 'green');
                    $this->plain("\n");
                    $this->plain(preg_replace('#^#um', $spacer1, $markdown));
                    $this->plain($spacer2);
                }
                elseif ($assoc) {
                    $n = 0;
                    if ($is_hasharray) {
                        $this->plain("{\n");
                    }
                    else {
                        $this->plain("[\n");
                    }
                    if (!$value) {
                        $this->plain($spacer1)->plain('...(too length)...')->plain(",\n");
                    }
                    foreach ($value as $k => $v) {
                        if ($key === $n++) {
                            $this->plain($spacer1)->plain('...(too length)...')->plain(",\n");
                        }
                        $this->plain($spacer1);
                        if ($is_hasharray) {
                            $this->index($k)->plain(': ');
                        }
                        $this->export($v, $nest + 1, $parents, true);
                        $this->plain(",\n");
                    }
                    if ($omitted > 0) {
                        $this->plain("$spacer1(more $omitted elements)\n");
                    }
                    if ($is_hasharray) {
                        $this->plain("{$spacer2}}");
                    }
                    else {
                        $this->plain("{$spacer2}]");
                    }
                }
                else {
                    $lastkey = last_key($value);
                    $n = 0;
                    $this->plain('[');
                    if (!$value) {
                        $this->plain('...(too length)...')->plain(', ');
                    }
                    foreach ($value as $k => $v) {
                        if ($key === $n) {
                            $this->plain('...(too length)...')->plain(', ');
                        }
                        if ($is_hasharray && $n !== $k) {
                            $this->index($k)->plain(':');
                        }
                        $this->export($v, $nest, $parents, true);
                        if ($k !== $lastkey) {
                            $this->plain(', ');
                        }
                        $n++;
                    }
                    if ($omitted > 0) {
                        $this->plain(" (more $omitted elements)");
                    }
                    $this->plain(']');
                }
            }
            elseif ($value instanceof \Closure) {
                $this->value($value);

                if ($this->options['minify']) {
                    goto FINALLY_;
                }

                $ref = reflect_callable($value);
                $that = $ref->getClosureThis();
                $properties = $ref->getStaticVariables();

                $this->plain("(");
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
                $this->value($value);

                foreach ((array) $this->options['excludeclass'] as $class) {
                    if ($value instanceof $class) {
                        goto FINALLY_;
                    }
                }

                if ($this->options['minify']) {
                    goto FINALLY_;
                }

                $properties = $this->array($value);

                $this->plain(" ");
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
        $traces = stacktrace(null, ['format' => "%s:%s", 'args' => false, 'delimiter' => null]);
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
