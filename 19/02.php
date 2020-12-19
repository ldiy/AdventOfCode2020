<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$rules = [];
$messages = [];

$rules_read = false;
foreach ($lines as $line) {
    if($line == "") {
        $rules_read = true;
    } else {
        if (!$rules_read) {
            [$rule_number, $vals] = explode(': ', str_replace('"','',$line));
            $vals = explode(' | ', $vals);
            for ($i = 0; $i < count($vals); $i++) {
                $vals[$i] = explode(' ',$vals[$i]);
                if($vals[$i][0] == '"')
                    $vals[$i] = [$vals[$i][1]];
            }
            $rules[$rule_number] = $vals;
        } else {
            array_push($messages, $line);
        }
    }
}

function gen_combos($arrays, &$res, $i = 0, $comb = "") {
    foreach ($arrays[$i] as $n1) {
        if($i == count($arrays) -1 )
            array_push($res, $comb . $n1);
        else
            gen_combos($arrays, $res, $i + 1, $comb . $n1);
    }
}

function gen_matches($rule_number, &$rules, $depth = 0){
    if($rules[$rule_number][0][0] == 'a' || $rules[$rule_number][0][0] == 'b') return $rules[$rule_number][0];

    $matches = array();
    foreach ($rules[$rule_number] as $or_rule){
        $t_arr = [];
        foreach ($or_rule as $next_rule){
            $d = gen_matches($next_rule, $rules, $depth + 1);
            array_push($t_arr, $d);
        }
        $combinations = [];
        gen_combos($t_arr,$combinations);
        foreach ($combinations as $combo)
            array_push($matches, $combo);
    }
    return($matches);
}


$r42 = gen_matches(42, $rules);
$r31 = gen_matches(31, $rules);

$part1 = 0;
foreach ($messages as $message) {

    $m = strrev($message);
    $r31_check = false;

    // Check r31
    $r31_n = 0;
    $r31_len = strlen($r31[0]);
    $ok = true;
    while ($ok) {
        $fp = strrev(substr($m, 0, $r31_len));
        $ok = false;
        foreach ($r31 as $r) {
            if ($fp == $r) {
                $r31_check = true;
                $r31_n++;
                $ok = true;
                $m = substr($m, $r31_len);
                break;
            }
        }

    }
    if ($r31_check) {

        $r42_n = 0;
        $r42_len = strlen($r42[0]);
        $ok = true;
        while ($ok) {
            $fp = strrev(substr($m, 0, $r42_len));
            $ok = false;
            foreach ($r42 as $r) {
                if ($fp == $r) {
                    $r42_n++;
                    $ok = true;
                    $m = substr($m, $r42_len);
                    break;
                }
            }

        }
        if ($r31_n < $r42_n) {
            if ($m == "")
                $part1++;
        }
    }
}
echo "Part 1: $part1 \n";