<?php

namespace App\Form;

use App\Entity\AppelOffre;
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AppelOffre::class,
        ]);
    }
}
