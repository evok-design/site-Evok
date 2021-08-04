<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Votre nom *',
                'attr' => [
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank(["message" => 'Veuillez renseigner votre nom'])
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre e-mail *',
                'attr' => [
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank(["message" => 'Veuillez renseigner votre email']),
                    new Email(["message" => "Votre adresse e-mail n'est pas valide"])
                ]
            ])
            ->add('subject', ChoiceType::class, [
                'label' => 'Votre demande',
                'placeholder' => false,
                'choices' => [
                    'Informations' => 'Informations',
                    'Devis' => 'Devis',
                    'Candidature' => 'Candidature'
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
                'data' => $options['subject'],
                'required' => false
            ])
            ->add('attachment', FileType::class, [
                'label' => 'Pièce jointe',
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Votre message *',
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 7
                ],
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'subject' => 'Informations'
        ]);
    }
}
