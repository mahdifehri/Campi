<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom' ,\Symfony\Component\Form\Extension\Core\Type\TextType::class , ["attr" =>[
                "class"=>"form-control" , 'placeholder' => 'Donner votre nom']
            ])
            ->add('email', EmailType::class  , ["attr" =>[
                "class"=>"form-control" , 'placeholder' => 'Donner votre nom']
            ])
            ->add('message',TextareaType::class  , ["attr" =>[
                "class"=>"form-control" , 'placeholder' => 'Donner votre nom']
            ])
            ->add('envoyer',SubmitType::class  , ["attr" =>[
                "class"=>"btn btn-primary" , 'placeholder' => 'Donner votre nom']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
