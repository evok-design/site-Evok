<?php

namespace App\Form;

use App\Entity\Bloc;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlocType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-4'
                ],
                'label' => 'Titre de référencement*'
            ])
            ->add('meta_description', TextareaType::class,[
                'label' => 'Meta Description *',
                'attr' => ['class' => 'form-control mb-4', 'novalidate' => true]
            ])
            ->add('label', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-4'
                ],
                'label' => 'Titre *'
            ])
            ->add('image', FileType::class, [
                'label' => 'Image de prévisualisation *',
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
            ->add('imgHeader', FileType::class, [
                'label' => 'Image haut de page *',
                'data_class' => null,
                'attr' => ['class' => 'form-control']
            ])
            ->add('Categorie', EntityType::class,  array(
                'class'   => 'App\Entity\Categorie',
                'attr' => ['class' => 'form-control mb-4'],
                'choice_label'   => 'label',
                'multiple' => true,
                'label' => 'Catégories *'
            ))
            ->add('description1', TextareaType::class, [
                'label' => 'Description 1 *',
                'attr' => ['class' => 'form-control editor mb-4', 'novalidate' => true]
            ])
            ->add('imgContent1', FileType::class, [
                'label' => 'Image de contenu 1 *',
                'data_class' => null,
                'attr' => ['class' => 'form-control mb-4']
            ])
            ->add('description2', TextareaType::class, [
                'label' => 'Description 2',
                'attr' => ['class' => 'form-control editor mb-4', 'novalidate' => true],
                'required' => false
            ])
            ->add('imgContent2', FileType::class, [
                'label' => 'Image de contenu 2',
                'data_class' => null,
                'attr' => ['class' => 'form-control mb-4'],
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bloc::class,
        ]);
    }
}
