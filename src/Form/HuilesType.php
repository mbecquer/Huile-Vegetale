<?php

namespace App\Form;

use App\Entity\Family;
use App\Entity\Huiles;
use App\Repository\FamilyRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

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
            ->add('description', TextareaType::class, [
                'required' => false,
                "attr" => [
                    'rows' => 5,
                    'cols' => 25,
                    'placeholder' => 'Saisir description',
                    'style' => "resize:none",
                ]
            ])
            ->add('capacity', NumberType::class, [
                'help' => 'Préciser la capacité en millilitre'
            ])
            ->add('price', NumberType::class, [
                'help' => 'Préciser le prix en euros'
            ])

            ->add('images', FileType::class, [
                'label' => 'Images',
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
            ->add('active', CheckboxType::class, [
                'required' => false,
            ])
            ->add('family', EntityType::class, [
                'class' => Family::class,
                'choice_label' => function ($family) {
                    return $family->getName();
                },
                'expanded' => false,
                'label' => 'Famille',
                'query_builder' => function (FamilyRepository $er) {
                    return $er->createQueryBuilder('f')
                        ->orderBy('f.name', 'ASC');
                },
                'attr' => [
                    'class' => 'text-uppercase'
                ]

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Huiles::class,
            'translation_domains' => "messages"
        ]);
    }
}
