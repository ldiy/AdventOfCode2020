<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);

$seats = array();
foreach ($lines as $line)
    array_push($seats, bindec(str_replace(array('R', 'L', 'B', 'F'), array('1', '0', '1', '0'), $line)));

echo "part1: " . max($seats) . "\n";

sort($seats);
$i = 0;
while($seats[$i] + 2 != $seats[$i+1]) $i++;
echo "part2: " . ($seats[$i] + 1) . "\n";