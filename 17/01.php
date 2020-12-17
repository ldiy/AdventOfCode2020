<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$cubes = []; //[z][y][x]
$cubes[0] = [];
$s = count($lines);
foreach ($lines as $y_key=>$line) {
    $cubes[0][$y_key] = [];
    foreach(str_split($line) as $x_key=>$x)
        if($x == '#') $cubes[0][$y_key][$x_key] = true;
}


function cubes_arround($length, $pos, &$addresses) {
    static $bit = [];
    static $source = [1, 0, -1];
    $pos++;
    for($i = 0; $i < 3; $i++) {
        $bit[$pos] = $source[$i];
        if ($pos < $length - 1)
            cubes_arround($length, $pos, $addresses);
        else
            array_push($addresses,$bit);
    }
}

function neighors_count(&$cubes, $x, $y, $z, &$vals){
    $n = 0;
    foreach ($vals as $val) {
        if(!($val[1] == 0 && $val[2] == 0 && $val[3] == 0)) {
            if(array_key_exists($z + $val[1], $cubes) && array_key_exists($y + $val[2], $cubes[$z + $val[1]]) && array_key_exists($x + $val[3], $cubes[$z + $val[1]][$y + $val[2]])) {
                $n++;
            }
        }
    }
    return $n;
}

function do_cycle(&$cubes, &$vals) {
    $new = $cubes;
    for($z = -6; $z <= 15; $z++){
        for($y = -6; $y <= 15; $y++){
            for($x = -6; $x <=15; $x++){
                $nc = neighors_count($cubes, $x, $y, $z, $vals);
                if(key_exists($z, $cubes) && key_exists($y, $cubes[$z]) && key_exists($x, $cubes[$z][$y])) {
                    if ($nc != 2 && $nc != 3)
                        unset($new[$z][$y][$x]);
                }
                else{
                    if ($nc == 3)
                        $new[$z][$y][$x] = true;
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
