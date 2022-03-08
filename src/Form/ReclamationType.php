<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\Destination;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type_rec',ChoiceType::class, [
                "attr" =>[
                    "class" =>"form-control"
                ],'choices'  => [
                    'Technique' => 'Technique',
                    'Demande' => 'Demande',
                    'Autre' => 'Autre',
                ],
            ])
            ->add('description_rec',TextareaType::class,[
                "attr" =>[
                    "class" =>"form-control"
                ]
            ])
            ->add('file', FileType::class, ['mapped' => false])
            ->add('etat_rec',HiddenType::class, ['empty_data' => 'En attente'])
            ->add('flag',HiddenType::class,['empty_data' => '1'])
            ->add('destination',EntityType::class, [
        'class' => Destination::class,
        'choice_label' => 'nom_dest'
    ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
