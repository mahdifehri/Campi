<?php

namespace App\Form;

use App\Entity\Destination;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class DestinationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_dest',TextType::class,[
        "attr" =>[
            "class" =>"form-control"
        ]
    ])
            ->add('localisation_dest',ChoiceType::class, [
                "attr" =>[
                    "class" =>"form-control"
                ],'choices'  => [
                                    'Ariana' => 'Ariana',
                                    'Beja' => 'Beja',
                                    'Ben Arous' => 'Ben Arous',
                                    'Bizerte' => 'Bizerte',
                                    'Gabes' => 'Gabes',
                                    'Gafsa' => 'Gafsa',
                                    'Jendouba' => 'Jendouba',
                                    'Kairouan' => 'Kairouan',
                                    'Kasserine' => 'Kasserine',
                                    'Kebili' => 'Kebili',
                                    'Kef' => 'Kef',
                                    'Manouba' => 'Manouba',
                                    'Medenine' => 'Medenine',
                                    'Monastir' => 'Monastir',
                                    'Nabeul' => 'Nabeul',
                                    'Sfax' => 'Sfax',
                                    'Sidi Bouzid' => 'Sidi Bouzid',
                                    'Siliana' => 'Siliana',
                                    'Sousse' => 'Sousse',
                                    'Tataouine' => 'Tataouine',
                                    'Tozeur' => 'Tozeur',
                                    'Tunis' => 'Tunis',
                                    'Zaghouan' => 'Zaghouan',
                ],
            ])
            ->add('nbr_part_dest',TextType::class,[
                "attr" =>[
                    "class" =>"form-control"
                ],
            ])
            ->add('event_dest',TextType::class,[
                "attr" =>[
                    "class" =>"form-control"
                ]
            ])
            ->add('image_dest',FileType::class, [
                "attr" =>[
                    "class" =>"form-control"],
                    'data_class' => null,
                    'required' => false,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Destination::class,
        ]);
    }
}
