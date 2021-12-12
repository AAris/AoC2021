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

const CORRUPTION_POINTS = [')' => 3, ']' => 57, '}' => 1197, '>' => 25137];
const COMPLETION_POINTS = [')' => 1, ']' => 2, '}' => 3, '>' => 4];
const COMPLETION_MULT = 5;

$pointsCorruption = 0;
$completionPoints = [];
while (FALSE !== ($line = readline())) {
    $chars = str_split($line);
    $corrupt = FALSE;
    $i = 0;
    $char = NULL;
    $openStack = [];
    while(!$corrupt && $i < count($chars)) {
        $char = $chars[$i];
        if (isset(CHARS[$char])) {
            $openStack[] = $char;
        }
        else {
            if (CHARS_REVERSE[$char] !== end($openStack))
                $corrupt = TRUE;
            else
                array_pop($openStack);
        }

        ++$i;
    }

    if ($corrupt) {
        $pointsCorruption += CORRUPTION_POINTS[$char];
    }

    else {
        $completion = [];
        $score = 0;
        while (NULL !== ($char = array_pop($openStack))) {
            $score = $score*COMPLETION_MULT + COMPLETION_POINTS[CHARS[$char]];
        }
        $completionPoints[] = $score;
    }
}

sort($completionPoints);
$middle = count($completionPoints)/2;

print PHP_EOL . 'Corruption points: ' . $pointsCorruption . PHP_EOL . 'Completion points: ' . $completionPoints[$middle] . PHP_EOL;


