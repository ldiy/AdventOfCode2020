<?php

function parse_input($filename): array
{
    $lines = file($filename, FILE_IGNORE_NEW_LINES);
    $adapters = array();
    foreach ($lines as $line)
        array_push($adapters, intval($line));

    array_push($adapters,0); // To outlet
    array_push($adapters,max($adapters)+3); // Adapter in device

    sort($adapters);
    return $adapters;
}

function part1(&$adapters, $length): int
{
    $jolts1 = 0;
    $jolts3 = 0;

    for($i = 0; $i < $length - 1; $i++) {
        if($adapters[$i] == $adapters[$i+1] - 1)
            $jolts1++;
        if( $adapters[$i] == $adapters[$i+1] - 3)
            $jolts3++;
    }

    return $jolts1 * $jolts3;
}

function find_next(&$adapters, &$found, $length , $i) {
    $possible = array();

    if($i < $length - 3 && $adapters[$i+3] - $adapters[$i] <= 3){
        array_push($possible, $i+3);
        array_push($possible, $i+2);
        array_push($possible, $i+1);
    }
    elseif($i < $length - 2 && $adapters[$i+2] - $adapters[$i] <= 3){
        array_push($possible, $i+2);
        array_push($possible, $i+1);
    }
    elseif($i < $length - 1 && $adapters[$i+1] - $adapters[$i] <= 3){
        array_push($possible, $i+1);
    }

    $n = 0;
    foreach ($possible as $p) {
        // Check if not in cache
        if(!array_key_exists($p, $found))
            $found[$p] = find_next($adapters,$found, $length, $p);
        $n += $found[$p];
    }

    if ($n == 0)    // This is the last one
        return 1;

    return $n;

}

$adapters = parse_input("input.txt");
$length = count($adapters);
$found = array();

$part1 = part1($adapters, $length);
$part2 = find_next($adapters,$found, $length, 0);
echo "Part 1: " . $part1 . "\n";
echo "Part 2: " . $part2 . "\n";