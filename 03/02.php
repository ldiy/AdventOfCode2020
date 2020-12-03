<?php

$map = array();
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$result = 1;
$x_size = 0;
$y_size = 0;
foreach($lines as $n1) {
    $chars = str_split($n1);
    $map[$y_size] = $chars;

    $y_size++;

}
$x_size = count($map[0]);

$slopes = array(array(1,1), array(3,1), array(5,1), array(7,1), array(1,2));
foreach ($slopes as $slope) {
    $y_pos = 0;
    $x_pos = 0;
    $slope_res = 0;
    while ($y_pos < $y_size - 1) {
        $y_pos += $slope[1];
        $x_pos += $slope[0];
        if ($x_pos >= $x_size) {
            $x_pos -= $x_size;
        }

        if ($map[$y_pos][$x_pos] == "#") {
            $slope_res += 1;
        }
    }
    $result *= $slope_res;
}

echo $result;