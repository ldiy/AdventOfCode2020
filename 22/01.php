<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);

$deck_1 = [];
$deck_2 = [];

$deck_1_read = false;
foreach ($lines as $line) {
    if($line == "") $deck_1_read = true;
    else{
        if($line[0] != 'P'){
            if(!$deck_1_read) {
                array_push($deck_1,intval($line));
            }else{
                array_push($deck_2,intval($line));
            }
        }
    }
}

while(count($deck_1) != 0 && count($deck_2) != 0){
    $player_1_plays = $deck_1[0];
    $player_2_plays = $deck_2[0];
    array_shift($deck_1);
    array_shift($deck_2);
    if($player_1_plays > $player_2_plays){
        array_push($deck_1, $player_1_plays);
        array_push($deck_1, $player_2_plays);
    }else{
        array_push($deck_2, $player_2_plays);
        array_push($deck_2, $player_1_plays);
    }
    reset($deck_1);
    reset($deck_2);
}

$wining_deck = [];
if(count($deck_1) == 0) $wining_deck = $deck_2;
else $wining_deck = $deck_1;

$part1 = 0;
for($i=count($wining_deck); $i>0; $i--){
    $part1 += $i * $wining_deck[count($wining_deck) - $i];
}

echo "Part 1: $part1\n";