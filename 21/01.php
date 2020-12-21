<?php
class Food {
    public $ingredients;
    public $allergens;
    function __construct($ingredients, $allergens){
        $this->ingredients = $ingredients;
        $this->allergens = $allergens;
    }

    function get_ingredients() {
        return $this->ingredients;
    }

    function get_allergens() {
        return $this->allergens;
    }

    function contains_allergen($allergen) {

        if(in_array($allergen, $this->allergens)) return true;
        return false;
    }

    function contains_ingredient($ingredient) {
        if(in_array($ingredient, $this->ingredients)) return true;
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

function part1($foods) {
    $part1 = 0;

    $no_allergens = [];


    $allergens = [];
    $ingredients = [];
    foreach($foods as $food){
        $allergens_in = $food->get_allergens();
        $ingredients_in = $food->get_ingredients();
        foreach ($allergens_in as $allergen)
            array_push($allergens, $allergen);
        foreach ($ingredients_in as $ingredient){
            array_push($ingredients, $ingredient);
        }
    }
    $allergens = array_unique($allergens);

    $ingr2 = [];
    foreach ($allergens as $allergen){
        $ingr = [];
        foreach ($foods as $key=>$food) {
            if($food->contains_allergen($allergen)){
                if(count($ingr) == 0){
                    $ingr = $food->get_ingredients();
                }else{
                    $ingr = array_intersect($ingr, $food->get_ingredients());
                }
            }
        }
        foreach ($ingr as $ing){
            array_push($ingr2, $ing);
        }
    }
    $ingr2 = array_unique($ingr2);
    $no_allergens = array_diff($ingredients, $ingr2);
    $part1 = count($no_allergens);

    return $part1;
}

$food = parse_input("input.txt");
$part1 = part1($food);
echo "Part 1: $part1 \n";