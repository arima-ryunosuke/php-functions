<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/mb_setting.php';
// @codeCoverageIgnoreEnd

/**
 * mb_系の全体設定を一括設定する
 *
 * @see array_or()
 * @deprecated use mb_setting
 * @conflict 8.4
 * @codeCoverageIgnore
 * @package ryunosuke\Functions\Package\strings
 */
function mb_ereg_options($options)
{
    return mb_setting($options);
}
