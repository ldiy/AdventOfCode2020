<?php

class Tile {
    public $id;
    public $tile;
    public $state;

    private $rotations = 0;
    private $flips = 0;

    function __construct($id,$tile) {
        $this->id = $id;
        $this->tile = $tile;
        $this->state = 0;
    }

    function get_id() {
        return $this->id;
    }

    function get_tile() {
        return $this->tile;
    }

    function print_tile() {
        foreach ($this->tile as $line)
            echo implode(' ',$line) . "\n";
        echo "\n";
    }


    function get_borders(): array {
        $borders = [];
        $borders[0] = $this->tile[0];          // Top
        $borders[2] = end($this->tile); // Bottom
        $borders[4] = $borders[3] = [];
        for($y = 0; $y < count($this->tile); $y++) {
            array_push($borders[4], $this->tile[$y][0]);    // Left
            array_push($borders[3], end($this->tile[$y]));  // Right
        }
        return $borders;
    }
}


$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$tiles = [];

$tile_id = 0;
$curr_tile = [];
foreach ($lines as $line) {
    if($line == ""){
        array_push($tiles, new Tile($tile_id, $curr_tile));
        $curr_tile = [];
    }else{
        if($line[0] == 'T'){
            $tile_id = intval(substr($line, -5 ,4));
        }else{
            array_push($curr_tile, str_split($line));
        }
    }
}

$part1 = 1;
foreach ($tiles as $tile) {
    $b = $tile->get_borders();
    $n = 0;
    foreach ($tiles as $compare_tile) {
        if($tile != $compare_tile) {
            $c_b = $compare_tile->get_borders();
            foreach ($b as $b1){
                foreach ($c_b as $b2)
                {
                    if(implode($b1) == implode($b2) || strrev(implode($b1)) == implode($b2)) $n++;
                }
            }
        }
    }
    if($n == 2) $part1 *= $tile->get_id();
}
echo "Part 1: $part1 \n";