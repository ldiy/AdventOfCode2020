<?php

class Food
{
    public $ingredients;
    public $allergens;

    function __construct($ingredients, $allergens)
    {
        $this->ingredients = $ingredients;
        $this->allergens = $allergens;
    }

    function get_ingredients()
    {
        return $this->ingredients;
    }

    function get_allergens()
    {
        return $this->allergens;
    }

    function contains_allergen($allergen)
    {

        if (in_array($allergen, $this->allergens)) return true;
        return false;
    }

    function contains_ingredient($ingredient)
    {
        if (in_array($ingredient, $this->ingredients)) return true;
        return false;
    }
}

function parse_input($filename)
{
    $food = [];
    $lines = file($filename, FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        [$ingredients, $allergens] = explode(" (contains ", $line);
        $ingredients = explode(' ', $ingredients);
        $allergens = explode(', ', str_replace(')', '', $allergens));
        array_push($food, new Food($ingredients, $allergens));
    }
    return $food;
}

function part2($foods)
{
    $part2 = "";

    $allergens = [];
    $ingredients = [];
    foreach ($foods as $food) {
        $allergens_in = $food->get_allergens();
        $ingredients_in = $food->get_ingredients();
        foreach ($allergens_in as $allergen)
            array_push($allergens, $allergen);
        foreach ($ingredients_in as $ingredient) {
            array_push($ingredients, $ingredient);
        }
    }
    $allergens = array_unique($allergens);

    $allergen_ingredient = [];
    foreach ($allergens as $allergen) {
        $ingr = [];
        foreach ($foods as $key => $food) {
            if ($food->contains_allergen($allergen)) {
                if (count($ingr) == 0) {
                    $ingr = $food->get_ingredients();
                } else {
                    $ingr = array_intersect($ingr, $food->get_ingredients());
                }
            }
        }
        $allergen_ingredient[$allergen] = $ingr;
    }


    $ok = true;
    while($ok){
        $ok = false;
        foreach ($allergen_ingredient as $ingredients) {
            if(count($ingredients) == 1) {
                foreach ($allergen_ingredient as $key2=>$ingredients2) {
                    if($ingredients != $ingredients2) {
                        $allergen_ingredient[$key2] = array_diff($allergen_ingredient[$key2], $ingredients);
                    }
                }
            } else{
                $ok = true;
            }
        }
    }
    ksort($allergen_ingredient);

    foreach ($allergen_ingredient as $ingredient){
        $part2 .= end($ingredient) . ",";
    }
    return $part2;
}

$food = parse_input("input.txt");
$part2 = part2($food);
echo "Part 2: $part2 \n";