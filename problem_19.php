#!/usr/bin/php
<?php

require 'utils.php';

const CHARS = [
    '(' => ')',
    '[' => ']',
    '{' => '}',
    '<' => '>',
];

const CHARS_REVERSE = [
    ')' => '(',
    ']' => '[',
    '}' => '{',
    '>' => '<',
];

const POINTS = [')' => 3, ']' => 57, '}' => 1197, '>' => 25137];

$openStack = [];
$points = 0;
while (FALSE !== ($line = readline())) {
    $chars = str_split($line);
    $valid = TRUE;
    $i = 0;
    $char = NULL;
    while($valid && $i < count($chars)) {
        $char = $chars[$i];
        if (isset(CHARS[$char])) {
            $openStack[] = $char;
        }
        else {
            if (CHARS_REVERSE[$char] !== end($openStack))
                $valid = FALSE;
            else
                array_pop($openStack);
        }

        ++$i;
    }

    if (!$valid) {
        $points += POINTS[$char];
    }
}

print PHP_EOL . $points . PHP_EOL;


