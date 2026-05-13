<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CitoyenProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => true,
                'label' => 'Nom',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Votre nom'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le nom est obligatoire.']),
                    new Assert\Length([
                        'min' => 2,
                        'max' => 120,
                        'minMessage' => 'Minimum {{ limit }} caractères.',
                        'maxMessage' => 'Maximum {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('prenom', TextType::class, [
                'required' => true,
                'label' => 'Prénom',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Votre prénom'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le prénom est obligatoire.']),
                    new Assert\Length([
                        'min' => 2,
                        'max' => 120,
                        'minMessage' => 'Minimum {{ limit }} caractères.',
                        'maxMessage' => 'Maximum {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('telephone', TextType::class, [
                'required' => false,
                'label' => 'Téléphone',
                'attr' => ['class' => 'form-control', 'placeholder' => '+216 ...'],
                'constraints' => [
                    new Assert\Length([
                        'min' => 8,
                        'max' => 30,
                        'minMessage' => 'Téléphone trop court.',
                        'maxMessage' => 'Téléphone trop long.',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'disabled' => true,
                'attr' => ['class' => 'form-control'],
            ])

            // ✅ Ancien mot de passe (contrôlé dans le controller)
            ->add('currentPassword', PasswordType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Mot de passe actuel',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Saisir votre mot de passe actuel',
                    'autocomplete' => 'current-password',
                ],
            ])

            // ✅ Nouveau + confirmation
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'required' => false,
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                'first_options' => [
                    'label' => 'Nouveau mot de passe',
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Nouveau mot de passe',
                        'autocomplete' => 'new-password',
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe',
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Confirmer le mot de passe',
                        'autocomplete' => 'new-password',
                    ],
                ],
                'constraints' => [
                    // ✅ si rempli, le controller décide de l’appliquer (mais Symfony valide aussi)
                    new Assert\Length([
                        'min' => 8,
                        'minMessage' => 'Minimum {{ limit }} caractères.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'is_edit' => false,
        ]);

        $resolver->setAllowedTypes('is_edit', 'bool');
    }
}
