<?php

namespace App\Form;

use App\Entity\PresseV;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PresseVType extends AbstractType
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
                'label' => 'sous titre  *',
                'attr' => [
                    'class' => 'form-control mb-5'
                ]
            ])
            ->add('lien_video', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Lien de la vidéo youtube (src="....... " ) *',
                'attr' => [
                    'class' => 'form-control mb-5'
                ]
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PresseV::class,
        ]);
    }
}
