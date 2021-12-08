#!/usr/bin/php
<?php

require 'utils.php';

$vectors = read_vectors();

$grid = [];
$max = 0;
$count2 = 0;
foreach ($vectors as $vector) {
    if ($vector[0][0] === $vector[1][0]) {
        $index = 1;
    }
    elseif ($vector[0][1] === $vector[1][1]) {
        $index = 0;
    }
    else {
        $index = NULL;
    }

    if (NULL !== $index) {
        $diff = abs($vector[0][$index] - $vector[1][$index]);
        $point[abs($index - 1)] = $vector[0][abs($index - 1)];
        $point[$index] = min($vector[0][$index], $vector[1][$index]);

        for ($i = 0; $i <= $diff; ++$i) {

            if (!isset($grid[$point[0]][$point[1]])) {
                $grid[$point[0]][$point[1]] = 1;
            }
            else {
                $grid[$point[0]][$point[1]] +=1;
            }
            if (2 === $grid[$point[0]][$point[1]])
                ++$count2;

            $point[$index] += 1;
        }
    }
    else {
        $diff = abs($vector[0][0] - $vector[1][0]);
        $point = $vector[0];
        for ($i = 0; $i <= $diff; ++ $i) {
            if (!isset($grid[$point[0]][$point[1]])) {
                $grid[$point[0]][$point[1]] = 1;
            }
            else {
                $grid[$point[0]][$point[1]] +=1;
            }
            if (2 === $grid[$point[0]][$point[1]])
                ++$count2;

            if ($point[0] < $vector[1][0])
                $point[0] += 1;
            else
                $point[0] -= 1;
            
            if ($point[1] < $vector[1][1])
                $point[1] += 1;
            else
                $point[1] -= 1;
        }
    }
    

}

echo PHP_EOL . $count2 . PHP_EOL;

