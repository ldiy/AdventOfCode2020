<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$depart = intval($lines[0]);
$buses = explode(',', str_replace('x,', '', $lines[1]));
$max = 0;
$bus_e = 0;
foreach ($buses as $bus) {
    if($depart % $bus > $max){
        $max = $depart % $bus;
        $bus_e = $bus;
    }
}

echo "Part 1: " .  (($bus_e - $max) * $bus_e) . "\n";