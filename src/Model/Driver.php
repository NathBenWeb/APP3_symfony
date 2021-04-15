<?php
namespace App\Model;
use App\Entity\Meal;

class Driver{
    public function getMeals(){
        $meal1 = new Meal();
        $meal1 -> setId_meal(001);
        $meal1 -> setName_meal("Menu Gourmand");
        $meal1 -> setChef("Cyril Lignac");
        $meal1 -> setStart("entrée menu gourmand");
        $meal1 -> setDish("plat menu gourmand");
        $meal1 -> setDessert("dessert menu gourmand");

        $meal2 = new Meal();
        $meal2 -> setId_meal(001);
        $meal2 -> setName_meal("Menu Gourmand");
        $meal2 -> setChef("Cyril Lignac");
        $meal2 -> setStart("entrée menu gourmand");
        $meal2 -> setDish("plat menu gourmand");
        $meal2 -> setDessert("dessert menu gourmand");

        $meal3 = new Meal();
        $meal3 -> setId_meal(001);
        $meal3 -> setName_meal("Menu Gourmand");
        $meal3 -> setChef("Cyril Lignac");
        $meal3 -> setStart("entrée menu gourmand");
        $meal3 -> setDish("plat menu gourmand");
        $meal3 -> setDessert("dessert menu gourmand");

        $tab_meals = [$meal1, $meal2, $meal3];

        return $tab_meals;
    }
}