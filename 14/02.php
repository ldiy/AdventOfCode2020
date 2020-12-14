<?php

function mask($value, $mask) {
    $value_split = str_split($value);
    $mask_split = str_split($mask);
    $result = $mask_split;

    for($i = 0; $i < count($mask_split); $i++) {
        if ($mask_split[$i] == '0') {
            $result[$i] = $value_split[$i];
        }
    }
    return implode($result);
}

function bin_addresses($length, $pos, &$addresses) {
    static $bit = [];
    static $source = ['1', '0'];
    $pos++;
    for($i = 0; $i < 2; $i++) {
        $bit[$pos] = $source[$i];
        if ($pos < $length - 1) {
            bin_addresses($length, $pos, $addresses);
        } else {
            array_push($addresses,$bit);
        }
    }
}
function addresses($address) {
    $address_split = str_split($address);
    $floating_count = array_count_values($address_split)['X'];
    $addresses = array();
    $floating_vals = array();
    bin_addresses($floating_count, -1 , $floating_vals);
    for($i = 0; $i< pow(2,$floating_count); $i++) {
        $new_address = $address_split;
        $floating_vals_i = 0;
        for($j = 0; $j < count($address_split); $j++){
            if ($address_split[$j] == 'X'){
                $new_address[$j] = $floating_vals[$i][$floating_vals_i++];
            }
        }
        array_push($addresses, implode($new_address));
    }
    return $addresses;
}

function bin($n, &$val)
{
    if ($n > 1)
        bin($n>>1, $val);
    $val .= ($n & 1);
}


$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$memory = array();
$mask = "";
foreach ($lines as $line) {
    [$command, $value] = explode(' = ', $line);

    if ($command == "mask") {
        $mask = $value;
    } else {
        $address = explode('[', str_replace(']', '', $command))[1];
        $new_addr = "";
        bin(intval($address), $new_addr);
        $new_addr = str_repeat('0', 36 - strlen($new_addr)) . $new_addr;
        $masked_address = mask($new_addr, $mask);
        $addresses = addresses($masked_address);
        $new_val = "";
        bin(intval($value), $new_val);
        $new_val = str_repeat('0', 36 - strlen($new_val)) . $new_val;
        foreach ($addresses as $adr) {
            if (array_key_exists($adr, $memory)) {
                $memory[$adr] = ($memory[$adr] & $value) | $value;
            } else {
                $memory[$adr] = $value;
            }
        }
    }
}

$part2 = array_sum($memory);
//print_r($memory);
echo "Part 2: " . $part2 . "\n";
