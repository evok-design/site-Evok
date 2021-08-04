<?php

namespace App\Form;

use App\Entity\Actualites;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActualitesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('title', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
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
        ->add('titre', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
            'label' => 'Titre *',
            'attr' => [
                'class' => 'form-control mb-4'
            ]
        ])
        ->add('contenu', TextareaType::class, [
            'label' => 'Contenu *',
            'attr' => [
                'class' => 'form-control editor mb-4'
            ]
        ])
            ->add('newsletter_text_preview', TextareaType::class, [
                'label' => 'Texte newsletter *',
                'attr' => [
                    'class' => 'form-control editor mb-4'
                ]
            ])
        ->add('img_prev', FileType::class, [
            'label' => 'Image prévisualisation *',
            'data_class' => null,
            'attr' => [
                'class' => 'form-control mb-4'
            ]
        ])
        ->add('img_content', FileType::class, [
            'label' => 'Image du contenu *',
            'data_class' => null,
            'attr' => [
                'class' => 'form-control mb-4'
            ]
        ])
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

            ->add('video', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Vidéo (fin du lien après: "https://www.youtube.com/watch?v=") (facultatif)',
                'attr' => [
                    'class' => 'form-control mb-4'
                ]
            ])

        ->add('img_header', FileType::class, [
            'label' => 'Image header *',
            'data_class' => null,
            'attr' => [
                'class' => 'form-control mb-4'
            ]
        ])
        ->add('date', DateType::class,[
            'label' => 'Date de publication *',
            'data_class' => null,
            'attr' => [
                'class' => 'form-control Bootstrap-datepicker mb-4'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Actualites::class,
        ]);
    }
}
