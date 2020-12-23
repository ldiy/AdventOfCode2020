<?php
$input = "952316487";
$rounds = 100;

$cups = str_split($input);
$curr_cup_id = 0;
for($i=0; $i<$rounds; $i++) {
    echo "i: $i\n";
    $selected_cups = array_slice($cups, $curr_cup_id+1,3);
    $s_l = count($selected_cups);
    for($k=0; $k< 3-$s_l; $k++){
        array_push($selected_cups, $cups[$k]);
    }
    $destination_cup = $cups[$curr_cup_id] - 1;
    if($destination_cup == 0) $destination_cup = 9;
    while(in_array($destination_cup,$selected_cups)){
        $destination_cup -= 1;
        if($destination_cup == 0) $destination_cup = 9;
    }
    $destination_cup_id = array_search($destination_cup,$cups);

    $new_cups = [];
    for($j = 0; $j<count($cups); $j++){

        if(!in_array($cups[$j],$selected_cups)) {
            if ($j < count($cups))
                array_push($new_cups, $cups[$j]);
            if ($j == $destination_cup_id) {
                foreach ($selected_cups as $cup)
                    array_push($new_cups, $cup);
            }
        }

    }
    $curr_cup = $cups[$curr_cup_id];
    $cups = $new_cups;
    $curr_cup_id = array_search($curr_cup, $cups);
    $curr_cup_id++;
    if($curr_cup_id >= count($cups)) $curr_cup_id = 0;

}

$one_id = array_search("1", $cups);
for($i = $one_id; $i>0; $i--){
    array_push($cups, array_shift($cups));
}

echo "Part 1: ". implode($cups) . "\n";