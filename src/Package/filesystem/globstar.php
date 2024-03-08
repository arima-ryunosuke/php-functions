<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * globstar（再帰パターン有効）な glob
 *
 * file_list でも代替可能だが、もっと手軽にササっとファイル一覧が欲しいこともある。
 *
 * @package ryunosuke\Functions\Package\filesystem
 *
 * @param string $pattern glob パターン。** が使えること以外は glob と同じ
 * @param int $flags glob フラグ
 * @return array|false マッチしたファイル名配列
 */
function globstar($pattern, $flags = 0)
{
    $GLOB_NOESCAPE = $flags & GLOB_NOESCAPE;
    $GLOB_NOCHECK = $flags & GLOB_NOCHECK;
    $GLOB_NOSORT = $flags & GLOB_NOSORT;

    // \** は「アスターの後の任意の文字」という意味になるので再帰パターンではない
    // さらに Windows では \* も特別扱いされているようなのでそれに倣う
    // （Windows で "\*" は「エスケープされたアスター」なのか「ディレクトリ区切りの後の *」なのか判断ができないためと思われる）
    $backslash = ($GLOB_NOESCAPE || DIRECTORY_SEPARATOR === '\\') ? '' : '(?<!\\\\)';
    $patterns = preg_split("#$backslash\\*\\*#", $pattern, 2);

    $result = glob($pattern, $flags);

    if (count($patterns) === 1) {
        return $result;
    }

    foreach (glob($patterns[0] . '*', $flags & ~GLOB_NOCHECK & ~GLOB_MARK | GLOB_ONLYDIR) as $dir) {
        $subpattern = $dir . DIRECTORY_SEPARATOR . '**' . $patterns[1];
        $children = globstar($subpattern, $flags & ~GLOB_NOCHECK);
        if ($GLOB_NOCHECK && !$children) {
            return [$pattern];
        }

        $result = array_merge($result, $children);
    }

    if (!$GLOB_NOSORT) {
        sort($result);
    }

    return $result;
}
