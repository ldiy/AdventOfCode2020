<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$result = 0;
$group = "";

foreach ($lines as $line) {
    if($line == ""){
        $result += count(array_unique(str_split($group)));
        $answers = "";
    }else {
       $group .= $line;
    }
}

echo "part1: " . $result . "\n";