#!/usr/bin/php
<?php

require 'utils.php';

$ret = 0;

$prevValues = [];
$possibleMins = [];
$riskSum = 0;
while (FALSE !== ($values = readline())) {
    $values = str_split($values);

    $values = array_map('intval', $values);

    foreach($possibleMins as $position => $min) {
        if ($min < $values[$position])
            $riskSum += $min + 1;
    }

    $possibleMins = getMins($values, $prevValues);

    $prevValues = $values;
}

// Last iteration just sum all possible mins.
foreach ($possibleMins as $min)
    $riskSum += $min + 1; 

function getMins(array $values, array $previous = []) : array {
    $ret = [];
    $len = count($values);
    for ($i = 0; $i < $len; ++$i) {
        $min = TRUE;
        if ($i > 0)
            $min = $min && ($values[$i] < $values[$i-1]);

        if ($i < $len - 1)
            $min = $min && ($values[$i] < $values[$i+1]);

        if (!empty($previous))
            $min = $min && ($values[$i] < $previous[$i]);


        if ($min)
            $ret[$i] = $values[$i];
    }

    return $ret;
}


echo PHP_EOL . $riskSum . PHP_EOL;