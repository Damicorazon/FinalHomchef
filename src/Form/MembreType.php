<?php

namespace App\Form;

use App\Entity\Membre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class MembreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo')
            ->add('roles', ChoiceType::class, [
                "choices" => [
                    "Convive" => "ROLE_CLIENT",
                    "Chef" => "ROLE_CHEF",
                    "Admin" => "ROLE_ADMIN"
                ],
                "multiple" => false,
                "expanded" => true
            ])
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
            ->add('mail')
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
            ->add('siret', TextType::class, [
                "required" => false
            ])
            ->add('tva', TextType::class, [
                "required" => false
            ])
            ->add('descriptif', TextType::class, [
                "required" => false
            ])
            ->add('langue', TextType::class, [
                "required" => false
            ])
            ->add('zone', TextType::class, [
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

        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                     return count($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {
                     return [$rolesString];
                }
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Membre::class,
        ]);
    }
}
