<?php

namespace App\Form;

use App\Entity\AppelOffre;
use App\Entity\Valorisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppelOffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('quantiteDemandee')
            ->add('dateLimiteInput', DateTimeType::class, [
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'mapped' => false,
            ])
            ->add('valorisateur', EntityType::class, [
                'class' => Valorisateur::class,
                'choice_label' => static function (Valorisateur $valorisateur): string {
                    return sprintf(
                        'Valorisateur #%d (%s)',
                        $valorisateur->getId() ?? 0,
                        $valorisateur->getEmail() !== '' ? $valorisateur->getEmail() : 'email inconnu'
                    );
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AppelOffre::class,
        ]);
    }
}
