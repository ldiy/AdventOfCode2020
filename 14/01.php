<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$memory = array();
$AND_mask = 0;
$OR_mask = 0;
foreach ($lines as $line) {
    [$command, $value] = explode(' = ', $line);

    if ($command == "mask") {
        $AND_mask = (binary) intval(str_replace('X', '1', $value), 2);
        $OR_mask = (binary) intval(str_replace('X', '0', $value), 2);
    } else {
        $adress = explode('[', str_replace(']', '', $command))[1];
        $memory[$adress] = ((intval($value) & $AND_mask) | $OR_mask);
    }
}

$part1 = array_sum($memory);
echo "Part 1: " . $part1 . "\n";
