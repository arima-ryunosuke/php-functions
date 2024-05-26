<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * 指定エンコーディング間に互換性があるかを返す
 *
 * ※ ユースケースとして多い utf8,sjis 以外はほぼ実装していないので注意（かなり適当なのでそれすらも怪しい）
 *
 * mb_convert_encoding/mb_convert_variables は実際に変換が行われなくても処理が走ってしまうので、それを避けるための関数。
 * エンコーディングはただでさえカオスなのに utf8, UTF-8, sjis, sjis-win, cp932 などの表記揺れやエイリアスがあるので判定が結構しんどい。
 *
 * Example:
 * ```php
 * // ほぼ唯一のユースケース（互換性があるなら変換しない）
 * if (!mb_compatible_encoding(mb_internal_encoding(), 'utf8')) {
 *     mb_convert_encoding('utf8 string', 'utf8');
 * }
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $from 変換元エンコーディング
 * @param string $to 変換先エンコーディング
 * @return ?bool from が to に対して互換性があるなら true（8bit binary の時のみ例外的に null を返す）
 */
function mb_compatible_encoding($from, $to)
{
    static $encmap = [];
    if (!$encmap) {
        foreach (mb_list_encodings() as $encoding) {
            // 非推奨を避ける
            if (!in_array($encoding, ['BASE64', 'UUENCODE', 'HTML-ENTITIES', 'Quoted-Printable'], true)) {
                $encmap[strtolower($encoding)] = [
                    'aliases'  => array_flip(array_map('strtolower', mb_encoding_aliases($encoding))),
                    'mimename' => strtolower((string) @mb_preferred_mime_name($encoding)),
                ];
            }
        }
    }

    // php 世界のエンコーディング名に正規化
    $normalize = function ($encoding) use ($encmap) {
        $encoding = strtolower($encoding);

        static $cache = [];

        if (isset($cache[$encoding])) {
            return $cache[$encoding];
        }

        if (isset($encmap[$encoding])) {
            return $cache[$encoding] = $encoding;
        }
        foreach ($encmap as $encname => ['aliases' => $aliases]) {
            if (isset($aliases[$encoding])) {
                return $cache[$encoding] = $encname;
            }
        }
        foreach ($encmap as $encname => ['mimename' => $mimename]) {
            if ($mimename === $encoding) {
                return $cache[$encoding] = $encname;
            }
        }

        throw new \InvalidArgumentException("$encoding is not supported encoding");
    };

    $from = $normalize($from);
    $to = $normalize($to);

    // 他方が 8bit(binary) は全く互換性がない（互換性がないというか、そもそもテキストではない）
    // false を返すべきだが呼び元で特殊な処理をしたいことがあると思うので null にする
    if ($from === '8bit' xor $to === '8bit') {
        return null;
    }

    // 同じなら完全互換だろう
    if ($from === $to) {
        return true;
    }

    // ucs 系以外は大抵は ASCII 互換
    if ($from === 'ascii' && !preg_match('#^(ucs-2|ucs-4|utf-16|utf-32)#', $to)) {
        return true;
    }

    // utf8 派生
    if ($from === 'utf-8' && strpos($to, 'utf-8') === 0) {
        return true;
    }

    // sjis 派生
    if ($from === 'sjis' && (strpos($to, 'sjis') === 0 || $to === 'cp932')) {
        return true;
    }

    return false;
}
