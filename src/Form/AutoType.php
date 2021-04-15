<?php

namespace App\Form;

use App\Entity\Auto;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AutoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        // Soit placeholder comme ici ou autre façon d'insérer un placeholder pour marque et modele voir dans la vue add 
            ->add('marque') 
            ->add('modele')
            ->add('pays', TextType::class, ['attr'=>['placeholder'=>'Veuillez entrer le pays']])
            ->add('categorie', EntityType::class, ['label'=>'Catégorie', 'class'=>Categorie::class, 'choice_label'=>'nom'])
            ->add('prix', NumberType::class, ['attr'=>['placeholder'=>'Veuillez entrer le prix']])
            ->add('image', FileType::class, ['label'=>'Image'])
            ->add('description', TextareaType::class, ['attr'=>['placeholder'=>'Veuillez entrer la description']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Auto::class,
        ]);
    }
}
