<?php

namespace App\Form;

use App\Entity\Contract;
use App\Entity\ContractType;
use Doctrine\DBAL\Types\BigIntType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class ContractFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number', TextType::class, [
                'label' => 'numero du contrat'
            ])
            ->add('amountInsured', TextType::class, [
                'label' => "montant assuré"
            ])
            ->add('dateStart', DateType::class, [
                'required' => false,
            ])
            ->add('dateEnd', DateType::class, [
                'required' => false,
            ])
            ->add("contractType", ContractTypeFormType::class, [
                'label' => false,
                'data' => null,
                'required' => false,
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contract::class,
        ]);
    }
}
