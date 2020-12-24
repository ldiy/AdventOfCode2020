<?php

$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$black_tiles = [];
$days = 100;

foreach ($lines as $line) {
    // e, se, sw, w, nw, ne
    $line = str_replace("ne", '1', $line);
    $line = str_replace("nw", '6', $line);
    $line = str_replace("se", '3', $line);
    $line = str_replace("sw", '4', $line);
    $line = str_replace("e", '2', $line);
    $line = str_replace("w", '5', $line);

    $line = str_split($line);
    $x = 0;
    $y = 0;
    foreach ($line as $direction) {
        switch ($direction) {
            case '1':
                $x += 1;
                $y += 1;
                break;

            case '2':
                $x += 2;
                break;

            case '3':
                $x += 1;
                $y -= 1;
                break;

            case '4':
                $x -= 1;
                $y -= 1;
                break;

            case '5':
                $x -= 2;
                break;

            case '6':
                $x -= 1;
                $y += 1;
                break;
        }
    }
    if (in_array([$x, $y], $black_tiles)) {
        unset($black_tiles[array_search([$x, $y], $black_tiles)]);
    } else {
        array_push($black_tiles, [$x, $y]);
    }
}

function dimensions(&$black_tiles){
    $max_x = 0;
    $min_x = 0;
    $max_y = 0;
    $min_y = 0;
    foreach ($black_tiles as $tile) {
        $max_x = max($max_x, $tile[0]);
        $min_x = min($min_x, $tile[0]);
        $max_y = max($max_y, $tile[1]);
        $min_y = min($min_y, $tile[1]);
    }
    return [$min_x, $max_x, $min_y, $max_y];
}

function count_adjacent_tiles(&$tiles, $x, $y) {
    $n = 0;
    if (in_array([$x + 1, $y + 1], $tiles)) $n++;
    if (in_array([$x + 2, $y], $tiles)) $n++;
    if (in_array([$x + 1, $y - 1], $tiles)) $n++;
    if (in_array([$x - 1, $y - 1], $tiles)) $n++;
    if (in_array([$x - 2, $y], $tiles)) $n++;
    if (in_array([$x - 1, $y + 1], $tiles)) $n++;
    return $n;
}

for($i = 0; $i<$days; $i++) {
    $dimensions = dimensions($black_tiles);
    $new_tiles = $black_tiles;
    for($y = $dimensions[2] - 2; $y < $dimensions[3] + 2; $y++) {
        $a = 0;
        $b = 2;
        if($y % 2 == 0) $a = 1;
        if($dimensions[0] % 2 == 0) $b = 1;
        for($x = $dimensions[0] - $b - $a; $x < $dimensions[1] + 3; $x+=2) {
            $cnt = count_adjacent_tiles($black_tiles, $x, $y);

            if($cnt > 2 || $cnt == 0){
                if(in_array([$x, $y], $black_tiles)) {
                    unset($new_tiles[array_search([$x, $y], $black_tiles)]);
                }
            }
            if ($cnt == 2 && !in_array([$x, $y], $black_tiles)) {
                array_push($new_tiles,[$x, $y]);
            }
        }
    }
    $black_tiles = $new_tiles;
}

echo "Part 1: " . count($black_tiles) . "\n";