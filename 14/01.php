<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$memory = array();
$AND_mask = 0b111111111111111111111111111111111111;
$OR_mask = 0b000000000000000000000000000000000000;
foreach ($lines as $line) {
    [$command, $value] = explode(' = ', $line);

    if ($command == "mask") {
        $AND_mask = (binary) intval(str_replace(['X', '1'], '1', $value), 2);
        $OR_mask = (binary) intval(str_replace(['X', '0'], '0', $value), 2);
    } else {
        $adress = explode('[', str_replace(']', '', $command))[1];
        $new_value = ((intval($value) & $AND_mask) | $OR_mask);
        if (array_key_exists($adress, $memory)) {
            $memory[$adress] = ($memory[$adress] & $new_value) | $new_value;
        } else {
            $memory[$adress] = $new_value;
        }
    }
}

$part1 = array_sum($memory);
print_r($memory);
echo "Part 1: " . $part1 . "\n";
