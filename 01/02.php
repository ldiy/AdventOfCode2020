<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$result = 0;
foreach($lines as $n1) {
    foreach($lines as $n2) {
        foreach ($lines as $n3) {
            if ($n1 + $n2 + $n3 == 2020) {
                echo $n1 * $n2 * $n3;
                die();
            }
        }
    }
}