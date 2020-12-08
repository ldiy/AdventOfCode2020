<?php

function parse_input($filename) {
    $lines = file($filename, FILE_IGNORE_NEW_LINES);
    $instructions = array();

    foreach ($lines as $line) {
        array_push($instructions, explode(" ", $line));
    }

    return $instructions;
}

function run($instructions) {
    $length = count($instructions);
    $read_instructions = array();
    $acc = 0;
    $pointer = 0;
    while (!in_array($pointer, $read_instructions)) {
        array_push($read_instructions, $pointer);
        switch ($instructions[$pointer][0]) {
            case "acc":
                $acc += $instructions[$pointer][1];
                $pointer++;
                break;
            case "jmp":
                $pointer += $instructions[$pointer][1];
                break;
            case "nop":
                $pointer++;
                break;
        }
        // We are at the end
        if($pointer >= $length)
            return $acc;
    }
    return null;
}

function part2($instructions) {
    $length = count($instructions);

    for ($i = 0; $i < $length; $i++) {
        // Switch nop and jmp instruction
        $prev_instr = "";
        if ($instructions[$i][0] == "jmp") {
            $instructions[$i][0] = "nop";
            $prev_instr = "jmp";
        } elseif ($instructions[$i][0] == "nop") {
            $instructions[$i][0] = "jmp";
            $prev_instr = "nop";
        }

        // Run the program
        $acc = run($instructions);

        // Check if the program terminates
        if ($acc == null) {
            if ($prev_instr != "")
                $instructions[$i][0] = $prev_instr;
        } else {
            return $acc;
        }
    }
    return null;
}

$instructions = parse_input("input.txt");
$part2 = part2($instructions);
echo "part2: " . $part2 . "\n";