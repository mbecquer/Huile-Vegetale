<?php

namespace App\Form;

use App\Entity\Huiles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class HuilesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                "required" => true,
                "attr" => [
                    'placeholder' => "Enter the name of the oil"
                ]
            ])
            ->add('description', TextType::class, [
                "attr" => [
                    'placeholder' => "Enter description"
                ]
            ])
            ->add('capacity', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Capacity'
                ]
            ])
            ->add('price', NumberType::class)
            ->add('image')
            ->add('quantity', NumberType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Huiles::class,
            'translation_domains' => "messages"
        ]);
    }
}
