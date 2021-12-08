#!/usr/bin/php
<?php

require 'utils.php';

$ret = 0;
$depth = 0;
$horizontal = 0;
$aim = 0;

while (NULL !== ($words = read_words())) {
    switch ($words[0]) {
        case 'forward':
            $horizontal += intval($words[1]);
            $depth += $aim * intval($words[1]);
        break;

        case 'up':
            $aim -= intval($words[1]);
        break;

        case 'down':
            $aim += intval($words[1]);
        break;
    }
}

echo $depth * $horizontal;