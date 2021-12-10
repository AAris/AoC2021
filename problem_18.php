#!/usr/bin/php
<?php

require 'utils.php';

const MAX_HEIGHT = 9;
const TOP_CUT = 3;
const DIRS = [[1, 0], [0, 1], [-1, 0], [0, -1], /*[1, 1], [-1, -1], [1, -1], [-1, 1]*/];

$heightMap = [];
$boardVisits = [];
$ranks = [0, 0, 0];

while (FALSE !== ($values = readline())) {
    $values = str_split($values);
    $values = array_map('intval', $values);
    $heightMap[] = $values;
}
foreach($heightMap as $r => $row) {
    foreach ($row as $c => $height) {
        if(!isset($boardVisits[$r][$c])) {
            $size = calcBasin($r, $c, $heightMap, $boardVisits);
            for ($i = 0; $i < TOP_CUT; ++$i) {
                if ($size > $ranks[$i]) {
                    array_splice($ranks, $i, 0, $size);
                    break;
                }
            }
        }

    }
}

$sum = 1;
for ($i = 0; $i < TOP_CUT; ++$i)
    $sum *= $ranks[$i];

print PHP_EOL . $sum . PHP_EOL;




function calcBasin(int $r, int $c, array $heightMap, array &$boardVisits) : int {

    $boardVisits[$r][$c] = TRUE;

    if (MAX_HEIGHT !== $heightMap[$r][$c]) {
        $size = 0;
        foreach (DIRS as $dir) {
            $tmpr = $r + $dir[0];
            $tmpc = $c + $dir[1];
            if (!($tmpr < 0 || $tmpc < 0 || $tmpr >= count($heightMap) || $tmpc >= count($heightMap[$tmpr]))) {
                if (!isset($boardVisits[$tmpr][$tmpc])) {
                    $size += calcBasin($tmpr, $tmpc, $heightMap, $boardVisits);
                }
            }
        }

        return $size + 1;
    }
    else
        return 0;
    
}