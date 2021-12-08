#!/usr/bin/php
<?php

require 'utils.php';

const LENGTH_MAP = [
    2 => 1,
    4 => 4,
    3 => 7,
    7 => 8,
    // 6 => [0,6,9], 
    // 5 => [2,3,5],
];

// Only useful frequencies
const REVERSE_FREQ_MAP = [
    6 => 'b',
    4 => 'e',
    9 => 'f',
    // 7 => ['d', 'g'],
];

// length 6 without e   is 9
// length 6 without d|g is 0
// length 6 else        is 6
// length 5 without f   is 2
// length 5 with    b   is 5
// length 5 else        is 3

function solveCheatsheet(array $cheatSheet) : array {

    $frequencies = [];
    foreach ($cheatSheet as $index => $digit) {
        $digit = $cheatSheet[$index] = sortString($digit);
        for ($i = 0; $i < strlen($digit); ++$i) {
            $char = $digit[$i];
            if (!isset($frequencies[$char])) {
                $frequencies[$char] = 1;
            }
            else 
                $frequencies[$char] += 1;
        }
    }

    $translation = [];
    $dog = [];
    foreach ($frequencies as $char => $freq) {
        if (isset(REVERSE_FREQ_MAP[$freq])) {
            $translation[REVERSE_FREQ_MAP[$freq]] = $char;
        }
        else if (7 === $freq) {
            $dog[] = $char;
        }
    }    

    $dictionary = [];    
    foreach ($cheatSheet as $digit) {
        $len = strlen($digit);
        if (6 === $len)  {

            if (FALSE === strpos($digit, $translation['e'])) {
                $dictionary[$digit] = 9;
            }
            else {
                $is0 = FALSE;
                foreach ($dog as $dogChar) {
                    if (FALSE === strpos($digit, $dogChar)) {
                        $is0 = TRUE;
                    }
                }
                if ($is0) $dictionary[$digit] = 0;
                else $dictionary[$digit] = 6;
            }
        }
        else if (5 === $len) {

            if (FALSE === strpos($digit, $translation['f'])) {
                $dictionary[$digit] = 2;
            }
            elseif (FALSE !== strpos($digit, $translation['b'])) {
                $dictionary[$digit] = 5;
            }
            else
                $dictionary[$digit] = 3;
        }
    }    
    return $dictionary;
}
function convert(string $digit, array $dictionary) : int {

    $length = strlen($digit);

    if (isset(LENGTH_MAP[$length])) {
        $ret = LENGTH_MAP[$length];
    }
    else {
        $ret = $dictionary[$digit];
    }

    return $ret;
}

$outputSum = 0;
while (FALSE !== ($line = readline())) {
    $line = explode('|', $line);
    $output = explode(' ', trim($line[1]));
    $cheatSheet = explode(' ', trim($line[0]));
    $dictionary = solveCheatsheet($cheatSheet);
    $value = 0;
    foreach ($output as $digit) {
        $digit = sortString($digit);
        $value = $value*10 + convert($digit, $dictionary);
    }
    $outputSum += $value;
    
}

print PHP_EOL . $outputSum . PHP_EOL;