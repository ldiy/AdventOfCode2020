<?php
$door_public_key = 14144084;
$card_public_key = 9232416;
$subject_number = 7;

function transform_subject_number($subject_number, $value = 1) {
    $val = $value * $subject_number;
    $val = $val % 20201227;
    return $val;
}

$door_loop_size = 0;
$found = 1;
while($door_public_key != $found){
   $found = transform_subject_number($subject_number, $found);
   $door_loop_size++;
}

$card_loop_size = 0;
$found = 1;
while($card_public_key != $found){
    $found = transform_subject_number($subject_number, $found);
    $card_loop_size++;
}

$encryption_key = 1;
for($i=0; $i<$door_loop_size; $i++){
   $encryption_key =  transform_subject_number($card_public_key, $encryption_key);
}
print_r($encryption_key);