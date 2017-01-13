<?php

namespace AppBundle\Form;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // On est obligé de spécifier le type pour pouvoir mettre un 3ème argument pour les options
            // Sur symfony 2 on renseignait le type de champ par une chaine de caractère (se référant à un service)
            // Ici le type se réfère à une classe d'où la diff de notation
            // On peut faire plein d'appels chainés car add() return $this
            ->add('title', TextType::class, array(
                'label' => 'Titre',
                'attr' => array(
                    'class' => 'form-group col-xs-12',
                    //'placeholder' => 'Titre de l\'article'
                )
            ))
            ->add('headerImage', FileType::class, array(
                'label' => 'Image d\'en tête',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control col-xs-12',
                )
            ))
            ->add('summary', TextareaType::class, array(
                'label' => 'Résumé de l\'article',
                'attr' => array(
                    'class' => 'form-control col-xs-12',
                    //'placeholder' => 'Résumé'
                )
            ))
            ->add('content', CKEditorType::class, array(
                'label' => 'Contenu',
                'attr' => array(
                    'class' => 'form-control col-xs-12',
                    //'placeholder' => 'Contenu de l\'article'
                )
            ))
            ->add('author', TextType::class, array(
                'label' => 'Auteur',
                'attr' => array(
                    'class' => 'form-control col-xs-12',
                    //'placeholder' => 'Auteur'
                )
            ))
            ->add('publishedAt', DateTimeType::class, array(
                'label' => 'Date de publication',
                'attr' => array(
                    'class' => '',
                )
            ))
        ;
    }
}