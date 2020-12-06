<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$result = 0;
$group = "";
$person_count = 0;
foreach ($lines as $line) {
    if ($line == "") {
        $questions = array_count_values(str_split($group));
        foreach($questions as $question){
            if($question == $person_count)
                $result++;
        }
        $group = "";
        $person_count = 0;

    } else {
        $group .= $line;
        $person_count++;
    }
}

echo "part2: " . $result . "\n";