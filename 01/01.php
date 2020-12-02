<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$result = 0;
foreach($lines as $n1) {
    foreach($lines as $n2) {
        if ($n1 + $n2 == 2020) {
            echo "res: " . $n1 * $n2;
            die();
        }
    }
}
