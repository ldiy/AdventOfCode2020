<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$result = 0;
foreach ($lines as $line){
    $req_pass = explode(': ', $line);
    $pass = $req_pass[1];
    $minmax_char = explode(' ', $req_pass[0]);
    $minmax = explode('-', $minmax_char[0]);
    $req = $minmax_char[1];
    $in = substr_count($pass, $req);
    if($in >= $minmax[0] && $in <= $minmax[1]){
        $result +=1;
    }

}
echo $result;