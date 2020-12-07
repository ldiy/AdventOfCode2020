<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$result = 0;
$bags = array();
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

$found = array();
function found_in_bags($bag_name, &$found) {
    global $bags;
    foreach($bags as $key => $bag){
        if(array_key_exists($bag_name, $bag)){
            array_push($found, $key);
            found_in_bags($key, $found);
        }
    }
}

found_in_bags("shinygold", $found);
$result = count(array_unique($found));
echo "result: " . $result . "\n";