<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom' , \Symfony\Component\Form\Extension\Core\Type\TextType::class , 
            ["attr" =>[
                "class"=>"form-control" , 'placeholder' => 'Donner votre nom']
            ])
            ->add('prenom', \Symfony\Component\Form\Extension\Core\Type\TextType::class , 
            ["attr" =>[
                "class"=>"form-control" , 'placeholder' => 'Donner votre prénom']
            ])
            ->add('email', \Symfony\Component\Form\Extension\Core\Type\TextType::class , 
            ["attr" =>[
                "class"=>"form-control" , 'placeholder' => 'Donner votre email']
            ])
            ->add('motpasse', \Symfony\Component\Form\Extension\Core\Type\PasswordType::class , 
            ["attr" =>[
                "class"=>"form-control", 'placeholder' => 'Donner votre mot de passe'],
            ])
            ->add('numero_telephone', \Symfony\Component\Form\Extension\Core\Type\TextType::class , 
            ["attr" =>[
                "class"=>"form-control" , 'placeholder' => 'Donner votre numero téléphone']
            ])
            ->add('role', \Symfony\Component\Form\Extension\Core\Type\TextType::class , 
            ["attr" =>[
                "class"=>"form-control" , 'placeholder' => "A pour Admin , S pour Simple utilisateur , F pour Fournisseur"]
            ])
            ->add('photoUser' , FileType::class, array('data_class'=> null, 'required' => false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
