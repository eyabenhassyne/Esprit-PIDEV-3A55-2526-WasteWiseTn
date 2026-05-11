<?php

namespace App\Form;

use App\Entity\BonAchat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class BonAchatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $requireLogo = (bool) ($options['require_logo'] ?? false);
        $requireImage = (bool) ($options['require_promo_image'] ?? false);

        $builder
            ->add('nomMagasin', TextType::class, [
                'label' => 'Nom du magasin',
                'constraints' => [
                    new NotBlank(),
                    new Length(max: 255),
                ],
            ])
            ->add('logoFile', FileType::class, [
                'mapped' => false,
                'required' => $requireLogo,
                'label' => 'Logo magasin',
                'constraints' => [
                    new File([
                        'maxSize' => '3M',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/webp'],
                        'mimeTypesMessage' => 'Logo invalide (JPG, PNG, WEBP).',
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description du bon',
                'constraints' => [
                    new NotBlank(),
                    new Length(min: 10, max: 2000),
                ],
                'attr' => [
                    'rows' => 3,
                ],
            ])
            ->add('valeurMonetaire', MoneyType::class, [
                'label' => 'Valeur monetaire',
                'currency' => 'TND',
                'constraints' => [
                    new Positive(),
                ],
            ])
            ->add('pointsRequis', IntegerType::class, [
                'label' => 'EcoPoints requis',
                'constraints' => [
                    new Positive(),
                ],
            ])
            ->add('dateDebut', DateType::class, [
                'label' => 'Date debut',
                'widget' => 'single_text',
            ])
            ->add('dateExpiration', DateType::class, [
                'label' => 'Date expiration',
                'widget' => 'single_text',
            ])
            ->add('nombreMaximumUtilisations', IntegerType::class, [
                'label' => 'Nombre max utilisations',
                'constraints' => [
                    new Positive(),
                ],
            ])
            ->add('conditionsUtilisation', TextareaType::class, [
                'label' => 'Conditions utilisation',
                'required' => false,
                'attr' => [
                    'rows' => 3,
                ],
            ])
            ->add('zoneGeographique', TextType::class, [
                'label' => 'Zone geographique',
                'required' => false,
                'constraints' => [
                    new Length(max: 255),
                ],
            ])
            ->add('imagePromotionnelleFile', FileType::class, [
                'mapped' => false,
                'required' => $requireImage,
                'label' => 'Image promotionnelle',
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/webp'],
                        'mimeTypesMessage' => 'Image promotionnelle invalide.',
                    ]),
                ],
            ]);

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event): void {
            $form = $event->getForm();
            $data = $event->getData();
            if (!$data instanceof BonAchat) {
                return;
            }

            $start = $data->getDateDebut();
            $end = $data->getDateExpiration();
            if ($start instanceof \DateTimeInterface && $end instanceof \DateTimeInterface && $end < $start) {
                $form->get('dateExpiration')->addError(new FormError('La date expiration doit etre apres la date debut.'));
            }

            $value = $data->getValeurMonetaire();
            $points = $data->getPointsRequis();
            $minAllowed = (int) ceil($value * 5);
            $maxAllowed = (int) floor($value * 300);
            if ($points < $minAllowed || $points > $maxAllowed) {
                $form->get('pointsRequis')->addError(new FormError(sprintf(
                    'EcoPoints incoherents. Intervalle attendu: %d a %d pour %.2f DT.',
                    $minAllowed,
                    $maxAllowed,
                    $value
                )));
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BonAchat::class,
            'require_logo' => false,
            'require_promo_image' => false,
        ]);
        $resolver->setAllowedTypes('require_logo', 'bool');
        $resolver->setAllowedTypes('require_promo_image', 'bool');
    }
}
