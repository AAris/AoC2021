<?php

function read_array() : array {
    $ret = [];

    while (FALSE !== ($arg = readline())) {
        $ret[] = trim($arg);
    }

    return $ret;

}

function read_numbers(string $separator = ' ') : array { 
    $ret = [];
    $line = readline();
    if (FALSE !== $line) {
        $ret = explode($separator, $line);
        $ret = array_map('intval', $ret);
    }

    return $ret;
}

function read_words(string $separator = ' ') : ?array {
    if (FALSE === ($line = readline())) {
        return NULL;
    }

    return explode($separator, $line);
}

function get_last_sum(int $index, array $values, int $n_values) : ?int {
    if ($index < $n_values - 1) {
        return NULL;
    }
    $ret = 0;
    for ($i = 0; $i < $n_values; ++$i) {
        $ret += intval($values[$index - $i]);
    }

    return $ret;
}

function read_vectors() : array {
    $ret = [];
    while (FALSE !== ($line = readline())) {
        $parts = explode('->', $line);
        $coord1 = explode(',', trim($parts[0]));
        $coord1 = array_map('intval', $coord1);
        $coord2 = explode(',', trim($parts[1]));
        $coord2 = array_map('intval', $coord2);

        $ret[] = [$coord1, $coord2];
    }

    return $ret;
}

function sortString(string $string) : string {
    $chars = str_split($string);
    sort($chars);
    return implode($chars);
}


