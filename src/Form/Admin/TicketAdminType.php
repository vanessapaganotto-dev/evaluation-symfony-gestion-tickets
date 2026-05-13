<?php

namespace App\Form\Admin;

use App\Entity\Ticket;
use App\Entity\Categorie;
use App\Entity\Etat;
use App\Entity\Responsable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('auteur', EmailType::class, [
                'label' => 'Email client'
            ])

            ->add('description', TextareaType::class, [
                'label' => 'Description'
            ])

            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir une catégorie',
                'required' => true,
            ])

            ->add('etat', EntityType::class, [
                'class' => Etat::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir un état',
                'required' => true,
            ])

            ->add('responsable', EntityType::class, [
                'class' => Responsable::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir un responsable',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}