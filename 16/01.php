<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$rules = array();
$nearby_rickets = array();
$rules_loaded = false;
$your_ticket_loaded = false;
$nearby_rickets_loaded = false;
foreach ($lines as $line) {
    if (!$rules_loaded) {
        if($line == "") $rules_loaded = true;
        else {
            [$name, $ranges] = explode(':', str_replace(' ', '', $line));
            $ranges = explode('or', $ranges);
            $rule1 = explode('-', $ranges[0]);
            $rule2 = explode('-', $ranges[1]);
            $rules[$name] = array($rule1, $rule2);
        }
    } elseif (!$your_ticket_loaded) {
        if($line == "") $your_ticket_loaded = true;
    } elseif (!$nearby_rickets_loaded) {
        if($line != "nearby tickets:"){
            array_push($nearby_rickets,explode(',',$line));
        }
    }
}
$part1 = 0;
foreach ($nearby_rickets as $ticket) {
    foreach ($ticket as $field) {
        $valid = false;
        foreach ($rules as $rule) {
            if (($rule[0][0] <= $field && $field <= $rule[0][1]) || ($rule[1][0] <= $field && $field <= $rule[1][1])) $valid = true;
        }
        if (!$valid) $part1 += $field;
    }
}



echo "Part 1:" . $part1 . "\n";