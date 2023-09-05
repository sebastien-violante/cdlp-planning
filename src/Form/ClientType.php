<?php

namespace App\Form;

use App\Entity\Client;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                "label" => "Prénom"])
            ->add('initial',  TextType::class, [
                "label" => "Nom"])
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
                "label" => "Particularités",
                "required" => false ])
            ->add("envoyer", SubmitType::class, [
                "label" => "Enregistrer",
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
