<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'label' => 'Votre email',
                'attr' => ['placeholder'=>'Merci de saisir votre email']
            ])

            // ->add('roles')
            ->add('password',RepeatedType::class,[
                'constraints' => new Length([
                    'min' => 4,
                    'max' => 30,
                ]),
                'type' => PasswordType::class,
                'invalid_message' =>'Les mots de passe ne correspondent pas',
                'required' => true,
                'first_options' => [
                    'label' => 'Votre mot de passe',
                    'attr' => ['placeholder' => 'Merci de saisir votre mot de passe']
                ],
                'second_options' => [
                    'label' => 'Confirmer votre mot de passe',
                    'attr' => ['placeholder' => 'Merci de confirmer votre mot de passe']
                ],
            ])

            ->add('lastname',TextType::class,[
                'label' => 'Votre nom',
                'attr' => ['placeholder'=>'Merci de saisir votre nom']
                ])

            ->add('firstname',TextType::class,[
                'label' => 'Votre prenom',
                'attr' => ['placeholder'=>'Merci de saisir votre prenom']
                ])

            ->add('avatar',TextType::class,[
                'label' => 'Votre avatar',
                'attr' => ['placeholder'=>'Merci de saisir votre avatar']
                ])

            ->add('submit',SubmitType::class,[
                'label' => 'S\'inscrire',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
