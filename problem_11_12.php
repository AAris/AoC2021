#!/usr/bin/php
<?php

require 'utils.php';

$state = read_numbers(',');

const INITIAL_DAYS = 256;
const REPRODUCTION_TIMER = 6;
const INITIAL_TIMER = 8;

function increaseRstate($key, $value, array &$rState) : void {
    if (!isset($rState[$key])) {
        $rState[$key] = $value;
    }
    else {
        $rState[$key] += $value;
    }
}

$rState = [];
$count = 0;
foreach ($state as $timer) {
    increaseRstate($timer, 1, $rState);
    ++$count;
}

for ($i = 0; $i < INITIAL_DAYS; ++$i) {
    $newState = [];
    foreach ($rState as $timer => $value) {
        if (0 === $timer) {
            increaseRstate(INITIAL_TIMER, $value, $newState);
            increaseRstate(REPRODUCTION_TIMER, $value, $newState);
            $count += $value;
        }
        else {
            increaseRstate($timer - 1, $value, $newState);
        }
    }
    $rState = $newState;
}

echo PHP_EOL . 'Iterative: ' . $count . PHP_EOL;

