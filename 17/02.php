<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$cubes = []; //[w][z][y][x]
$cubes[0] = [];
$cubes[0][0] = [];
$s = count($lines);
foreach ($lines as $y_key=>$line) {
    $cubes[0][$y_key] = [];
    foreach(str_split($line) as $x_key=>$x)
        if($x == '#') $cubes[0][0][$y_key][$x_key] = true;
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
            array_push($addresses, $bit);
    }
}

function neighors_count(&$cubes, $x, $y, $z, $w, &$vals){
    $n = 0;
    foreach ($vals as $val) {
        if(!($val[1] == 0 && $val[2] == 0 && $val[3] == 0 && $val[4] == 0)) {
            if(array_key_exists($w + $val[4], $cubes) && array_key_exists($z + $val[1], $cubes[$w + $val[4]]) && array_key_exists($y + $val[2], $cubes[$w + $val[4]][$z + $val[1]]) && array_key_exists($x + $val[3], $cubes[$w + $val[4]][$z + $val[1]][$y + $val[2]]))
                $n++;
        }
    }
    return $n;
}

function do_cycle(&$cubes, &$vals) {
    $new = $cubes;
    for($w = -6; $w <= 15; $w++) {
        for ($z = -6; $z <= 15; $z++) {
            for ($y = -6; $y <= 15; $y++) {
                for ($x = -6; $x <= 15; $x++) {
                    $nc = neighors_count($cubes, $x, $y, $z, $w, $vals);
                    if($nc != 2 && $nc != 3 &&array_key_exists($w, $cubes) && array_key_exists($z, $cubes[$w]) && array_key_exists($y, $cubes[$w][$z]) && array_key_exists($x, $cubes[$w][$z][$y]))
                            unset($new[$w][$z][$y][$x]);
                    elseif ($nc == 3)
                            $new[$w][$z][$y][$x] = true;
                }
            }
        }
    }
    $cubes = $new;
}

$vals = [];
cubes_arround(5,0,$vals);

// 6 cycles
for($i = 0; $i < 6; $i++)
    do_cycle($cubes,$vals);

// Count active cubes
$part2 = 0;
for($w = -6; $w <= 15; $w++) {
    for ($z = -6; $z <= 15; $z++) {
        for ($y = -6; $y <= 15; $y++) {
            for ($x = -6; $x <= 15; $x++) {
                if(array_key_exists($w, $cubes) && array_key_exists($z, $cubes[$w]) && array_key_exists($y, $cubes[$w][$z]) && array_key_exists($x, $cubes[$w][$z][$y]))
                    $part2++;
            }
        }
    }
}

echo "Part 2: " .$part2 . "\n";