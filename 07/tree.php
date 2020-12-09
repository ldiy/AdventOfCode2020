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

function bags_inside($bag_name, $level) {
    global $bags;
    $t = array();
    echo  str_repeat("|     ",$level) . "├- ". $bag_name . "\n";
    $level++;
    foreach($bags[$bag_name] as $key => $bag){
       $t[$key] =  bags_inside($key, $level);
    }
    return $t;
}

function top_bags() {
    global $bags;
    $t_bags = array();
    foreach ($bags as $key => $bag) {
        $ok = true;
        foreach ($bags as $bag1) {
            if(array_key_exists($key,$bag1)) $ok = false;
        }
        if($ok) array_push($t_bags,$key);
    }
    return $t_bags;
}

$bags = parse_input("input.txt");
$tops = top_bags();
foreach($tops as $top) {
    bags_inside($top, 0);
    echo "\n";
}