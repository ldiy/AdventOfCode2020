<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$black_tiles = [];
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
    foreach($line as $direction){
        switch ($direction) {
            case '1':
                $x += 1;
                $y += 1;
                break;

            case '2':
                $x += 2;
                break;

            case '3':
                $x +=1;
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
    if(in_array([$x,$y], $black_tiles)){
        unset($black_tiles[array_search([$x, $y], $black_tiles)]);
    }
    else{
        array_push($black_tiles, [$x, $y]);
    }
}
print_r($black_tiles);
echo "Part 1: " . count($black_tiles) . "\n";