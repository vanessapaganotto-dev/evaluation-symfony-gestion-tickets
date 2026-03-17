<?php

namespace App\Form;

use App\Entity\Ticket;
use App\Entity\Categorie;
use App\Entity\Etat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert; // contraintes validation

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('auteur', EmailType::class, [
                'label' => 'Votre email', 
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Email obligatoire']), // pas vide
                    new Assert\Email(['message' => 'Email invalide'])
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Description obligatoire']),
                    new Assert\Length([
                        'min' => 20, 
                        'max' => 250, 
                        'minMessage' => 'Minimum 20 caractères',
                        'maxMessage' => 'Maximum 250 caractères'
                    ])
                ],
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom', // affiche le nom de la catégorie
                'label' => 'Catégorie',
                'placeholder' => 'Choisir une catégorie',
            ])
            ->add('etat', EntityType::class, [
                'class' => Etat::class,
                'choice_label' => 'nom',
                'label' => 'Etat',
                'placeholder' => 'Choisir un état',
                'disabled' => true // client ne peut pas changer l'état
            ])
            ->add('responsable', EntityType::class, [
                'class' => \App\Entity\Responsable::class,
                'choice_label' => 'nom',
                'label' => 'Responsable',
                'disabled' => true // client ne peut pas choisir
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class, // lié à l'entité Ticket
        ]);
    }
}