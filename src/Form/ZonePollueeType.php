<?php

namespace App\Form;

use App\Entity\ZonePolluee;
use App\Entity\IndicateurImpact;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ZonePollueeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomZone', TextType::class, [
                'label' => 'Nom de la zone',
                'attr' => ['placeholder' => 'Ex: Plage de Hammamet'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le nom de la zone est obligatoire']),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères',
                        'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('coordonneesGps', TextType::class, [
                'label' => 'Coordonnées GPS',
                'attr' => ['placeholder' => 'Ex: 36.4025, 10.1817'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Les coordonnées GPS sont obligatoires']),
                    new Assert\Regex([
                        'pattern' => '/^-?\d+\.?\d*,\s*-?\d+\.?\d*$/',
                        'message' => 'Format invalide. Utilisez: latitude, longitude (Ex: 36.4025, 10.1817)',
                    ]),
                ],
            ])
            ->add('niveauPollution', IntegerType::class, [
                'label' => 'Niveau de pollution (1-10)',
                'attr' => ['placeholder' => 'Entrez un nombre entre 1 et 10'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le niveau de pollution est obligatoire']),
                    new Assert\Range([
                        'min' => 1,
                        'max' => 10,
                        'notInRangeMessage' => 'Le niveau de pollution doit être entre {{ min }} et {{ max }}',
                    ]),
                ],
            ])
            ->add('indicateur', EntityType::class, [
                'class' => IndicateurImpact::class,
                'choice_label' => function(IndicateurImpact $indicateur) {
                    return sprintf(
                        'Impact: %.2f kg récoltés - %.2f kg CO2 évité',
                        $indicateur->getTotalKgRecoltes(),
                        $indicateur->getCo2Evite()
                    );
                },
                'label' => 'Indicateur d\'impact associé',
                'placeholder' => 'Sélectionnez un indicateur (optionnel)',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ZonePolluee::class,
        ]);
    }
}