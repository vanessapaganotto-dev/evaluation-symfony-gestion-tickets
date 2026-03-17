<?php

namespace App\Form\Admin;

use App\Entity\Ticket;
use App\Entity\Categorie;
use App\Entity\Etat;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add('description', TextareaType::class)
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
            ])
            ->add('etat', EntityType::class, [
                'class' => Etat::class,
                'choice_label' => 'nom',
            ])
            ->add('responsable', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) : void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}