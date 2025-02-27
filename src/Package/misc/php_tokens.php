<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../classobj/const_exists.php';
require_once __DIR__ . '/../misc/namespace_resolve.php';
// @codeCoverageIgnoreEnd

/**
 * PhpToken に便利メソッドを生やした配列を返す
 *
 * php_parse とは似て非なる（あっちは何がしたいのかよく分からなくなっている）。
 * この関数はシンプルに PhpToken の拡張版として動作する。
 *
 * 生えているメソッドは下記。
 * - __debugInfo: デバッグしやすい情報で吐き出す
 * - clone: 新プロパティを指定して clone する
 * - name: getTokenName のエイリアス
 * - prev: ignorable ではない直前のトークンを返す
 * - next: ignorable ではない直後のトークンを返す
 * - resolve: text が名前空間を解決して完全修飾になったトークンを返す
 *
 * Example:
 * ```php
 * $phpcode = '<?php
 * // dummy
 * namespace Hogera;
 * class Example
 * {
 *     // something
 * }';
 *
 * $tokens = php_tokens($phpcode);
 * // name でトークン名が得られる
 * that($tokens[0])->name()->is('T_OPEN_TAG');
 * // ↑の次はコメントだが next で namespace が得られる
 * that($tokens[0])->next()->text->is('namespace');
 * // 同じく↑の次はホワイトスペースだが next で Hogera が得られる
 * that($tokens[0])->next()->next()->text->is('Hogera');
 * ```
 *
 * @package ryunosuke\Functions\Package\misc
 *
 * @noinspection PhpPossiblePolymorphicInvocationInspection
 *
 * @param string $phpcode パースする php コード
 * @param int $flags パースオプション
 * @return \PhpTokens[] トークン配列
 */
function php_tokens(string $code, int $flags = 0)
{
    $PhpToken = null;
    $PhpToken ??= new #[\AllowDynamicProperties] class (0, "") extends \PhpToken {
        public array $tokens;
        public int   $index;

        private $cache = [];

        public function __debugInfo(): array
        {
            $result = get_object_vars($this);

            unset($result['tokens'], $result['cache']);

            $result['name'] = $this->name();
            $result['prev'] = $this->prev()?->getTokenName();
            $result['next'] = $this->next()?->getTokenName();

            return $result;
        }

        public function clone(...$newparams): self
        {
            $that = clone $this;
            foreach ($newparams as $param => $value) {
                $that->{$param} = $value;
            }
            $that->cache = [];
            return $that;
        }

        public function name(): string
        {
            return $this->cache['name'] ??= $this->getTokenName();
        }

        public function prev(): ?self
        {
            return $this->cache['prev'] ??= $this->sibling($this->index, -1);
        }

        public function next(): ?self
        {
            return $this->cache['next'] ??= $this->sibling($this->index, +1);
        }

        public function resolve($ref): string
        {
            $var_export = fn($v) => var_export($v, true);
            $prev = $this->prev();
            $next = $this->next();

            $text = $this->text;
            if ($this->id === T_STRING) {
                $namespaces = [$ref->getNamespaceName()];
                if ($ref instanceof \ReflectionFunctionAbstract) {
                    $namespaces[] = $ref->getClosureScopeClass()?->getNamespaceName();
                }
                if ($prev->id === T_NEW || $next->id === T_DOUBLE_COLON || $next->id === T_VARIABLE || $next->text === '{') {
                    $text = namespace_resolve($text, $ref->getFileName(), 'alias') ?? $text;
                }
                elseif ($next->text === '(') {
                    $text = namespace_resolve($text, $ref->getFileName(), 'function') ?? $text;
                    // 関数・定数は use しなくてもグローバルにフォールバックされる（=グローバルと名前空間の区別がつかない）
                    foreach ($namespaces as $namespace) {
                        if (!function_exists($text) && function_exists($nstext = "\\$namespace\\$text")) {
                            $text = $nstext;
                            break;
                        }
                    }
                }
                else {
                    $text = namespace_resolve($text, $ref->getFileName(), 'const') ?? $text;
                    // 関数・定数は use しなくてもグローバルにフォールバックされる（=グローバルと名前空間の区別がつかない）
                    foreach ($namespaces as $namespace) {
                        if (!const_exists($text) && const_exists($nstext = "\\$namespace\\$text")) {
                            $text = $nstext;
                            break;
                        }
                    }
                }
            }

            // マジック定数の解決
            if ($this->id === T_DIR) {
                $text = $var_export(dirname($ref->getFileName()));
            }
            if ($this->id === T_FILE) {
                $text = $var_export($ref->getFileName());
            }
            if ($this->id === T_NS_C) {
                $text = $var_export($ref->getNamespaceName());
            }
            return $text;
        }

        private function sibling($n, $d)
        {
            for ($i = $n + $d; isset($this->tokens[$i]); $i += $d) {
                if (!$this->tokens[$i]->isIgnorable()) {
                    return $this->tokens[$i];
                }
            }
            return null;
        }
    };

    $tokens = $PhpToken::tokenize($code, $flags);
    foreach ($tokens as $i => $token) {
        $token->tokens = $tokens;
        $token->index = $i;
    }
    return $tokens;
}
