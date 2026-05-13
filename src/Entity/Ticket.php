<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // 🔧 mieux : clarifier "auteur" = email
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'email de l'auteur est obligatoire.")]
    #[Assert\Email(message: "Veuillez entrer un email valide.")]
    private ?string $auteur = null;

    #[ORM\Column(type: "datetime_immutable")]
    private ?\DateTimeImmutable $dateOuverture = null;

    #[ORM\Column(type: "datetime_immutable", nullable: true)]
    private ?\DateTimeImmutable $dateCloture = null;

    #[ORM\Column(type: "text")]
    #[Assert\NotBlank(message: "La description est obligatoire.")]
    #[Assert\Length(
        min: 20,
        max: 250,
        minMessage: "La description doit contenir au moins 20 caractères.",
        maxMessage: "La description ne peut pas dépasser 250 caractères."
    )]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etat $etat = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Responsable $responsable = null;

    public function __construct()
    {
        $this->dateOuverture = new \DateTimeImmutable();

        // 🔧 BONUS PROPRETÉ (optionnel mais bien vu)
        // état par défaut si vide (si ton entité Etat le permet)
        // $this->etat = defaultEtat;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self
    {
        $this->auteur = $auteur;
        return $this;
    }

    public function getDateOuverture(): ?\DateTimeImmutable
    {
        return $this->dateOuverture;
    }

    public function getDateCloture(): ?\DateTimeImmutable
    {
        return $this->dateCloture;
    }

    public function setDateCloture(?\DateTimeImmutable $dateCloture): self
    {
        $this->dateCloture = $dateCloture;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;
        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;
        return $this;
    }

    public function getResponsable(): ?Responsable
    {
        return $this->responsable;
    }

    public function setResponsable(?Responsable $responsable): self
    {
        $this->responsable = $responsable;
        return $this;
    }
}