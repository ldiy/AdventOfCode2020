<?php
$number = 30000000;
$input = [8,13,1,0,18,9];
$val_count = [];
$turns_apart = [];
$length = 0;
foreach ($input as $n) {
    $val_count[$n] = 1;
    $turns_apart[$n] = [$length];
    $length++;
}
$last_value = end($input);

for ($i = $length - 1; $i < $number - 1; $i++) {
    $new_value = 0;
    if ($val_count[$last_value] > 1) {
        $b = $turns_apart[$last_value];
        $new_value = $b[1] - $b[0];
    }

    if(array_key_exists($new_value,$turns_apart)) {
        $val_count[$new_value]++;
        $turns_apart[$new_value] = [end($turns_apart[$new_value]), $i + 1];
    }
    else{
        $val_count[$new_value] = 1;
        $turns_apart[$new_value] = [0, $i + 1];
    }
    $last_value = $new_value;
}

echo "Part 2: " . $last_value . "\n";