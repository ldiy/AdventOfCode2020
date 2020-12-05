<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);

$seats = array();
foreach ($lines as $line) {
    $col = 0;
    $row = 0;
    $rowL = 0;
    $rowH = 127;
    $collumL = 0;
    $collumH = 7;
    for($i = 0; $i<10; $i++){
        if($line[$i] == 'F') { $rowH    = floor(($rowL + $rowH) / 2);         $row = $rowL;   }
        if($line[$i] == 'B') { $rowL    = ceil(($rowL + $rowH) / 2);          $row = $rowH;   }
        if($line[$i] == 'L') { $collumH = floor(($collumL + $collumH) / 2);   $col = $collumL;}
        if($line[$i] == 'R') { $collumL = ceil(($collumL + $collumH) / 2);    $col = $collumH;}
    }
    $seat_id = $row * 8 + $col;
    array_push($seats,$seat_id);
}

$number_of_seats = count($seats);
sort($seats);

echo "part1: " . $seats[$number_of_seats - 1] . "\n";

$i = 0;
while($seats[$i] + 2 != $seats[$i+1]) $i++;
echo "part2: " . ($seats[$i] + 1) . "\n";