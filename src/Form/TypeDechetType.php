<?php

namespace App\Form;

use App\Entity\TypeDechet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeDechetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', ChoiceType::class, [
                'choices' => [
                    'Plastique' => 'Plastique',
                    'Verre' => 'Verre',
                    'Papier / Carton' => 'Papier / Carton',
                    'Métal' => 'Métal',
                    'Déchets électroniques' => 'Déchets électroniques',
                    'Textile' => 'Textile',
                    'Bois' => 'Bois',
                    'Batteries' => 'Batteries',
                    'Huiles usées' => 'Huiles usées',
                    'Déchets organiques' => 'Déchets organiques',
                    'Déchets médicaux' => 'Déchets médicaux',
                    'Déchets dangereux' => 'Déchets dangereux',
                    'Déchets industriels' => 'Déchets industriels',
                    'Déchets ménagers' => 'Déchets ménagers',
                ],
            ])

            ->add('valeurPointsKg', NumberType::class, [
                'scale' => 0
            ])

            ->add('descriptionTri', TextareaType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TypeDechet::class,
        ]);
    }
}
