<?php

use CandleLight\Artisan\Client;
use CandleLight\DirProvider;


/**
 * Checks if the given string is a UpperCamelCase-String
 * @param string $s the string to check
 * @return bool returns true if the string matches the pattern
 */
function isUpperCamelCase(string $s): bool{
    return preg_match('/^([A-Z][a-z]+)*$/', $s);
}

/**
 * Checks if the given string is a snake-case-String
 * @param string $s the string to check
 * @return bool returns true if the string matches the pattern
 */
function isSnakeCase(string $s): bool{
    return preg_match('/^([a-z]+-*)*$/', $s);
}

/**
 * Checks if the String does not contain any invalid chars
 * @param string $s the basename string to check
 * @return string returns the unaltered
 * @throws Exception throws an exception if the string is invalid
 */
function checkDirString(string $s): string{
    if (preg_match('/[\\,\/]/', $s) != false){
        throw new Exception('No Directory Separator allowed');
    }
    return $s;
}


$client = new Client();
DirProvider::glob(__DIR__ . DIRECTORY_SEPARATOR . 'commands' . DIRECTORY_SEPARATOR . '*.php', 0, ['client'=>$client, 'app' => $app]);
$client->dispatch($argv);
exit();