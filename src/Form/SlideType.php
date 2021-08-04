<?php

namespace App\Form;

use App\Entity\Slide;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SlideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slider', EntityType::class,  array(
                'class'   => 'App\Entity\Slider',
                'choice_label'   => 'name',
                'label' => 'nom du slider *',
                'data' => $options['data']->getSlider(),
                'attr' => [
                    'class' => 'form-control mb-4'
                ]
            ))
            ->add('url_image',FileType::class,[
                'label' => "Choix de l'image * (1200px X 500px)",
                'data_class' => null,
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-4'
                ]
            ])
            ->add('description', TextType::class,[
                'label' => "Description de l'image (pour le référencement) *",
                'attr' => [
                    'class' => 'form-control mb-4'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Slide::class,
        ]);
    }
}
