<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'style' => "width:200px",
                    'placeholder' => "Titre de l'article"
                ]
            ])
            ->add('content', TextareaType::class, [
                "label" => false,
                'attr' => [
                    'rows' => 15,
                    'cols' => 20,
                    'placeholder' => 'Contenu',
                    'style' => "resize:none; width:100%;border:none;outline:none;",

                ]
            ])
            ->add('image', FileType::class, [
                "required" => false,
                "mapped" => false,
                'label' => false,
                'multiple' => true,
                'attr' => [
                    'style' => "width:200px"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'translation_domains' => "messages"
        ]);
    }
}
