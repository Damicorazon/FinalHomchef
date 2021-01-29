<?php

namespace App\Form;

use App\Entity\Membre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;


class ModifMembreChefType extends AbstractType
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
        ->add('nom')
        ->add('prenom')
        ->add('mail')
        ->add('ville')
        ->add('cp')
        ->add('adresse')
        ->add('telephone')
        ->add('siret')
        ->add('tva')
        ->add('descriptif')
        ->add('langue')
        ->add('zone')
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
