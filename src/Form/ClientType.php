<?php

namespace App\Form;

use App\Entity\Client;
use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                "label" => "Prénom"])
            ->add('initial',  TextType::class, [
                "label" => "Nom (initiale)"])
            ->add('arrivalDate', DateTimeType::class, [
                "label" => "Date d'arrivée" ])
            ->add('departureDate', DateTimeType::class, [
                "label" => "Date de départ" ])
            ->add('phoneNumber', TextType::class, [
                "label" => "Numéro de téléphone" ] )
            ->add('adults', IntegerType::class, [
                "label" => "Nombre d'adultes" ])
            ->add('children', IntegerType::class, [
                "label" => "Nombre d'enfants" ])
            ->add('message', TextareaType::class, [
                "label" => "Particularités" ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
