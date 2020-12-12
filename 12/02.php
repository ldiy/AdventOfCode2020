<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);

$waypoint_x = 10;
$waypoint_y = 1;

$start_x = 0;
$start_y = 0;

foreach ($lines as $line) {
    $action = $line[0];
    $value = intval(substr($line, 1));

    switch ($action) {
        case 'N':
            $waypoint_y += $value;
            break;
        case 'S':
            $waypoint_y -= $value;
            break;
        case 'E':
            $waypoint_x += $value;
            break;
        case 'W':
            $waypoint_x -= $value;
            break;

        case 'R':
            $value = 360 - $value;
        case 'L':
            for($i=0; $i< $value/90; $i++)
                [$waypoint_x, $waypoint_y] = [-1 * $waypoint_y, $waypoint_x];
            break;

        case 'F':
            $start_x -= $value * $waypoint_x;
            $start_y -= $value * $waypoint_y;
            break;

    }
}

echo "Part2: " . (abs($start_x) + abs($start_y)) . "\n";
