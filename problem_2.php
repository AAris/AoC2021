#!/usr/bin/php
<?php

require 'utils.php';

const N_VALUES = 3;

$ret = 0;

$args = read_array();

if (!empty($args)) {
    $lastValue = NULL;
    foreach ($args as $i => $arg) {

        $value = get_last_sum($i, $args, N_VALUES);
        if (NULL !== $lastValue && $lastValue < $value) {
            ++$ret;
        }
        $lastValue = $value;
    }
}


echo $ret;