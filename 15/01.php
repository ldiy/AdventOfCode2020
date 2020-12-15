<?php
$input = [8,13,1,0,18,9];
$k = 2;
for($i = count($input) -1; $i < 2020-1; $i++){
    $c = array_count_values($input)[$input[$i]];
    if($c == 1){
        array_push($input, 0);
    } elseif ($c > 1) {
        $b = array_keys($input,$input[$i]);
        array_push($input, $b[count($b) - 1] + 1 - ($b[count($b) - 2] +1));
    }
}

echo "Part 1: " . end($input) . "\n";