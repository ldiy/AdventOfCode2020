<?php

function parse_input($filename)
{
    $lines = file($filename, FILE_IGNORE_NEW_LINES);
    $data = array();
    foreach ($lines as $line)
        array_push($data, intval($line));
    return $data;
}


function valid($data, $sum, $start, $end) {
    $valid = false;
    for ($j = $start; $j < $end; $j++) {
        for ($k = $start; $k < $end; $k++) {
            if ($k != $j && $sum == $data[$j] + $data[$k]) {
                $valid = true;
            }
        }
    }
    return $valid;
}


function part1($data, $preamble) {
    $length = count($data);
    for ($i = $preamble; $i < $length; $i++) {
        if (!valid($data, $data[$i],$i - $preamble, $i))
            return $data[$i];
    }
    return null;
}

$data = parse_input("input.txt");
$preamble = 25;
$part1 = part1($data, $preamble);

echo "part1: " . $part1 . "\n";