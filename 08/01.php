<?php

function parse_input($filename) {
    $lines = file($filename, FILE_IGNORE_NEW_LINES);
    $instructions = array();

    foreach ($lines as $line) {
        array_push($instructions, explode(" ", $line));
    }
    return $instructions;
}

function part1($instructions) {
    $read_instructions = array();
    $acc = 0;
    $i = 0;
    while(!in_array($i,$read_instructions)) {
        array_push($read_instructions, $i);
        switch ($instructions[$i][0]) {
            case "acc":
                $acc += $instructions[$i][1];
                $i++;
                break;
            case "jmp":
                $i += $instructions[$i][1];
                break;
            case "nop":
                $i++;
                break;
        }
    }
    return $acc;
}

$instructions = parse_input("input.txt");
$part1 = part1($instructions);
echo "part1: " . $part1 ."\n";