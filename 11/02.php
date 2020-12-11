<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$floormap = array();
$y_size = 0;
$x_size = 0;
foreach ($lines as $line) {
    array_push($floormap,str_split($line));
    $y_size++;
}
$x_size = count($floormap[0]);

function n_seats_around(&$map, $x, $y, $x_size, $y_size) {
    $n = 0;
    $ok = 0;
    for($i=1; $x-$i >= 0 && $y-$i >= 0; $i++ ) {
        if ($map[$y - $i][$x - $i] == '#') $ok = 1;
        if ($map[$y - $i][$x - $i] == 'L') break;
    }
    if ($ok) $n++;

    $ok = 0;
    for($i=1; $y-$i >= 0; $i++ ) {
        if ($map[$y - $i][$x] == '#') $ok = 1;
        if ($map[$y - $i][$x] == 'L') break;
    }
    if ($ok) $n++;

    $ok = 0;
    for($i=1; $x+$i < $x_size  && $y-$i >= 0; $i++ ) {
        if ($map[$y - $i][$x + $i] == '#') $ok = 1;
        if ($map[$y - $i][$x + $i] == 'L') break;
    }
    if ($ok) $n++;

    $ok = 0;
    for($i=1; $x-$i >= 0; $i++ ) {
        if ($map[$y][$x - $i] == '#') $ok = 1;
        if ($map[$y][$x - $i] == 'L') break;
    }
    if ($ok) $n++;

    $ok = 0;
    for($i=1; $x+$i < $x_size; $i++ ) {
        if ($map[$y][$x + $i] == '#') $ok = 1;
        if ($map[$y][$x + $i] == 'L') break;
    }
    if ($ok) $n++;

    $ok = 0;
    for($i=1; $x-$i >= 0 && $y+$i < $y_size ; $i++ ) {
        if ($map[$y + $i][$x - $i] == '#') $ok = 1;
        if ($map[$y + $i][$x - $i] == 'L') break;
    }
    if ($ok) $n++;

    $ok = 0;
    for($i=1; $y+$i < $y_size; $i++ ) {
        if ($map[$y + $i][$x] == '#') $ok = 1;
        if ($map[$y + $i][$x] == 'L')  break;
    }
    if ($ok) $n++;

    $ok = 0;
    for($i=1; $x+$i < $x_size && $y+$i < $y_size; $i++ ) {
        if ($map[$y + $i][$x + $i] == '#') $ok = 1;
        if ($map[$y + $i][$x + $i] == 'L') break;
    }
    if ($ok) $n++;

    return $n;
}

for(;;){
    $new_map = $floormap;
    for ($y = 0; $y < $y_size; $y++) {
        for ($x = 0; $x < $x_size; $x++) {
            if ($floormap[$y][$x] == 'L') {
                if (n_seats_around($floormap, $x, $y, $x_size, $y_size) == 0)
                    $new_map[$y][$x] = '#';
            } elseif ($floormap[$y][$x] == '#') {
                if (n_seats_around($floormap, $x, $y, $x_size, $y_size) >= 5)
                    $new_map[$y][$x] = 'L';
            }
        }
    }
    if($floormap == $new_map) {
        break;
    }
    $floormap = $new_map;
}

$result=0;
foreach ($floormap as $line){
    $arr = array_count_values($line);
    if(array_key_exists('#', $arr))
        $result += $arr['#'];
}
echo "Part 2: ". $result . "\n";