#!/usr/bin/php
<?php

require 'utils.php';

$ret = 0;

$args = read_array();

if (!empty($args)) {
    $lastValue = intval(array_shift($args));
    foreach ($args as $arg) {
        $value = intval($arg);
        if ($value > $lastValue) ++$ret;
        $lastValue = $value;
    }
}


echo $ret;