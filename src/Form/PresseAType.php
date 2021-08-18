<?php

namespace App\Form;

use App\Entity\PresseA;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PresseAType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Titre  *',
                'attr' => [
                    'class' => 'form-control mb-5'
                ]
            ])
            ->add('lien_site', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Lien vers le site internet  *',
                'attr' => [
                    'class' => 'form-control mb-5'
                ]
            ])
            ->add('image', FileType::class, [
                'label' => 'Image de prévisualisation *',
                'data_class' => null,
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-4'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PresseA::class,
        ]);
    }
}
