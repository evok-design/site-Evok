<?php

namespace App\Form;

use App\Entity\NewsletterUsers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsletterUsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Lastname', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Nom *',
                'attr' => [
                    'class' => 'form-control mb-4'
                ]
            ])
            ->add('Firstname', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Prénom *',
                'attr' => [
                    'class' => 'form-control mb-4'
                ]
            ])
            ->add('Email', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Adresse email *',
                'attr' => [
                    'class' => 'form-control mb-4'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NewsletterUsers::class,
        ]);
    }
}
