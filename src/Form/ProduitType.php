<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Produit;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Symfony\Bridge\Twig\Extension\twig_is_selected_choice;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder


            ->add('nom',\Symfony\Component\Form\Extension\Core\Type\TextType::class,[
                "attr"=>[
                    "class"=>"form-control"
                ]
            ])

            ->add('designation',\Symfony\Component\Form\Extension\Core\Type\TextType::class,[
                "attr"=>[
                    "class"=>"form-control"
                ]
           ])
            ->add('quantite',\Symfony\Component\Form\Extension\Core\Type\TextType::class,[
                "attr"=>[
                    "class"=>"form-control"
                ]
            ])
            ->add('prix',\Symfony\Component\Form\Extension\Core\Type\TextType::class,[
                "attr"=>[
                    "class"=>"form-control"
                ]
            ])

            ->add('categories',EntityType::class,[
                "attr"=>[
                    "class"=>"form-control"
                ],
                     'class'=>Categorie::class,'required'=>false,
                    'choice_label' => 'nom_categorie',
            ]
            )

            ->add('image',FileType::class,array(
                'data_class'=>null,'required'=>false,
                    "attr"=>[
                        "class"=>"file-upload-browse btn btn-primary"
                    ])
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
