<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$part1 = 0;
foreach ($lines as $line) {
    $part1 += solve(str_split(str_replace(' ', '', $line)));
}
echo "Part 1: " . $part1 . "\n";

function corresponding_parenthese_position($expression, $i){
    $p = 1;
    $index = $i;
    while ($p != 0){
        $index++;
        if ($expression[$index] == '(') $p++;
        elseif($expression[$index] == ')') $p--;
    }
    return $index;
}

function solve($expression) {
    $result = 0;
    $operator = "";
    for($i = 0; $i < count($expression); $i++) {
        $a = -1;
        if ($expression[$i] == '(') {
            $cpp = corresponding_parenthese_position($expression, $i);
            $inside_p = array_slice($expression, $i +1, $cpp - ($i+1));
            $a = solve($inside_p);
            $i = $cpp;
        } elseif (($expression[$i] == '+')) {
            $operator = "+";
        } elseif ($expression[$i] == '*') {
            $operator = "*";
        } else {
            $a = intval($expression[$i]);
        }
        if($a != -1){
            if($operator == "")
                $result = $a;
            elseif($operator == "+")
                $result += $a;
            elseif($operator == "*")
                $result *= $a;
        }
    }
    return $result;
}