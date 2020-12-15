<?php

/* !! returned bits are reversed */
function get_floating_adresses($address, $mask, &$addresses, $index = 0) {
    if(!array_key_exists($index,$addresses)) $addresses[$index] = 0;
    $last_mask_bit = end($mask);
    while ($last_mask_bit != 'X' && $last_mask_bit != NULL){
        if($last_mask_bit == '0')
            $addresses[$index] = ($addresses[$index] << 1) | ($address & 0b1);
        else
            $addresses[$index] = ($addresses[$index] << 1) | 0b1;

        array_pop($mask);
        $last_mask_bit = end($mask);
        $address = $address >> 1;
    }
    if($last_mask_bit == 'X'){
        $next_index = count($addresses);

        $addresses[$next_index] = ($addresses[$index] << 1) | 0b1;
        $addresses[$index] = ($addresses[$index] << 1) | 0b0;

        array_pop($mask);
        $address = $address >> 1;

        get_floating_adresses($address, $mask, $addresses, $index);
        get_floating_adresses($address, $mask, $addresses, $next_index);
    }
}


function part2($input_lines) {
    $mem = array();
    $mask = "";
    foreach ($input_lines as $line) {
        [$command, $value] = explode(' = ', $line);

        if ($command == "mask") {
            $mask = $value;
        } else {
            $address =  explode('[', str_replace(']', '', $command))[1];
            $addresses = array();
            get_floating_adresses($address, str_split($mask), $addresses);
            foreach ($addresses as $adr)
                $mem[$adr] = $value;
        }
    }
    return array_sum($mem);
}

$input = file("input.txt", FILE_IGNORE_NEW_LINES);
echo "Part 2: " . part2($input) . "\n";
