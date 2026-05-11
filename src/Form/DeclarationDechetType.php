<?php

namespace App\Form;

use App\Entity\DeclarationDechet;
use App\Entity\TypeDechet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class DeclarationDechetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeDechet', EntityType::class, [
                'class' => TypeDechet::class,
                'choice_label' => 'libelle',
                'placeholder' => 'Selectionner un type...',
                'label' => 'Type de dechet *',
            ])
            ->add('quantite', NumberType::class, [
                'label' => 'Quantite *',
                'attr' => [
                    'placeholder' => 'Ex: 5',
                    'min' => '1',
                    'required' => 'required',
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'La quantite est obligatoire.']),
                    new Assert\Positive(['message' => 'La quantite doit etre positive.']),
                ],
            ])
            ->add('unite', ChoiceType::class, [
                'label' => 'Unite *',
                'choices' => [
                    'Kilogrammes (kg)' => 'kg',
                    'Litres (L)' => 'L',
                    'Metres cubes (m3)' => 'm3',
                    'Pieces' => 'pieces',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'rows' => 4,
                    'placeholder' => 'Decrivez l etat du dechet...',
                ],
                'constraints' => [
                    new Assert\Length([
                        'min' => 10,
                        'minMessage' => 'La description doit contenir au moins 10 caracteres.',
                        'max' => 5000,
                    ]),
                ],
            ])
            ->add('photoFile', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Photo du dechet *',
                'attr' => ['accept' => 'image/*'],
                'constraints' => [
                    new Assert\File([
                        'maxSize' => '5M',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/webp'],
                        'mimeTypesMessage' => 'Format autorise: JPEG, PNG, WebP.',
                    ]),
                ],
            ])
            ->add('latitude', HiddenType::class, [
                'required' => false,
            ])
            ->add('longitude', HiddenType::class, [
                'required' => false,
            ])
            ->add('scoreIa', HiddenType::class, [
                'required' => false,
                'empty_data' => '',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DeclarationDechet::class,
        ]);
    }
}
