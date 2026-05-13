<?php

namespace App\Form;

use App\Entity\IndicateurImpact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class IndicateurImpactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('totalKgRecoltes', NumberType::class, [
                'label' => 'Total de déchets récoltés (kg)',
                'attr' => ['placeholder' => 'Ex: 150.5', 'step' => '0.01'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le total de kg récoltés est obligatoire']),
                    new Assert\Positive(['message' => 'Le total doit être un nombre positif']),
                    new Assert\LessThan([
                        'value' => 100000,
                        'message' => 'Le total ne peut pas dépasser 100000 kg',
                    ]),
                ],
            ])
            ->add('co2Evite', NumberType::class, [
                'label' => 'CO2 évité (kg)',
                'attr' => ['placeholder' => 'Ex: 75.25', 'step' => '0.01'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le CO2 évité est obligatoire']),
                    new Assert\PositiveOrZero(['message' => 'Le CO2 évité doit être positif ou zéro']),
                    new Assert\LessThan([
                        'value' => 50000,
                        'message' => 'Le CO2 évité ne peut pas dépasser 50000 kg',
                    ]),
                ],
            ])
            ->add('dateCalcul', DateTimeType::class, [
                'label' => 'Date de calcul',
                'widget' => 'single_text',
                'attr' => ['placeholder' => 'Sélectionnez la date et l\'heure'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'La date de calcul est obligatoire']),
                    new Assert\LessThanOrEqual([
                        'value' => 'now',
                        'message' => 'La date ne peut pas être dans le futur',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => IndicateurImpact::class,
        ]);
    }
}