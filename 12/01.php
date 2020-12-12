<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);

$curr_rotation = 0;
$curr_x = 0;
$curr_y = 0;
foreach ($lines as $line) {
    $action = $line[0];
    $value = intval(substr($line,1));

    switch ($action){
        case 'N':
            $curr_y += $value;
            break;
        case 'S':
            $curr_y -= $value;
            break;
        case 'E':
            $curr_x += $value;
            break;
        case 'W':
            $curr_x -= $value;
            break;

        case 'L':
            $curr_rotation += $value;
            break;
        case 'R':
            $curr_rotation -= $value;
            break;
        case 'F':
            $curr_x += cos(deg2rad($curr_rotation)) * $value;
            $curr_y += sin(deg2rad($curr_rotation)) * $value;
            break;
    }
}

echo "Part1: " . (abs($curr_y) + abs($curr_x)) ."\n";
