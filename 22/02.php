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

function play_game($deck1, $deck2){
    $prev_deck1 = [];

    while(true) {
        if (in_array($deck1, $prev_deck1))
            return [1, $deck1];

        array_push($prev_deck1, $deck1);

        $player_1_plays = $deck1[0];
        $player_2_plays = $deck2[0];
        array_shift($deck1);
        array_shift($deck2);
        reset($deck1);
        reset($deck2);


        if (count($deck1) >= $player_1_plays && count($deck2) >= $player_2_plays) {
            $round_won = play_game(array_slice($deck1,0,$player_1_plays), array_slice($deck2,0,$player_2_plays))[0];
        } else {
            if($player_1_plays > $player_2_plays)
                $round_won = 1;
            else
                $round_won = 2;
        }

        // Push cards to the deck
        if($round_won == 1){
            array_push($deck1, $player_1_plays);
            array_push($deck1, $player_2_plays);
        }else{
            array_push($deck2, $player_2_plays);
            array_push($deck2, $player_1_plays);
        }
        if(count($deck1) == 0)
            return [2, $deck2];
        elseif(count($deck2) == 0)
            return [1, $deck1];
    }
}

[$winner, $deck] = play_game($deck_1, $deck_2);

$part2 = 0;
for($i=count($deck); $i>0; $i--){
    $part2 += $i * $deck[count($deck) - $i];
}

echo "Part 2: $part2\n";