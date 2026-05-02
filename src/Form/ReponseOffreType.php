<?php

namespace App\Form;

use App\Entity\AppelOffre;
use App\Entity\Citoyen;
use App\Entity\ReponseOffre;
use App\Repository\AppelOffreRepository;
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
                'query_builder' => static fn (AppelOffreRepository $repository) => $repository
                    ->createQueryBuilder('a')
                    ->andWhere('a.dateLimite >= :now')
                    ->setParameter('now', new \DateTimeImmutable())
                    ->orderBy('a.dateLimite', 'ASC'),
            ])
            ->add('citoyen', EntityType::class, [
                'class' => Citoyen::class,
                'choice_label' => static fn (Citoyen $citoyen): string => sprintf(
                    '%s %s (%s)',
                    $citoyen->getPrenom(),
                    $citoyen->getNom(),
                    $citoyen->getEmail() !== '' ? $citoyen->getEmail() : 'email inconnu'
                ),
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
