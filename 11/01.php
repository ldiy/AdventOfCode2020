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
    if ($x > 0 && $y > 0 && $map[$y-1][$x-1] == '#') $n++;
    if ($y > 0 && $map[$y-1][$x] == '#') $n++;
    if ($x < $x_size - 1 && $y > 0 && $map[$y-1][$x+1] == '#') $n++;
    if ($x > 0 && $map[$y][$x-1] == '#') $n++;
    if ($x < $x_size -1 && $map[$y][$x+1] == '#') $n++;
    if ($x > 0 && $y < $y_size - 1 && $map[$y+1][$x-1] == '#') $n++;
    if ($y < $y_size - 1 && $map[$y+1][$x] == '#') $n++;
    if ($x < $x_size -1 && $y <$y_size - 1 && $map[$y+1][$x+1] == '#') $n++;
    return $n;
}
function print_map(&$map){
    foreach ($map as $line){
        echo implode($line) . "\n";
    }
    echo "\n";
}
while (true) {
    $new_map = $floormap;
    for ($y = 0; $y < $y_size; $y++) {
        for ($x = 0; $x < $x_size; $x++) {
            if ($floormap[$y][$x] == 'L') {
                if (n_seats_around($floormap, $x, $y, $x_size, $y_size) == 0)
                    $new_map[$y][$x] = '#';
            } elseif ($floormap[$y][$x] == '#') {
                if (n_seats_around($floormap, $x, $y, $x_size, $y_size) >= 4)
                    $new_map[$y][$x] = 'L';
            }
        }
    }
    //print_map($new_map);
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
echo "Part1: ". $result . "\n";