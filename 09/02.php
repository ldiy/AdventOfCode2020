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
    for ($j = $start; $j < $end; $j++) {
        for ($k = $start; $k < $end; $k++) {
            if ($k != $j && $sum == $data[$j] + $data[$k])
                return true;
        }
    }
    return false;
}

function part1($data, $length, $preamble) {
    for ($i = $preamble; $i < $length; $i++) {
        if (!valid($data, $data[$i],$i - $preamble, $i))
            return $data[$i];
    }
    return null;
}

function part2($data, $length, $sum) {
    $sum1 = 0;
    $rm_next = 0;
    for ($i=0; $i<$length; $i++) {
        $sum1 += $data[$i];
        while ($sum1 > $sum) {
            $sum1 -= $data[$rm_next];
            $rm_next++;
        }
        if ($sum1 == $sum) {
            $arr = array_slice($data,$rm_next, $i - $rm_next + 1);
            return min($arr) + max($arr);
        }
    }
    return null;
}

$data = parse_input("input.txt");
$preamble = 25;
$length = count($data);
$part1 = part1($data, $length, $preamble);
$part2 = part2($data, $length, $part1);

echo "part1: " . $part1 . "\n";
echo "part2: " . $part2 . "\n";