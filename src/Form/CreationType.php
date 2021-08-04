<?php

namespace App\Form;

use App\Entity\Creation;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('html_title', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Titre de référencement *',
                'attr' => [
                    'class' => 'form-control mb-4'
                ]
            ])
            ->add('meta_description', TextareaType::class, [
                'label' => 'Meta Description *',
                'attr' => [
                    'class' => 'form-control mb-4'
                ]
            ])
            ->add('title', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Titre *',
                'attr' => [
                    'class' => 'form-control mb-4'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description *',
                'attr' => [
                    'class' => 'form-control mb-4'
                ]
            ])
            ->add('slug', HiddenType::class, [])
            ->add('image1', FileType::class, [
                'label' => 'Image prévisualisation grand format * (1200 x 500)',
                'data_class' => null,
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-2'
                ]
            ])
            ->add('img_big_nb', FileType::class, [
                'label' => 'Image prévisualisation grand format N/B * (1200 x 500)',
                'data_class' => null,
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-2'
                ]
            ])
//            ->add('image2', FileType::class, [
//                'label' => 'Image prévisualisation petit format * (500 x 500)',
//                'data_class' => null,
//                'required' => false,
//                'attr' => [
//                    'class' => 'form-control mb-2'
//                ]
//            ])
//            ->add('img_small_nb', FileType::class, [
//                'label' => 'Image prévisualisation petit format N/B * (500 x 500)',
//                'data_class' => null,
//                'required' => false,
//                'attr' => [
//                    'class' => 'form-control mb-2'
//                ]
//            ])
            ->add('image_header', FileType::class, [
                'label' => 'Image haut de page * (1920 x 750)',
                'data_class' => null,
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-2'
                ]
            ])
            ->add('image_content', FileType::class, [
                'label' => 'Image de contenu * (1200 x 500)',
                'data_class' => null,
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-2'
                ]
            ])
//            ->add('video', TextareaType::class,[
//                'label' => 'Ajouter une vidéo (optionel) (Ne mettre que le lien à la fin de l\'url YT ce qui est après "watch?v=")',
//                'data_class' => null,
//                'required' => false,
//                'attr' => [
//                    'class' => 'form-control mb-2'
//                ]
//            ])
            ->add('slider', EntityType::class, array(
                'class'   => 'App\Entity\Slider',
                'choice_label'   => 'name',
                'placeholder' => 'Aucun',
                'label' => "Remplacer l'image de contenu par un slider (optionel)",
                'data_class' => null,
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-4'
                ]
            ))
            ->add('description2', TextareaType::class, [
                'label' => 'Description de contenu 2',
                'attr' => [
                    'class' => 'form-control mb-4'
                ],
                'required' => false
            ])
            ->add('image_corps_2', FileType::class, [
                'label' => 'Image de contenu 2 (1200 x 500)',
                'data_class' => null,
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-4'
                ],
                'required' => false
            ])
            ->add('Categorie', EntityType::class,  array(
                'class'   => 'App\Entity\Categorie',
                'choice_label'   => 'label',
                'multiple' => true,
                'label' => 'Catégories *',
                'attr' => [
                    'class' => 'form-control mb-4'
                ]
            ))
            ->add('Client', EntityType::class, array(
                'class' => 'App\Entity\Client',
                'choice_label' => 'name',
                'label' => 'Client *',
                'attr' => [
                    'class' => 'form-control mb-4'
                ]
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Creation::class,
        ]);
    }
}
