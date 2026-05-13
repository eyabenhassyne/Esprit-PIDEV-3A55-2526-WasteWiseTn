<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isEdit = (bool) ($options['is_edit'] ?? false);

        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['class' => 'form-control', 'placeholder' => 'ex: user@email.com'],
            ])

            // ✅ Si tu as un champ type (citoyen/valorisateur/admin...) dans ton User
            // Si tu n’as pas ce champ, supprime ce bloc.
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'required' => false,
                'choices' => [
                    'Citoyen' => 'CITOYEN',
                    'Valorisateur' => 'VALORIZER',
                    'Admin' => 'ADMIN',
                ],
                'placeholder' => '— Choisir —',
                'attr' => ['class' => 'form-select'],
            ])

            ->add('roles', ChoiceType::class, [
                'label' => 'Rôle',
                'choices' => [
                    'Citoyen' => 'ROLE_USER',
                    'Valorisateur' => 'ROLE_VALORIZER',
                    'Admin' => 'ROLE_ADMIN',
                ],
                'multiple' => true,
                'expanded' => false,
                'attr' => ['class' => 'form-select'],
                'help' => 'Maintiens CTRL pour sélectionner plusieurs rôles (si besoin).',
            ])

            // ✅ password en edit: optionnel + mapped false
            ->add('plainPassword', PasswordType::class, [
                'label' => $isEdit ? 'Nouveau mot de passe (optionnel)' : 'Mot de passe',
                'mapped' => false,
                'required' => !$isEdit,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => $isEdit ? 'Laisser vide pour ne pas changer' : 'Saisir un mot de passe',
                    'autocomplete' => 'new-password',
                ],
                'constraints' => $isEdit
                    ? [ new Length(['min' => 6, 'minMessage' => 'Minimum {{ limit }} caractères.']) ]
                    : [ new Length(['min' => 6, 'minMessage' => 'Minimum {{ limit }} caractères.']) ],
                'help' => $isEdit ? 'Laisse vide si tu ne veux pas changer le mot de passe.' : null,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'is_edit' => false, // ✅ option custom
        ]);
    }
}
