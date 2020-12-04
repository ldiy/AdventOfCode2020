<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$result = 0;
$passports = array();
$n = 0;
$curr_data = "";
foreach($lines as $n1) {
    echo "line: " . $n1 . "\n";
    if($n1 == ""){
        $passports[$n] = $curr_data;
        $curr_data = "";
        $n++;
    }
    $curr_data .= $n1 . " ";
}
$reqs = array("byr", "iyr", "eyr", "hgt", "hcl", "ecl", "pid");
foreach ($passports as $passport)
{
    $valid = 1;
    foreach ($reqs as $req){
        if(substr_count($passport,$req) == 0){
            $valid = 0;
        }
    }
    $result += $valid;

}

echo "res: ". $result;