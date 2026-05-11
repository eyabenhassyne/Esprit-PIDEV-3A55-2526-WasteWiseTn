<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ValorisateurProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('telephone', null, ['required' => false])
            ->add('organisationCentre', null, ['required' => false, 'label' => 'Organisation / Centre'])
            ->add('photoProfilFile', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Photo de profil',
                'constraints' => [
                    new File(maxSize: '2M', mimeTypes: ['image/jpeg', 'image/png', 'image/webp']),
                ],
            ])
            ->add('notifyValidation', null, ['required' => false, 'label' => 'Notification email validation'])
            ->add('notifyPoints', null, ['required' => false, 'label' => 'Notification gain EcoPoints'])
            ->add('notifyNouvellesDeclarations', null, ['required' => false, 'label' => 'Notification nouvelles declarations'])
            ->add('theme', ChoiceType::class, [
                'choices' => ['Clair' => 'clair', 'Sombre' => 'sombre'],
            ])
            ->add('langue', ChoiceType::class, [
                'choices' => ['Français' => 'fr', 'English' => 'en'],
            ])
            ->add('statutCentre', ChoiceType::class, [
                'label' => 'Statut du centre',
                'choices' => ['Actif' => 'ACTIF', 'Inactif' => 'INACTIF'],
            ])
            ->add('capaciteMaxJournaliere', IntegerType::class, [
                'required' => false,
                'label' => 'Capacite max journaliere (kg)',
            ])
            ->add('zoneCouverture', null, ['required' => false, 'label' => 'Zone de couverture'])
            ->add('typesDechetsAcceptes', TextareaType::class, [
                'required' => false,
                'label' => 'Types de dechets acceptes',
                'attr' => ['rows' => 3],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
