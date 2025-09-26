<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../misc/sleetflake.php';
require_once __DIR__ . '/../utility/function_configure.php';
// @codeCoverageIgnoreEnd

/**
 * sleetflake::binary へのエイリアス
 *
 * @see sleetflake()
 * @package ryunosuke\Functions\Package\misc
 */
function unique_id(): string
{
    static $sleetflake = null;
    $sleetflake ??= (function () {
        $config = function_configure('unique_id.config');
        return sleetflake(
            base_timestamp: $config['timestamp_base'],
            sequence_bit: $config['sequence_bit'],
            ipaddress_bit: $config['ipaddress_bit'],
        );
    })();
    return $sleetflake->binary();
}
