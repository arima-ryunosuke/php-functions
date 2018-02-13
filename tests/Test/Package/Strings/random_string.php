<?php

namespace ryunosuke\Functions\Package;

$zerobyte = false;
$strong = true;

function switch_zerobyte($flg)
{
    global $zerobyte;
    $zerobyte = $flg;
}

function switch_strong($flg)
{
    global $strong;
    $strong = $flg;
}

function random_bytes($length)
{
    global $zerobyte;
    if ($zerobyte) {
        return '';
    }
    return str_repeat('0', $length);
}

function openssl_random_pseudo_bytes($length, &$crypto_strong = null)
{
    global $strong;
    $crypto_strong = $strong;
    global $zerobyte;
    if ($zerobyte) {
        return '';
    }
    return str_repeat('0', $length);
}

function mcrypt_create_iv($size)
{
    global $zerobyte;
    if ($zerobyte) {
        return '';
    }
    return str_repeat('0', $size);
}
