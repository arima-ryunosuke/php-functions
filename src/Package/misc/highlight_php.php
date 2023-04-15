<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../info/ansi_colorize.php';
require_once __DIR__ . '/../info/is_ansi.php';
// @codeCoverageIgnoreEnd

/**
 * php のコードをハイライトする
 *
 * SAPI に応じて自動でハイライトする（html タグだったり ASCII color だったり）。
 * highlight_string の CLI 対応版とも言える。
 *
 * @package ryunosuke\Functions\Package\misc
 *
 * @param string $phpcode ハイライトする php コード
 * @param array|int $options オプション
 * @return string ハイライトされた php コード
 */
function highlight_php($phpcode, $options = [])
{
    $options += [
        'context' => null,
    ];

    $context = $options['context'];

    if ($context === null) {
        $context = 'html'; // SAPI でテストカバレッジが辛いので if else ではなくデフォルト代入にしてある
        if (PHP_SAPI === 'cli') {
            $context = is_ansi(STDOUT) ? 'cli' : 'plain';
        }
    }

    $colorize = static function ($value, $style) use ($context) {
        switch ($context) {
            default:
                throw new \InvalidArgumentException("'$context' is not supported.");
            case 'plain':
                return $value;
            case 'cli':
                return ansi_colorize($value, $style);
            case 'html':
                $names = array_flip(preg_split('#[^a-z]#i', $style));
                $keys = [
                    'bold'       => 'font-weight:bold',
                    'faint'      => '',
                    'italic'     => 'font-style:italic',
                    'underscore' => 'text-decoration:underline',
                    'blink'      => '',
                    'reverse'    => '',
                    'conceal'    => '',
                ];
                $colors = array_keys(array_diff_key($names, $keys));
                $styles = array_intersect_key($keys, $names);
                $styles[] = 'color:' . reset($colors);
                $style = implode(';', $styles);
                return "<span style='$style'>" . htmlspecialchars($value, ENT_QUOTES) . '</span>';
        }
    };

    $type = 'bold';
    $keyword = 'magenta|bold';
    $symbol = 'green|italic';
    $literal = 'red';
    $variable = 'underscore';
    $comment = 'blue|italic';

    $rules = [
        'null'                     => $type,
        'false'                    => $type,
        'true'                     => $type,
        'iterable'                 => $type,
        'bool'                     => $type,
        'float'                    => $type,
        'int'                      => $type,
        'string'                   => $type,
        T_ABSTRACT                 => $keyword,
        T_ARRAY                    => $keyword,
        T_CALLABLE                 => $keyword,
        T_CLASS_C                  => $keyword,
        T_DIR                      => $keyword,
        T_FILE                     => $keyword,
        T_FUNC_C                   => $keyword,
        T_LINE                     => $keyword,
        T_METHOD_C                 => $keyword,
        T_NS_C                     => $keyword,
        T_TRAIT_C                  => $keyword,
        T_AS                       => $keyword,
        T_BOOLEAN_AND              => $keyword,
        T_BOOLEAN_OR               => $keyword,
        T_BREAK                    => $keyword,
        T_CASE                     => $keyword,
        T_CATCH                    => $keyword,
        T_CLASS                    => $keyword,
        T_CLONE                    => $keyword,
        T_CONST                    => $keyword,
        T_CONTINUE                 => $keyword,
        T_DECLARE                  => $keyword,
        T_DEFAULT                  => $keyword,
        T_DO                       => $keyword,
        T_ELSE                     => $keyword,
        T_ELSEIF                   => $keyword,
        T_ENDDECLARE               => $keyword,
        T_ENDFOR                   => $keyword,
        T_ENDFOREACH               => $keyword,
        T_ENDIF                    => $keyword,
        T_ENDSWITCH                => $keyword,
        T_ENDWHILE                 => $keyword,
        T_END_HEREDOC              => $keyword,
        T_EXIT                     => $keyword,
        T_EXTENDS                  => $keyword,
        T_FINAL                    => $keyword,
        T_FINALLY                  => $keyword,
        T_FOR                      => $keyword,
        T_FOREACH                  => $keyword,
        T_ECHO                     => $keyword,
        T_FUNCTION                 => $keyword,
        T_GLOBAL                   => $keyword,
        T_GOTO                     => $keyword,
        T_IF                       => $keyword,
        T_IMPLEMENTS               => $keyword,
        T_INSTANCEOF               => $keyword,
        T_INSTEADOF                => $keyword,
        T_INTERFACE                => $keyword,
        T_LOGICAL_AND              => $keyword,
        T_LOGICAL_OR               => $keyword,
        T_LOGICAL_XOR              => $keyword,
        T_NAMESPACE                => $keyword,
        T_NEW                      => $keyword,
        T_PRIVATE                  => $keyword,
        T_PUBLIC                   => $keyword,
        T_PROTECTED                => $keyword,
        T_RETURN                   => $keyword,
        T_STATIC                   => $keyword,
        T_SWITCH                   => $keyword,
        T_THROW                    => $keyword,
        T_TRAIT                    => $keyword,
        T_TRY                      => $keyword,
        T_USE                      => $keyword,
        T_VAR                      => $keyword,
        T_WHILE                    => $keyword,
        T_YIELD                    => $keyword,
        T_YIELD_FROM               => $keyword,
        T_EMPTY                    => $keyword,
        T_EVAL                     => $keyword,
        T_ISSET                    => $keyword,
        T_LIST                     => $keyword,
        T_PRINT                    => $keyword,
        T_UNSET                    => $keyword,
        T_INCLUDE                  => $keyword,
        T_INCLUDE_ONCE             => $keyword,
        T_REQUIRE                  => $keyword,
        T_REQUIRE_ONCE             => $keyword,
        T_HALT_COMPILER            => $keyword,
        T_STRING                   => $symbol,
        T_CONSTANT_ENCAPSED_STRING => $literal,
        T_ENCAPSED_AND_WHITESPACE  => $literal,
        T_NUM_STRING               => $literal,
        T_DNUMBER                  => $literal,
        T_LNUMBER                  => $literal,
        // T_STRING_VARNAME           => $literal,
        // T_CURLY_OPEN               => $literal,
        // T_DOLLAR_OPEN_CURLY_BRACES => $literal,
        '"'                        => $literal,
        T_VARIABLE                 => $variable,
        T_COMMENT                  => $comment,
        T_DOC_COMMENT              => $comment,
    ];

    $tokens = token_get_all($phpcode, TOKEN_PARSE);
    foreach ($tokens as $n => $token) {
        if (is_string($token)) {
            $token = [null, $token, null];
        }

        $style = $rules[strtolower($token[1])] ?? $rules[$token[0]] ?? null;
        if ($style !== null) {
            $token[1] = $colorize($token[1], $style);
        }
        $tokens[$n] = $token;
    }
    return implode('', array_column($tokens, 1));
}
