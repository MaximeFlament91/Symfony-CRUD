<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,[
                'label' => 'Titre du livre'
            ])
            ->add('author',TextType::class,[
                'label' => 'Auteur du livre'
            ])
            ->add('description',TextareaType::class,[
                'label' => 'Sypnosis du livre'
            ])
            // ->add('createdAt',DateType::class,[
            //     'label' => 'Creation du livre',
            //     'widget' => 'single_text'
            // ])
            ->add('picture',TextType::class,[
                'label' => 'Couverture du livre'
            ])
            ->add('submit',SubmitType::class,[
                'label' => 'Ajouter ce livre'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
