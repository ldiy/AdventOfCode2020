<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$buses = explode(',', str_replace('x,', '', $lines[1]));
$max = max($buses);
$req = array();
$cnt = 0;
foreach (explode(',',$lines[1]) as $bus){
    if ($bus != 'x'){
        array_push($req,$bus - $cnt);
    }
    $cnt++;
}

function part2($num, $rem, $k)
{
    $prod = 1;
    for ($i = 0; $i < $k; $i++)
        $prod *= $num[$i];

    $result = 0;

    for ($i = 0; $i < $k; $i++)
    {
        $pp = (int)$prod / $num[$i];
        $result += $rem[$i] * gmp_invert($pp,$num[$i]) * $pp;
    }

    return $result % $prod;
}

echo "Part 2: " . part2($buses,$req,count($req));


