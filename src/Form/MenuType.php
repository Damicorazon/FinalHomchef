<?php

namespace App\Form;

use App\Entity\Menu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                "constraints" => [
                    new Length([
                        "max" => 50,
                        "maxMessage" => "Le nom ne peut comporter que {{ limit }} caractères"
                    ]),
                    new NotBlank([ "message" => "Le nom ne peut pas être vide" ])
                ]
             ])
            ->add('specialite', TextType::class, [
                "label" => "Specialité"
            ])
            ->add('entree', TextType::class, [
                "label" => "Entrée",
                "required" => false
            ])
            ->add('plat')
            ->add('dessert', TextType::class, [
                "required" => false
            ])
            ->add('prix')
            ->add('photo', FileType::class, [
                "mapped" => false,
                "constraints" => [
                    new Image([
                        "mimeTypes" => ["image/png", "image/jpeg", "image/gif"],
                        "mimeTypesMessage" => "Vous ne pouvez téléchargé que des fichiers jpg, png ou gif",
                        "maxSize" => "2048k",
                        "maxSizeMessage" => "Le fichier ne doit pas dépasser 2Mo"
                    ])
                ]
            ])
            ->add('enregistrer', SubmitType::class, [
                "attr" => [
                    "class" => "btn btn-info"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
