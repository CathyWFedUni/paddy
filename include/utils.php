<?php

/**
 * handy utility functions
 */

/**
 * Return a value from an associative array, or the supplied default
 * @param array $arr An array to look within for the supplied key
 * @param string $key The key to search for
 * @param mixed $default What to return if $arr[$key] is not set
 */
function get_or_default($arr, $key, $default)
{
    if (isset($arr[$key])) {
        return $arr[$key];
    } else {
        return $default;
    }
}

//funciton for encrypt password
function better_crypt($input, $rounds = 7)
{
    $salt = "";
    $salt_chars = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
    for ($i = 0; $i < 22; $i++) {
        $salt .= $salt_chars[array_rand($salt_chars)];
    }
    return crypt($input, sprintf('$2a$%02d$', $rounds) . $salt);
}

//for memeber photos
//define('_randomhashkey', $GLOBALS['photos']['hashkey']);
