<?php

namespace App\Form;

use App\Entity\Categorie; // Importation nécessaire pour EntityType
use App\Entity\Ticket;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // Importation pour le champ de relation
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class TicketPublicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('auteur', EmailType::class, [
                'label' => 'Votre email',
                'attr' => ['placeholder' => 'contact@exemple.com'],
                'constraints' => [new Email(), new NotBlank()],
                'required' => true
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom', // Assurez-vous que getNom() existe dans votre entité Categorie
                'label' => 'Catégorie',
                'placeholder' => 'Choisissez une catégorie',
                'required' => true
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description du problème',
                'attr' => ['rows' => 5, 'placeholder' => 'Décrivez votre problème...'],
                'constraints' => [
                    new Length(min: 20, max: 250),
                    new NotBlank()
                ],
                'required' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}