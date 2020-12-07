<?php

function parse_input($filename){
    $lines = file($filename, FILE_IGNORE_NEW_LINES);
    $bags = array(); // array("bag1" => array("bag2" => 2, "bag3" =>1), "bag4" => array(...), ...)

    foreach ($lines as $line) {
        $line = str_replace(["bags", "bag", ".", " "], "", $line);
        [$contain_bag, $contains] = explode("contain", $line);
        $bags[$contain_bag] = array();

        if(substr_count($contains,"noother") == 0) {
            $contains = explode(",", $contains);
            foreach ($contains as $contain)
                $bags[$contain_bag][substr($contain, 1)] = intval($contain[0]);
        }
    }
    return $bags;
}

/* Part 1 */
function found_in_bags($bag_name, &$found) {
    global $bags;
    foreach($bags as $key => $bag){
        if(array_key_exists($bag_name, $bag)){
            array_push($found, $key);
            found_in_bags($key, $found);
        }
    }
}

/* Part 2 */
function bags_inside($bag_name) {
    global $bags;
    $count = 0;
    foreach($bags[$bag_name] as $key => $bag)
       $count += $bag + $bag * bags_inside($key);

    return $count;
}

// Parse input
$bags = parse_input("input.txt");

// Part 1
$found = array();
found_in_bags("shinygold", $found);
$part1 = count(array_unique($found));
echo "part1: " . $part1 . "\n";

// Part 2
$part2 = bags_inside("shinygold");
echo "part2: " . $part2 . "\n";