<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\ContractType;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', TextType::class, [
                "label" => "Nom",
                "required" => true,
            ])
            ->add('firstName',TextType::class, [
                "label" => "Prénom(s)",
                "required" => true,
            ])
            ->add('sex', ChoiceType::class, [
                'label' => "sexe",
                "required" => true,
                'choices' => [
                    'Masculin' => 0,
                    'Feminin' => 1,
                ]
            ])
            ->add('email', EmailType::class, [
                "label" => "E-mail",
                'required' => true,
            ])
            ->add('Adress',TextType::class, [
                "label" => "Adresse",
                "required" => true,
            ])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('phoneNumber' , TextType::class, [
                'label' => 'Numero de telephone',
                'required' => true,
            ])
            ->add('typeClient', ChoiceType::class ,  [
                'label' => "type de Client",
                'choices' => array_flip(Client::LIST_TYPE_CLIENT),
            ])
            ->add('isAddContract', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Voulez vous signez une contrat ?',
                'required' => false,
                'attr' => [
                    'class' => 'check-contrat'
                ]
            ])
            ->add('contrat', ContractFormType::class, [
                'mapped' => false,
                'label' => "Creer un nouveau Contrat",
                'required' => false,
            ])
            ->add('save', SubmitType::class, [
                "label" => "Valider"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
