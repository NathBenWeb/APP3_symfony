<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatController extends AbstractController{

    /**
     * @Route("/catList", name="app_catList")
     */
    public function getCat(){
        // getRepository > pour afficher ou lire
        // getManager > pour ajouter, modifier ou supprimer
        $repo = $this->getDoctrine()->getRepository(Categorie::class);
        $cats = $repo->findAll();
        //dd($cars);
        return $this->render("cat/catList.html.twig", ["tabCats" => $cats]);
    }

    /**
     * @Route("/addCat", name="app_addCat")
     */
    public function addCat(Request $request){
        $cat = new Categorie;
        $form = $this->createForm(CategorieType::class, $cat);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($cat);
            $em->flush();

            $this->addFlash('success', 'Catégorie ajoutée avec succès');
            return $this->redirectToRoute("app_catList");
        }
        return $this->render('cat/addCat.html.twig', [
            'form'=> $form->createView() ]);

    }

    /**
     * @Route("/editCat/{id}", name="app_editCat")
     */
   
     public function editCat(Categorie $cat, Request $request, EntityManagerInterface $em){
        $form = $this->createFormBuilder($cat)
            -> add("nom", TextType::class)
            
            -> getForm();
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
               
                $em->flush();
                $this->addFlash('success', 'Catégorie modifiée avec succès');
                return $this->redirectToRoute("app_catList");
            }
        
        return $this -> render("cat/editCat.html.twig", [
            "form_cat" => $form->createView(),
            "cat" => $cat
            ]);
     }

     /**
     * @Route("/deleteCat/{id}", name="app_deleteCat")
     */

     public function deleteCat($id){
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository(Categorie::class)->find($id);
        if(!$cat){
            throw $this->createNotFoundException("La catégorie que vous souhaitez supprimer n'existe pas");
        }
        $em->remove($cat);
        $em->flush();
        $this->addFlash('success', 'Catégorie supprimée avec succès');
        return $this->redirectToRoute("app_catList");
     }
}
