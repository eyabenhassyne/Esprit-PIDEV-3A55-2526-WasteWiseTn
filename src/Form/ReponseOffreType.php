<?php

namespace App\Form;

use App\Entity\AppelOffre;
use App\Entity\ReponseOffre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReponseOffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantiteProposee')
            ->add('message', TextareaType::class, [
                'required' => true,
            ])
            ->add('appelOffre', EntityType::class, [
                'class' => AppelOffre::class,
                'choice_label' => 'titre',
                'placeholder' => '-- Choisir un appel d\'offre --',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReponseOffre::class,
        ]);
    }
}
