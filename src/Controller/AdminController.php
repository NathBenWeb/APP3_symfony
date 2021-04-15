<?php

namespace App\Controller;

use App\Entity\Auto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Car;
use App\Entity\Search;
use App\Form\AutoType;
use App\Model\Driver;
use App\Repository\AutoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdminController extends AbstractController{

    /**
     * @Route("/add", name="app_add")
     */
    public function add(Request $request){

        $car = new Auto();
        $form = $this->createForm(AutoType::class, $car);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $file = $form->get('picture')->getData(); //On récup les données du fichiers
            // dd($file);
            if($file){
                // Même si c'est la même image qui est utilisée pour plusieurs produits on va créer une image par produit créé automatiquement avec son propre nom cryptée pour éviter que si on supprime un de ces produits donc avec son image, les autres produits ne perdent pas leur image avec la fonction (md5(uniquid())
                $fileName = md5(uniqid()).'.'.$file->guessExtension(); // Ici on crypte le nom de l'image et on récup l'extension de l'image (.jpg/.png...)
                $file->move($this->getParameter('images_directory'), $fileName);// Ici on déplace l'image choisie dans le dossier indiqué dans le chemin qu'on a mis dans le fichier services.yaml 
            }
            $car->setImage($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($car);
            $em->flush();

            $this->addFlash('success', 'Voiture ajoutée avec succès');
            return $this->redirectToRoute("app_list");
        }
        return $this->render('admin/add.html.twig', [
            'form'=> $form->createView() ]);
    }

      

    /**
     * @Route("/list", name="app_list")
     */
    public function getAutos(Request $request){
        $search = new Search();
        $form = $this->createFormBuilder($search)
            -> add("motCle", TextType::class, ['label'=>'', 'attr'=>['placeholder'=>'Rechercher...'] ])
            -> getForm();
            $form->handleRequest($request);
        $repo = $this->getDoctrine()->getRepository(Auto::class);
        $cars = $repo->findAll();
        //dd($cars);
        return $this->render("admin/list.html.twig", ["tabCars" => $cars, "form_search"=>$form->createView()]);
    }

    /**
     * @Route("/edit/{id}", name="app_edit")
     */

    // public function editAuto($id, AutoRepository $autoRepo){
    //     // 1ère syntaxe avec $id en paramètre sans AutoRepository
    //     // $car = $this->getDoctrine()
    //     //             ->getRepository(Auto::class)
    //     //             ->find($id);

    //     // Autre syntaxe avec AutoRepository en paramètre
    //     $car = $autoRepo->find($id);
    //     dd($car);
    //     return $this -> render("car/edit.html.twig", ["tabCars" => $car]);

    // }

    public function editAuto(Auto $car, Request $request, EntityManagerInterface $em){
        // 3e syntaxe avec une instance d'Auto en paramètre et la création du formulaire à même la fonction
        $form = $this->createFormBuilder($car)
            -> add("marque")
            -> add("modele")
            -> add("pays")
            // ->add('categorie', EntityType::class, ['label'=>'Catégorie', 'class'=>Categorie::class, 'choice_label'=>'nom'])
            -> add("prix", NumberType::class)
            ->add('image', FileType::class, ['label'=>'Image'])
            -> add("description", TextType::class)
            // -> add("Modifier", SubmitType::class)
            -> getForm();
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                // $updateCar = $form->getData();
                // $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', 'Voiture modifiée avec succès');
                return $this->redirectToRoute("app_list");
            }
        
        return $this -> render("admin/edit.html.twig", [
            "form_car" => $form->createView(),
            "car" => $car
            ]);
        }


    /**
     * @Route("/delete/{id}", name="app_delete")
     */

    public function deleteAuto($id){
        $em = $this->getDoctrine()->getManager();
        $car = $em->getRepository(Auto::class)->find($id);
        if(!$car){
            throw $this->createNotFoundException("La voiture que vous souhaitez supprimer n'existe pas");
        }
        $em->remove($car);
        $em->flush();
        $this->addFlash('success', 'Voiture supprimée avec succès');
        return $this->redirectToRoute("app_list");

    }
    
}

    

    

