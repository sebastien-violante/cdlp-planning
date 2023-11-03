<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UnaviabilityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('arrivalDate', DateType::class, [
                'label' => 'Date de début',
                'format' => 'ddMMyyyy'
            ])
            ->add('departureDate', DateType::class, [
                'label' => 'Date de fin',
                'format' => 'ddMMyyyy'
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Ajouter l'indisponibilité",
                "attr" => [
                    "class" => "btn btn-primary form-btn w-100",
                ]
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
