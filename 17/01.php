<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$cubes = []; //[z][y][x]
$cubes[0] = [];
$s = count($lines);
foreach ($lines as $y_key=>$line) {
    $cubes[0][$y_key] = [];
    //array_push($cubes[0], str_split($line));
    foreach(str_split($line) as $x_key=>$x){
        if($x == '#') $cubes[0][$y_key][$x_key] = true;
    }
}


function cubes_arround($length, $pos, &$addresses) {
    static $bit = [];
    static $source = [1, 0, -1];
    $pos++;
    for($i = 0; $i < 3; $i++) {
        $bit[$pos] = $source[$i];
        if ($pos < $length - 1) {
            cubes_arround($length, $pos, $addresses);
        } else {
            array_push($addresses,$bit);
        }
    }
}

function neighors_count(&$cubes, $x, $y, $z, &$vals){
    //echo "\tx: " . $x . " y: " . $y . " z: " . $z . "\n";
    $n = 0;
    foreach ($vals as $val) {
        if(!($val[1] == 0 && $val[2] == 0 && $val[3] == 0)) {
            if(array_key_exists($z + $val[1], $cubes) && array_key_exists($y + $val[2], $cubes[$z + $val[1]]) && array_key_exists($x + $val[3], $cubes[$z + $val[1]][$y + $val[2]])) {
                $n++;
                //echo "Zwanda: " . ($val[1]+ $z) . " tjYp: " . ($val[2] + $y) . " fiX: " . ($val[3] + $x) . "\n";
            }
        }
    }
    //echo "n: ". $n . "\n";
    return $n;
}

function outer_dimensions(&$cubes){
    $dimensions = [[0,0], [0,0], [0,0]];
    $dimensions[0][0] = min(array_keys($cubes));
    $dimensions[0][1] = max(array_keys($cubes));
    for($z = $dimensions[0][0]; $z <= $dimensions[0][1]; $z++) {
        $dimensions[1][0] = min($dimensions[1][0], min(array_keys($cubes[$z])));
        $dimensions[1][1] = max($dimensions[1][1], max(array_keys($cubes[$z])));
        for ($y = $dimensions[1][0]; $y <= $dimensions[1][1]; $y++) {
            $dimensions[2][0] = min($dimensions[2][0], min(array_keys($cubes[$z][$y])));
            $dimensions[2][1] = max($dimensions[2][1], max(array_keys($cubes[$z][$y])));
        }
    }
    return $dimensions;
}
function do_cycle(&$cubes, &$vals) {
    $new = $cubes;

    //$dim = outer_dimensions($cubes);
    for($z = -6; $z <= 15; $z++){
        for($y = -6; $y <= 15; $y++){
            for($x = -6; $x <=15; $x++){
                $nc = neighors_count($cubes, $x, $y, $z, $vals);
                if(key_exists($z, $cubes) && key_exists($y, $cubes[$z]) && key_exists($x, $cubes[$z][$y])) {
                    //echo "x: " . $x . " y: " . $y . " z: " . $z . " |n: " .  $nc."\n";
                    if ($nc != 2 && $nc != 3) {
                        unset($new[$z][$y][$x]);
                        if(array_keys($new[$z][$y]) == NULL) {
                            unset($new[$z][$y]);
                            if(array_keys($new[$z]) == NULL) {
                                unset($new[$z]);
                            }
                        }
                    }
                }
                else{
                    if ($nc == 3) {
                        $new[$z][$y][$x] = true;
                    }
                }
            }
        }
    }
    $cubes = $new;
    print_r($cubes);
}

$vals = [];
cubes_arround(4,0,$vals);
for($i = 0; $i < 6; $i++){
    do_cycle($cubes,$vals);
}
print_r($cubes);
//$dim = outer_dimensions($cubes);
$part1 = 0;
for($z = -6; $z <= 15; $z++) {
    for ($y = -6; $y <= 15 ; $y++) {
        for ($x = -6 ; $x <= 15; $x++) {
            $nc = neighors_count($cubes, $x, $y, $z, $vals);
            if (key_exists($z, $cubes) && key_exists($y, $cubes[$z]) && key_exists($x, $cubes[$z][$y])) {
                $part1++;
            }
        }
    }
}
echo "Part 1: " .$part1 . "\n";
