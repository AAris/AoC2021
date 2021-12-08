#!/usr/bin/php
<?php

require 'utils.php';

$rangeStart = PHP_INT_MAX;
$rangeEnd = 0;

$line = readline();
if (FALSE !== $line) {
    $state = explode(',', $line);
    foreach ($state as &$value) {
        $value = intval($value);
        if ($value < $rangeStart)
            $rangeStart = $value;
        else if ($value > $rangeEnd)
            $rangeEnd = $value;
    }
}

$minFuel = PHP_INT_MAX;
$minPosition = NULL;
for ($i = $rangeStart; $i <= $rangeEnd; ++$i) {
    $fuel = 0;
    foreach ($state as $position) {
        $fuel += abs($position - $i);
    }
    if ($fuel < $minFuel) {
        $minFuel = $fuel;
        $minPosition = $i;
    }
}

print PHP_EOL . $minFuel . ' flat fuel at position ' . $minPosition . PHP_EOL;

$minFuel = PHP_INT_MAX;
$minPosition = NULL;
for ($i = $rangeStart; $i <= $rangeEnd; ++$i) {
    $fuel = 0;
    foreach ($state as $position) {
        $diff = abs($position - $i);
        $fuel += ($diff * ($diff + 1))/2;
    }
    if ($fuel < $minFuel) {
        $minFuel = $fuel;
        $minPosition = $i;
    }
}

print PHP_EOL . $minFuel . ' exponential fuel at position ' . $minPosition . PHP_EOL;
