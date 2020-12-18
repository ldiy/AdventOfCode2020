<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$part2 = 0;
foreach ($lines as $line) {
    $part2 += solve(str_split(place_extra_parentheses(str_replace(' ', '', $line))));
}

echo "Part 2: " . $part2 . "\n";


function corresponding_parenthese_position($expression, $i): int
{
    $p = 1;
    $index = $i;
    while ($p != 0){
        $index++;
        if ($expression[$index] == '(') $p++;
        elseif($expression[$index] == ')') $p--;
    }
    return $index;
}

function place_extra_parentheses($expression_str): string
{
    $new_expression = "";
    $open = 0;
    $expression = str_split($expression_str);
    for($i = 0; $i < count($expression); $i++) {
        if ($expression[$i] != '*' && $expression[$i] != '+'){
            $new_expression .= '(';
            $open++;
        }
        if ($expression[$i] == '(') {
            $cpp = corresponding_parenthese_position($expression, $i);
            $inside_p = array_slice($expression, $i + 1, $cpp - ($i + 1));
            $new_expression .= '(';
            $new_expression .= place_extra_parentheses(implode($inside_p));
            $i = $cpp;
        }
        if ($expression[$i] == '*'){
            while($open != 0) {
                $new_expression .= ')';
                $open--;
            }
        }
        $new_expression .= $expression[$i];
    }
    while($open != 0) {
        $new_expression .= ')';
        $open--;
    }
    return $new_expression;
}

function solve($expression): int
{
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