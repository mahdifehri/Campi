<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class RegistrationFormType extends AbstractType
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
                "class"=>"form-control" , 'placeholder' => 'Donner votre prenom']
            ])
            ->add('numerotelephone', \Symfony\Component\Form\Extension\Core\Type\TextType::class , 
            ["attr" =>[
                "class"=>"form-control" , 'placeholder' => 'Donner votre numero telephone']
            ])
            ->add('NomRole', \Symfony\Component\Form\Extension\Core\Type\TextType::class , 
            ["attr" =>[
                "class"=>"form-control" , 'placeholder' => 'A pour Admin , S pour Simple utilisateur , F pour Fournisseur']
            ])
            ->add('photoUser' , FileType::class, array('data_class'=> null, 'required' => false))
            ->add('email' , \Symfony\Component\Form\Extension\Core\Type\TextType::class , 
            ["attr" =>[
                "class"=>"form-control" , 'placeholder' => 'Donner votre email']
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password' , "class"=>"form-control" , 'placeholder' => 'Donner votre mot de passe'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'SVP Donner votre  mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
