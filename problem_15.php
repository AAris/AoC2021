#!/usr/bin/php
<?php

require 'utils.php';

function convert(string $digit) : ?int {
    $length = strlen($digit);

    $lengthMap = [
        2 => 1,
        4 => 4,
        3 => 7,
        7 => 8,
    ];

    if (isset($lengthMap[$length])) {
        return $lengthMap[$length];
    }

    return NULL;
}

$obviousDigitSum = 0;
while (FALSE !== ($line = readline())) {
    $output = trim(explode('|', $line)[1]);
    $output = explode(' ', $output);
    foreach ($output as $digit) {
        if (NULL !== convert($digit)) {
            $obviousDigitSum += 1;
        }
    }
}

print PHP_EOL . $obviousDigitSum . PHP_EOL;