<?php

namespace {

    function _strtoupper($string) { return strtoupper($string); }

    function _sort(&$array, $sort_flags = SORT_REGULAR) { return sort($array, $sort_flags); }

    function _trim($str, $character_mask = " \t\n\r\0\x0B") { return trim($str, $character_mask); }

    function &_ref()
    {
        static $vals = [];
        return $vals;
    }
}

namespace FA {

    function _strtoupper($string) { return strtoupper($string); }

    function _sort(&$array, $sort_flags = SORT_REGULAR) { return sort($array, $sort_flags); }

    function _trim($str, $character_mask = " \t\n\r\0\x0B") { return trim($str, $character_mask); }
}
