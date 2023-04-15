<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * php のコードのインデントを調整する
 *
 * baseline で基準インデント位置を指定する。
 * その基準インデントを削除した後、指定したインデントレベルでインデントするようなイメージ。
 *
 * Example:
 * ```php
 * $phpcode = '
 *     echo 123;
 *
 *     if (true) {
 *         echo 456;
 *     }
 * ';
 * // 数値指定は空白換算
 * that(indent_php($phpcode, 8))->isSame('
 *         echo 123;
 *
 *         if (true) {
 *             echo 456;
 *         }
 * ');
 * // 文字列を指定すればそれが使用される
 * that(indent_php($phpcode, "  "))->isSame('
 *   echo 123;
 *
 *   if (true) {
 *       echo 456;
 *   }
 * ');
 * // オプション指定
 * that(indent_php($phpcode, [
 *     'baseline'  => 1,    // 基準インデントの行番号（負数で下からの指定になる）
 *     'indent'    => 4,    // インデント指定（上記の数値・文字列指定はこれの糖衣構文）
 *     'trimempty' => true, // 空行を trim するか
 *     'heredoc'   => true, // Flexible Heredoc もインデントするか
 * ]))->isSame('
 *     echo 123;
 *
 *     if (true) {
 *         echo 456;
 *     }
 * ');
 * ```
 *
 * @package ryunosuke\Functions\Package\misc
 *
 * @param string $phpcode インデントする php コード
 * @param array|int|string $options オプション
 * @return string インデントされた php コード
 */
function indent_php($phpcode, $options = [])
{
    if (!is_array($options)) {
        $options = ['indent' => $options];
    }
    $options += [
        'baseline'  => 1,
        'indent'    => 0,
        'trimempty' => true,
        'heredoc'   => true,
    ];
    if (is_int($options['indent'])) {
        $options['indent'] = str_repeat(' ', $options['indent']);
    }

    $lines = preg_split('#\\R#u', $phpcode);
    $baseline = $options['baseline'];
    if ($baseline < 0) {
        $baseline = count($lines) + $baseline;
    }
    preg_match('@^[ \t]*@u', $lines[$baseline] ?? '', $matches);
    $indent = $matches[0] ?? '';

    $tmp = token_get_all("<?php $phpcode");
    array_shift($tmp);

    // トークンの正規化
    $tokens = [];
    for ($i = 0; $i < count($tmp); $i++) {
        if (is_string($tmp[$i])) {
            $tmp[$i] = [-1, $tmp[$i], null];
        }

        // 行コメントの分割（T_COMMENT には改行が含まれている）
        if ($tmp[$i][0] === T_COMMENT && preg_match('@^(#|//).*?(\\R)@um', $tmp[$i][1], $matches)) {
            $tmp[$i][1] = trim($tmp[$i][1]);
            if (($tmp[$i + 1][0] ?? null) === T_WHITESPACE) {
                $tmp[$i + 1][1] = $matches[2] . $tmp[$i + 1][1];
            }
            else {
                array_splice($tmp, $i + 1, 0, [[T_WHITESPACE, $matches[2], null]]);
            }
        }

        if ($options['heredoc']) {
            // 行コメントと同じ（T_START_HEREDOC には改行が含まれている）
            if ($tmp[$i][0] === T_START_HEREDOC && preg_match('@^(<<<).*?(\\R)@um', $tmp[$i][1], $matches)) {
                $tmp[$i][1] = trim($tmp[$i][1]);
                if (($tmp[$i + 1][0] ?? null) === T_ENCAPSED_AND_WHITESPACE) {
                    $tmp[$i + 1][1] = $matches[2] . $tmp[$i + 1][1];
                }
                else {
                    array_splice($tmp, $i + 1, 0, [[T_ENCAPSED_AND_WHITESPACE, $matches[2], null]]);
                }
            }
            // php 7.3 において T_END_HEREDOC は必ず単一行になる
            if ($tmp[$i][0] === T_ENCAPSED_AND_WHITESPACE) {
                if (($tmp[$i + 1][0] ?? null) === T_END_HEREDOC && preg_match('@^(\\s+)(.*)@um', $tmp[$i + 1][1], $matches)) {
                    $tmp[$i][1] = $tmp[$i][1] . $matches[1];
                    $tmp[$i + 1][1] = $matches[2];
                }
            }
        }

        $tokens[] = $tmp[$i] + [3 => token_name($tmp[$i][0])];
    }

    // 改行を置換してインデント
    $hereing = false;
    foreach ($tokens as $i => $token) {
        if ($options['heredoc']) {
            if ($token[0] === T_START_HEREDOC) {
                $hereing = true;
            }
            if ($token[0] === T_END_HEREDOC) {
                $hereing = false;
            }
        }
        if (in_array($token[0], [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT], true) || ($hereing && $token[0] === T_ENCAPSED_AND_WHITESPACE)) {
            $token[1] = preg_replace("@(\\R)$indent@um", '$1' . $options['indent'], $token[1]);
        }
        if ($options['trimempty']) {
            if ($token[0] === T_WHITESPACE) {
                $token[1] = preg_replace("@(\\R)[ \\t]+(\\R)@um", '$1$2', $token[1]);
            }
        }

        $tokens[$i] = $token;
    }
    return implode('', array_column($tokens, 1));
}
