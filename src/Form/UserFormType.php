<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', TextType::class, [
                'label' => "Nom",
                "required" => true,
            ])
            ->add('firstName' , TextType::class, [
                'label' => "Prenom(s)",
                "required" => true,
            ])
            ->add('email', EmailType::class ,  [
                'label' => "E-mail",
            ])
            ->add('password', RepeatedType::class, [
                "type" => PasswordType::class,
                'invalid_message' => 'Les Mot de passe ne correspond pas',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                "first_options" => [
                    'label' => "Entrer votre mot de passe"
                ],
                'second_options' => [
                    "label" => "Confirmer Votre Mot de passe",
                ]
            ])
            ->add('save' , SubmitType::class, [
                'label' => "s'incrire",
                'attr' => [
                    "class" => "btn btn-primary w-100"
                ]
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
