<?php
$result = 0;

function parse_input($filename) {
    $passports = array();
    $lines = file($filename, FILE_IGNORE_NEW_LINES);
    $passport = array();
    foreach ($lines as $line) {
        if ($line == "") {
            array_push($passports, $passport);
            $passport = array();
        } else {
            $fields = explode(" ", $line);
            foreach ($fields as $field) {
                [$key, $val] = explode(":", $field);
                $passport[$key] = $val;
            }
        }
    }
    array_push($passports, $passport);
    return $passports;
}

function keys_present($passport) {
    $required_keys = array("byr", "iyr", "eyr", "hgt", "hcl", "ecl", "pid");
    if($required_keys == array_intersect($required_keys, array_keys($passport)))
        return true;
    else
        return false;
}

function valid($passport) {
    if ($passport["byr"] < 1920 || $passport["byr"] > 2002) return false;
    if ($passport["iyr"] < 2010 || $passport["iyr"] > 2020) return false;
    if ($passport["eyr"] < 2020 || $passport["eyr"] > 2030) return false;

    if (strpos($passport["hgt"], "cm")) {
        $val = str_replace("cm", "", $passport["hgt"]);
        if ($val < 150 || $val > 193) return false;
    } elseif (strpos($passport["hgt"], "in")) {
        $val = str_replace("in", "", $passport["hgt"]);
        if ($val < 59 || $val > 76) return false;
    } else{ return false;}

    if (!preg_match("/^#[0-9-a-f]{6}/", $passport["hcl"])) return false;
    if (!in_array($passport["ecl"], array("amb", "blu", "brn", "gry", "grn", "hzl", "oth"))) return false;
    if (strlen($passport["pid"]) != 9) return false;

    return true;
}

$passports = parse_input("input.txt");
$part1 = 0;
$part2 = 0;
foreach($passports as $passport) {
    $present = keys_present($passport);
    if($present) {
        $valid = valid($passport);
        $part1 += 1;
        $part2 += $valid;
    }
}
echo "Part1: " . $part1 . "\n";
echo "Part2: " . $part2 . "\n";
