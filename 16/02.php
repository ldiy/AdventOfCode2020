<?php
function parse_input($filename, &$rules, &$nearby_tickets, &$your_ticket) {
    $lines = file($filename, FILE_IGNORE_NEW_LINES);

    $rules_loaded = false;
    $your_ticket_loaded = false;
    foreach ($lines as $line) {
        if (!$rules_loaded) {
            if ($line == "") {
                $rules_loaded = true;
            } else {
                [$name, $ranges] = explode(':', str_replace(' ', '', $line));
                $ranges = explode('or', $ranges);
                $rule1 = explode('-', $ranges[0]);
                $rule2 = explode('-', $ranges[1]);
                $rules[$name] = array($rule1, $rule2);
            }
        }
        elseif (!$your_ticket_loaded) {
            if ($line == "")
                $your_ticket_loaded = true;
            else
                $your_ticket = explode(',', $line);
        }
        else {
            if ($line != "nearby tickets:")
                array_push($nearby_tickets, explode(',', $line));
        }
    }
}

function valid_tickets($tickets, $rules) {
    $valid_tickets = array();
    foreach ($tickets as $ticket) {
        $valid = true;
        foreach ($ticket as $field) {
            $valid_field = false;
            foreach ($rules as $rule) {
                if (($rule[0][0] <= $field && $field <= $rule[0][1]) || ($rule[1][0] <= $field && $field <= $rule[1][1])) $valid_field = true;
            }
            if (!$valid_field) $valid = false;
        }
        if ($valid) array_push($valid_tickets,$ticket);
    }
    return $valid_tickets;
}

function match_fields($tickets, $rules) {
    $match_rules = array();

    // Add all rules to all fields
    for($i=0; $i< count($tickets[0]); $i++)
        $match_rules[$i] = array_keys($rules);

    // Remove rules that don't match the field
    foreach ($tickets as $ticket) {
        foreach ($ticket as $key=>$field) {
            $invalid_rules = array();
            foreach ($rules as $rule_name=>$rule) {
                if (!($rule[0][0] <= $field && $field <= $rule[0][1]) && !($rule[1][0] <= $field && $field <= $rule[1][1])) array_push($invalid_rules, $rule_name);
            }
            $match_rules[$key] = array_diff($match_rules[$key], $invalid_rules);
        }
    }

    // Each field can have only one rule
    $go = true;
    while($go) {
        $go = false;
        for ($i = 0; $i < count($match_rules); $i++) {
            if (count($match_rules[$i]) == 1) {
                for ($j = 0; $j < count($match_rules); $j++) {
                    if ($j != $i)
                        $match_rules[$j] = array_diff($match_rules[$j], $match_rules[$i]);
                }
            } else {
                $go = true;
            }
        }
    }

    // Flatten array
    for ($i = 0; $i < count($match_rules); $i++) {
        $match_rules[$i] = end($match_rules[$i]);
    }

    return $match_rules;
}

function part2($rules, $nearby_tickets, $your_ticket) {
    $valid_tickets = valid_tickets($nearby_tickets, $rules);
    $field_rule = match_fields($valid_tickets, $rules);
    $part2 = 1;
    for($i = 0; $i < count($field_rule); $i++) {
        if(str_contains($field_rule[$i], 'departure'))
            $part2 *= $your_ticket[$i];
    }
    echo "Part 2:" . $part2 . "\n";
}


$rules = array();
$nearby_tickets = array();
$your_ticket = array();
parse_input("input.txt", $rules,$nearby_tickets, $your_ticket);
part2($rules, $nearby_tickets, $your_ticket);