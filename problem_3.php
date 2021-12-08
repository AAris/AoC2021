#!/usr/bin/php
<?php

require 'utils.php';

$depth = 0;
$horizontal = 0;

while (NULL !== ($words = read_words())) {
    switch ($words[0]) {
        case 'forward':
            $horizontal += intval($words[1]);
        break;

        case 'up':
            $depth -= intval($words[1]);
        break;

        case 'down':
            $depth += intval($words[1]);
        break;
    }
}

echo $depth * $horizontal;