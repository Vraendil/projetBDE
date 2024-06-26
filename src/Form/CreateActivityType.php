<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\City;
use App\Entity\Place;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateActivityType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $inscriptionDate = new \DateTime();
        $inscriptionDate->modify('+2 days');
        $inscriptionDateFormatted = $inscriptionDate->format('Y-m-d\TH:i');
        $startingDate = new \DateTime();
        $startingDate->modify('+3 days');
        $nowFormatted = $startingDate->format('Y-m-d\TH:i');





        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la sortie',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('startingDateTime', DateTimeType::class, [
                'label' => 'Date de la sortie',
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'id' => 'startDate',
                    'name' => 'startDate',
                    'class' => 'form-control startDate',
                    'min' => $nowFormatted]
            ])

            ->add('inscriptionLimitDate', DateTimeType::class, [
                'label' => 'Date limite d\'inscription',
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'id' => 'limitDate',
                    'name' => 'limitDate',
                    'class' => 'form-control limitDate datetimepicker',
                    'min' => $inscriptionDateFormatted]
            ])
            ->add('maxInscription', IntegerType::class, [
                'label' => 'Nombre de places',
                'attr' => ['class'=>'form-control']
            ])
            ->add('durationInMinutes', IntegerType::class, [
                'mapped'=>false,
                'label' => 'Durée (en minutes)',
                'required' => true, // ou false selon vos besoins
                'attr' => ['class'=>'form-control',
                    'min' => 5,
                    'step' => 5
                    ]
            ])


            ->add('city', EntityType::class, [
                'label' => 'Ville',
                'class' => City::class,
                'choice_label' => 'name',
                'placeholder'=>'Choisissez une ville',
                'mapped' => false,
                'required' => true,
                'attr'=>[
                    'class' => 'city-selector form-control',
                ]
            ])
            ->add('place', EntityType::class, [
                'label' => 'Place',
                'label_attr'=>['class' => 'place-label'],
                'class' => Place::class,
                'placeholder'=>'Choisissez un lieu',
                'required' =>true,
                'choice_label'=>'name',
                'attr' => [
                    'class' => 'place-selector form-control'
                ]
            ])

            ->add('adresse', TextType::class, [
                'mapped'=>false,
                'disabled'=>true,
                'label' => 'Adresse: ',
                'label_attr' => ['class'=>'labels-hidden label-adresse',
                    'style' => 'display:none'],
                'attr' => ['class' => 'form-control adresse',
                    'id'=>'adresse',
                    'style' => 'display:none'],
            ])
               ->add('zipcode', TextType::class, [
                    'mapped'=>false,
                    'label' => 'Code Postal: ',
                   'disabled'=>true,
                   'label_attr' => ['class'=>'labels-hidden label-zipcode',
                       'style' => 'display:none'],
                    'attr' => ['class' => 'form-control zipcode',
                    'id'=>'zipcode',
                    'style' => 'display:none'],
            ])
            ->add('coordinates', TextType::class, [
                'mapped'=>false,
                'disabled'=>true,
                'label' => 'Latitude | Longitude: ',
                'label_attr' => ['class'=>'labels-hidden label-coordinates',
                    'style' => 'display:none'],
                'attr' => ['class' => 'form-control coordinates',
                    'id'=>'coordinates',
                    'style' => 'display:none'],
            ])




            ->add('description', TextareaType::class, [
                'label' => 'Description et informations',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])

            -> add('save', SubmitType::class, [
                'label' => 'Enregister',
                'attr' => [
                    'class' => 'btn btn-outline-primary',
                    'style' => 'margin-top:10%'
                ]
            ])

            -> add('publish', SubmitType::class, [
                'label' => 'Publier',
                'attr' => [
                    'class' => 'btn btn-primary',
                    'style' => 'margin-top:10%'
                ]
            ])



        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}
