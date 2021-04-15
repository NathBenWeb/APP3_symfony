<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\Driver;


class PagesController extends AbstractController{

    /**
     * @Route("/accueil", name="app_accueil")
     */

     public function accueil(){
        //  $meals = [
        //  ["id_meal"=>001, "name_meal"=>"Menu Gourmand", "chef"=>"Cyril Lignac", "start"=>"entrée menu gourmand", "dish"=>"plat menu gourmand", "dessert"=>"dessert mennu gourmand"],
        //  ["id_meal"=>002, "name_meal"=>"Menu Evasion", "chef"=>"Philippe Etchebest", "start"=>"entrée menu évasion", "dish"=>"plat menu évasion", "dessert"=>"dessert mennu évasion"],
        //  ["id_meal"=>003, "name_meal"=>"Menu Emotion", "chef"=>"Marc Veyrat", "start"=>"entrée menu émotion", "dish"=>"plat menu émotion", "dessert"=>"dessert mennu émotion"]
        //  ];
        $driver = new Driver();
        $meals = $driver->getMeals();

        return $this -> render("pages/accueil.html.twig",["tabMeals" => $meals]);
     }

     /**
     * @Route("/about", name="app_about")
     */
     public function about(){
         return $this -> render("pages/about.html.twig");
     }

     /**
     * @Route("/contact", name="app_contact")
     */
     public function contact(){

        return $this -> render("pages/contact.html.twig");
     }

}