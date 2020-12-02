<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$result = 0;
foreach ($lines as $line){
    $req_pass = explode(': ', $line);
    $pass = $req_pass[1];
    $minmax_char = explode(' ', $req_pass[0]);
    $minmax = explode('-', $minmax_char[0]);
    $req = $minmax_char[1];
    if($pass[$minmax[0] - 1] == $req && $pass[$minmax[1] - 1] != $req || $pass[$minmax[0] - 1] != $req && $pass[$minmax[1] - 1] == $req ){
        $result +=1;
    }
}
echo $result;