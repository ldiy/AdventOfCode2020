<?php
$map = array();
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$result = 0;
$x_size = 0;
$y_size = 0;
foreach($lines as $n1) {
    $chars = str_split($n1);
    $map[$y_size] = $chars;
    $y_size++;
}
$x_size = count($map[0]);

$y_pos = 0;
$x_pos = 0;

while($y_pos < $y_size - 1){
    $y_pos += 1;
    $x_pos += 3;
    if($x_pos >= $x_size){
        $x_pos -= $x_size;
    }

    if($map[$y_pos][$x_pos] == "#"){
        $result += 1;
    }
}
echo $result;