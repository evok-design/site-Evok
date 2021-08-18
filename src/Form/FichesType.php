<?php

namespace App\Form;

use App\Entity\Fiches;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class FichesType extends AbstractType
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
            ->add('sous_titre', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Sous-itre  *',
                'attr' => [
                    'class' => 'form-control mb-5'
                ]
            ])
            ->add('pdf', FileType::class, [
                'label' => 'Brochure pdf (max 2mo) *',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                'required' => false,


                'constraints' => [
                    new File([

                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
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
            'data_class' => Fiches::class,
        ]);
    }
}
