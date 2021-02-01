<?php

namespace App\Form;

use App\Entity\Membre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ModifMembreClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo')
            ->add('password', PasswordType::class, [
                "label" => "Mot de passe",
                "mapped" => false,
                "required" => false,
            ])
            ->add('nom', TextType::class, [
                "required" => false
            ])
            ->add('prenom', TextType::class, [
                "required" => false
            ])
            ->add('mail', TextType::class, [
                "required" => false
            ])
            ->add('ville', TextType::class, [
                "required" => false
            ])
            ->add('cp', TextType::class, [
                "required" => false
            ])
            ->add('adresse', TextType::class, [
                "required" => false
            ])
            ->add('telephone', TextType::class, [
                "required" => false
            ])
            ->add('photo', FileType::class, [
                "mapped" => false,
                "required" => false,
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
            'data_class' => Membre::class,
        ]);
    }
}
