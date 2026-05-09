<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Participation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // 1. Nom du Citoyen (TextType)
            ->add('nomCitoyen', TextType::class, [
                'label' => 'Nom du Citoyen',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez votre nom complet...'
                ]
            ])
            
            // 2. Date d'inscription
            ->add('dateInscription', DateType::class, [
               'widget' => 'single_text',
               'label' => "Date d'inscription",
               'attr' => [
                   'class' => 'form-control',
                   'max' => (new \DateTime())->format('Y-m-d') 
                ]
            ])

            // 3. Événement (EntityType)
            ->add('evenement', EntityType::class, [
                'class' => Evenement::class,
                'choice_label' => 'title', 
                'label' => 'Événement sélectionné',
                'attr' => [
                    'class' => 'form-select bg-light', // bg-light bech i-ben differant chwaya
                ],
                
                'placeholder' => '--- Sélection de l\'action ---',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participation::class,
        ]);
    }
}