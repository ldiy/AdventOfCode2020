<?php

class Tile
{
    public $id;
    public $tile;
    public $state;

    public $wall_borders;
    public $rotations = 0;

    function __construct($id, $tile)
    {
        $this->id = $id;
        $this->tile = $tile;
        $this->state = 0;
        $this->wall_borders = [];
    }

    function get_id()
    {
        return $this->id;
    }

    function get_tile()
    {
        return $this->tile;
    }

    function get_wall_borders()
    {
        return $this->wall_borders;
    }

    function set_wall_borders($borders)
    {
        foreach($borders as $border)
            array_push($this->wall_borders, $this->get_borders()[$border]);
    }

    function print_tile()
    {
        foreach ($this->tile as $line)
            echo implode(' ', $line) . "\n";
        echo "\n";
    }

    function flip_vertical()
    {
        $new_tile = [];
        for ($i = count($this->tile) - 1; $i >= 0; $i--)
            array_push($new_tile, $this->tile[$i]);
        $this->tile = $new_tile;
    }

    function flip_horizontal()
    {
        $new_tile = [];
        foreach ($this->tile as $line) {
            $new_line = [];
            for ($i = count($line) - 1; $i >= 0; $i--)
                array_push($new_line, $line[$i]);
            array_push($new_tile, $new_line);
        }
        $this->tile = $new_tile;
    }

    function rotate()
    {
        $new_tile = [];
        for ($y = 0; $y < count($this->tile); $y++) {
            for ($x = 0; $x < count($this->tile[0]); $x++) {
                $new_tile[$x][$y] = $this->tile[$y][$x];
            }
        }
        $this->tile = $new_tile;
        $this->flip_horizontal();
    }

    function next_state()
    {
        if($this->rotations < 4) {
            $this->rotations++;
            $this->rotate();
        }

        if($this->rotations == 4){
            $this->flip_vertical();
            $this->rotations = 0;
        }
    }

    function get_borders(): array
    {
        $borders = [];
        $borders[0] = $this->tile[0];          // Top
        $borders[2] = $this->tile[count($this->tile)-1]; // Bottom
        $borders[3] = $borders[1] = [];
        for ($y = 0; $y < count($this->tile); $y++) {
            array_push($borders[3], $this->tile[$y][0]);    // Left
            array_push($borders[1], $this->tile[$y][count($this->tile[$y])-1]);  // Right
        }
        return $borders;
    }

    function remove_borders()
    {
        $new_tile = [];
        for ($y = 1; $y < count($this->tile)-1; $y++) {
            array_push($new_tile, str_split(substr(implode($this->tile[$y]),1, count($this->tile) - 2)));
        }
        $this->tile = $new_tile;
    }
}


$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$tiles = [];

$tile_id = 0;
$curr_tile = [];
foreach ($lines as $line) {
    if ($line == "") {
        array_push($tiles, new Tile($tile_id, $curr_tile));
        $curr_tile = [];
    } else {
        if ($line[0] == 'T') {
            $tile_id = intval(substr($line, -5, 4));
        } else {
            array_push($curr_tile, str_split($line));
        }
    }
}

$image_size = sqrt(count($tiles));
$tile_image = [];
$tile_key_unset = 0;

$part1 = 1;
foreach ($tiles as $tile_key=>$tile) {
    $b = $tile->get_borders();
    $not_wall_borders = [];
    $n = 0;
    foreach ($tiles as $compare_tile) {
        if ($tile != $compare_tile) {
            $c_b = $compare_tile->get_borders();
            foreach ($b as $key=>$b1) {
                foreach ($c_b as $b2) {
                    if (implode($b1) == implode($b2) || strrev(implode($b1)) == implode($b2)){
                        $n++;
                        array_push($not_wall_borders, $key);
                    }
                }
            }
        }
    }
    $tile->set_wall_borders(array_diff([0,1,2,3], $not_wall_borders));
    if ($n == 2) {
        $part1 *= $tile->get_id();
        $tile_image[0][0] = $tile;
        $tile_key_unset = $tile_key;
    }
}
echo "Part 1: $part1 \n";

unset($tiles[$tile_key_unset]);

// Rotate and flip first image
$tile1_wall_borders = $tile_image[0][0]->get_wall_borders();

while(!(($tile1_wall_borders[0] == $tile_image[0][0]->get_borders()[0] && $tile1_wall_borders[1] == $tile_image[0][0]->get_borders()[3]) || ($tile1_wall_borders[1] == $tile_image[0][0]->get_borders()[0] && $tile1_wall_borders[0] == $tile_image[0][0]->get_borders()[3]) || (strrev(implode($tile1_wall_borders[1])) == implode($tile_image[0][0]->get_borders()[0]) && $tile1_wall_borders[0] == $tile_image[0][0]->get_borders()[3]) || ($tile1_wall_borders[1] == $tile_image[0][0]->get_borders()[0] && strrev(implode($tile1_wall_borders[0])) == implode($tile_image[0][0]->get_borders()[3])))){
    $tile_image[0][0]->next_state();
}


for($y = 0; $y < $image_size; $y++){
    for($x = 0; $x< $image_size; $x++){
        if(!($y == 0 && $x == 0)){
            if($y == 0){
                $borders_prev_tile = $tile_image[0][$x-1]->get_borders();
                foreach ($tiles as $key=>$tile) {
                    if($tile != $tile_image[0][$x-1]) {
                        for ($i = 0; $i < 10; $i++) {
                            if ($borders_prev_tile[1] == $tile->get_borders()[3]) {
                                $tile_image[$y][$x] = $tile;
                                unset($tiles[$key]);
                                break;
                            }else {
                                $tile->next_state();
                            }
                        }
                    }
                }
            } else {
                $borders_prev_tile = $tile_image[$y-1][$x]->get_borders();
                foreach ($tiles as $key=>$tile) {
                    if($tile != $tile_image[$y-1][$x]) {
                        for ($i = 0; $i < 10; $i++) {
                            if ($borders_prev_tile[2] == $tile->get_borders()[0]) {
                                $tile_image[$y][$x] = $tile;
                                unset($tiles[$key]);
                                break;
                            }
                            $tile->next_state();
                        }
                    }
                }
            }
        }
    }
}

// Remove borders
for($y = 0; $y < $image_size; $y++) {
    for ($x = 0; $x < $image_size; $x++) {
        $tile_image[$y][$x]->remove_borders();
    }
}

// Concat tiles
$tile_size = count($tile_image[0][0]->get_tile());
$image = [];
for($y = 0; $y < $image_size; $y++) {
    for ($x = 0; $x < $image_size; $x++) {
        $tile = $tile_image[$y][$x]->get_tile();
        for($i = 0; $i < $tile_size; $i++){
            if($x == 0) $image[$y*$tile_size + $i] = [];
            for($j = 0; $j < $tile_size; $j++){
                array_push($image[$y*$tile_size + $i], $tile[$i][$j]);
            }
        }
    }
}

$image = new Tile(0,$image);


// Sea monster
$sea_monster = [
"                  # ",
"#    ##    ##    ###",
" #  #  #  #  #  #   ",
];

$r1 = str_split($sea_monster[0]);
$r2 = str_split($sea_monster[1]);
$r3 = str_split($sea_monster[2]);
$found = 0;
while($found == 0) {
    $img = $image->get_tile();
    for ($y = 0; $y < count($img) - count($sea_monster); $y++) {
        for ($x = 0; $x < count($img[0]) - strlen($sea_monster[0]); $x++) {
            $ok1 = true;
            for ($i = 0; $i < strlen($sea_monster[0]); $i++) {
                if ($r1[$i] == "#" && $img[$y][$x + $i] != "#") {
                    $ok1 = false;
                    break;
                }
            }
            if ($ok1) {
                $ok2 = true;
                for ($i = 0; $i < strlen($sea_monster[0]); $i++) {
                    if ($r2[$i] == "#" && $img[$y + 1][$x + $i] != "#") {
                        $ok2 = false;
                        break;
                    }
                }
                if ($ok2) {
                    $ok3 = true;
                    for ($i = 0; $i < strlen($sea_monster[0]); $i++) {
                        if ($r3[$i] == "#" && $img[$y + 2][$x + $i] != "#") {
                            $ok3 = false;
                            break;
                        }
                    }
                    if ($ok3) $found++;
                }
            }
        }
    }
    if($found == 0)
        $image->next_state();
}
echo "found: $found \n";

$sea_monster_size = 15;
$sea_count = 0;
$img = $image->get_tile();
for ($y = 0; $y < count($img); $y++) {
    $sea_count += array_count_values($img[$y])['#'];
}

echo "Part 2: ". ($sea_count - ($sea_monster_size * $found)) . "\n";