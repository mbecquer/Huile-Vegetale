<?php

namespace App\Form;

use App\Entity\Family;
use App\Repository\FamilyRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FamilyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [

                'required' => true,
                'help' => 'Saisir en majuscules',
                "attr" => [
                    'placeholder' => "Entrer la famille",

                    'style' => 'width: 200px',
                ]
            ])
            ->add('active', CheckboxType::class, [
                'required' => false
            ])
            ->add('story', TextareaType::class, [
                "attr" => [
                    'rows' => 15,
                    'cols' => 20,
                    'placeholder' => 'Saisir l\'histoire de la famille',
                    'required' => false
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Family::class,
        ]);
    }
}
