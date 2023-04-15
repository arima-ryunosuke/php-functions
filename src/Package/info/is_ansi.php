<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * リソースが ansi color に対応しているか返す
 *
 * パイプしたりリダイレクトしていると false を返す。
 *
 * @package ryunosuke\Functions\Package\info
 * @see https://github.com/symfony/console/blob/v4.2.8/Output/StreamOutput.php#L98
 *
 * @param resource $stream 調べるリソース
 * @return bool ansi color に対応しているなら true
 */
function is_ansi($stream)
{
    // テスト用に隠し引数で DS を取っておく
    $DIRECTORY_SEPARATOR = DIRECTORY_SEPARATOR;
    assert(!!$DIRECTORY_SEPARATOR = func_num_args() > 1 ? func_get_arg(1) : $DIRECTORY_SEPARATOR);

    if ('Hyper' === getenv('TERM_PROGRAM')) {
        return true;
    }

    if ($DIRECTORY_SEPARATOR === '\\') {
        return (\function_exists('sapi_windows_vt100_support') && @sapi_windows_vt100_support($stream))
            || false !== getenv('ANSICON')
            || 'ON' === getenv('ConEmuANSI')
            || 'xterm' === getenv('TERM');
    }

    return @stream_isatty($stream);
}
