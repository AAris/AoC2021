#!/usr/bin/php
<?php

require 'utils.php';


$len    = 0;
$counts = [];
$ones   = [];
$zeroes = [];

while (FALSE !== ($val = readline())) {
    if (0 === $len)
        $len = strlen($val);

    $val = intval($val, 2);
    $mask = 0b1 << $len - 1;
    if ($val & $mask) $ones[] = $val;
    else $zeroes[] = $val;
}

if (count($zeroes) > count($ones)) {
    $ogr = $zeroes;
    $csr = $ones;
}
else {
    $ogr = $ones;
    $csr = $zeroes;   
}
    

$bit = 1;
while (count($ogr) > 1) {
    $zeroes = $ones = [];
    foreach ($ogr as $val) {
        $mask = 0b1 << ($len - 1 - $bit);
        if ($val & $mask) $ones[] = $val;
        else $zeroes[] = $val;
    }

    if (count($zeroes) > count($ones))
        $ogr = $zeroes;
    else 
        $ogr = $ones;
    ++$bit;
}

$bit = 1;
while (count($csr) > 1) {
    $zeroes = $ones = [];
    foreach ($csr as $val) {
        $mask = 0b1 << ($len - 1 - $bit);
        if ($val & $mask) $ones[] = $val;
        else $zeroes[] = $val;
    }

    if (count($zeroes) > count($ones))
        $csr = $ones;
    else 
        $csr = $zeroes;
    ++$bit;
}

echo (decbin ($ogr[0]) . '||' . decbin($csr[0]) . '||' . $ogr[0] * $csr[0]);

