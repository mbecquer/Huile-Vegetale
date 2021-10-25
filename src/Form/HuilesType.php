<?php

namespace App\Form;

use App\Entity\Family;
use App\Entity\Huiles;
use App\Repository\FamilyRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
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
                "attr" => [
                    'rows' => 15,
                    'cols' => 20,
                ]
            ])
            ->add('capacity', NumberType::class, [
                'attr' => []
            ])
            ->add('price', NumberType::class)

            ->add('images', FileType::class,[
                'label'=> 'images',
                'multiple'=>true,
                'mapped'=>false,
                'required'=>false

            ])
            ->add('active', CheckboxType::class, [
                'required' => true,

            ])
            ->add('family', EntityType::class, [
                'class' => Family::class,
                'choice_label' => function ($family) {
                    return $family->getName();
                },
                'expanded' => true,
                'label' => 'Famille'
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
