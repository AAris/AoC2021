#!/usr/bin/php
<?php

require 'utils.php';


$counts = [];
$len = 0;
while (FALSE !== ($val = readline())) {
    if (0 === $len)
        $len = strlen($val);

    $val = intval($val, 2);

    for ($i = 0; $i < $len; ++$i) {
        if (!isset($counts[$i])) {
            $counts[$i] = 0;
        }
        $mask = 0b1 << $len - 1 - $i;
        if ($val & $mask) ++$counts[$i];
        else --$counts[$i];
    }
}

$gammaRate = 0b0;

foreach($counts as $index => $count) {
    $mask = 0b1 << (count($counts) - 1 - $index);
    if ($count > 0) $gammaRate = $gammaRate | $mask;
}

$epsilonRate = ~$gammaRate & (2**$len - 1);

$res = $gammaRate * $epsilonRate;

echo (decbin ((2**$len) - 1) . '||' . decbin($gammaRate) . '||' . decbin($epsilonRate) . '||' . $res);