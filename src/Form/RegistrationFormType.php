<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'empty_data' => '',
                'constraints' => [
                    new NotBlank(message: 'Veuillez saisir votre nom.'),
                    new Length(min: 2, max: 120),
                ],
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'empty_data' => '',
                'constraints' => [
                    new NotBlank(message: 'Veuillez saisir votre prénom.'),
                    new Length(min: 2, max: 120),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => [
                    new NotBlank(message: 'Veuillez saisir un email.'),
                    new Email(message: 'Email invalide.'),
                ],
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
                'empty_data' => '',
                'constraints' => [
                    // accepte vide, sinon valide format/longueur
                    new Regex([
                        'pattern' => '/^$|^[0-9+\s\-]{8,30}$/',
                        'message' => 'Téléphone invalide (8 à 30 caractères, chiffres + espaces + + -).',
                    ]),
                ],
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Rôle',
                'choices' => [
                    'Citoyen'      => User::TYPE_CITIZEN,
                    'Valorisateur' => User::TYPE_VALORIZER,
                ],
                'expanded' => true,   // radio buttons
                'multiple' => false,
                'data' => User::TYPE_CITIZEN,
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => "J'accepte les conditions",
                'mapped' => false,
                'constraints' => [
                    new IsTrue(message: 'Vous devez accepter les conditions.'),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                'constraints' => [
                    new NotBlank(message: 'Veuillez saisir un mot de passe.'),
                    new Length(
                        min: 8,
                        max: 4096,
                        minMessage: 'Votre mot de passe doit contenir au moins {{ limit }} caractères.'
                    ),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}