<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$result = 0;
$passports = array();
$passport = "";
foreach($lines as $line) {
    if($line == ""){
        array_push($passports, $passport);
        $passport = "";
    }
    $passport .= $line . " ";
}
$reqs = array("byr", "iyr", "eyr", "hgt", "hcl", "ecl", "pid");
foreach ($passports as $passport)
{
    $present = 1;
    foreach ($reqs as $req){
        if(substr_count($passport,$req) == 0){
            $present = 0;
        }
    }

    $valid = 1;
    $fields = explode(" ",$passport);
    foreach ($fields as $field){
        if($field != ""){
            [$name, $val] = explode(":",$field);
            switch ($name){
                case "byr":
                    if($val < 1920 || $val > 2002){$valid = 0; echo "invalid byr\n";}
                    break;
                case "iyr":
                    if($val < 2010 || $val > 2020) {$valid = 0; echo "invalid iyr\n";}
                    break;
                case"eyr":
                    if($val < 2020 || $val > 2030){$valid = 0; echo "invalid eyr\n";}
                    break;
                case "hgt":
                    if(substr_count($val, "cm") == 1) {
                        $val = str_replace("cm", "", $val);
                        if ($val < 150 || $val > 193){$valid = 0; echo "invalid cm: ".$val."\n";}
                    }
                    elseif(substr_count($val, "in") == 1){
                        $val = str_replace("in", "", $val);
                        if ($val < 59 || $val > 76) {$valid = 0; echo "invalid in\n";}
                    }else{
                        {$valid = 0; echo "invalid hgt\n";}
                    }
                    break;
                case "hcl":
                    //if($val[0] != "#" || strlen($val) != 7) $valid = 0;
                    if($val[0] != "#" || strlen(preg_replace("/[^a-f0-9]+/", "", $val)) != 6) $valid = 0;
                    break;
                case "ecl":
                    if($val != "amb" && $val != "blu" && $val != "brn" && $val != "gry" && $val != "hzl" && $val != "grn" && $val != "oth") $valid = 0;
                    break;
                case "pid":
                    if(strlen($val) != 9) $valid = 0;
                    break;
                default:
                    break;
            }
        }
    }
    echo "valid: " . $valid . " | present: " . $present . "\n";
    $result += $present * $valid;

}

echo "res: ". $result;