<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Ticket
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type:"integer")]
    private ?int $id = null; // id unique

    #[ORM\Column(type:"string", length:255)]
    #[Assert\NotBlank] 
    #[Assert\Email]
    private ?string $auteur = null; // email client

    #[ORM\Column(type:"datetime_immutable")]
    private ?\DateTimeInterface $dateOuverture = null; // date ouverture auto

    #[ORM\Column(type:"datetime_immutable", nullable:true)]
    private ?\DateTimeInterface $dateCloture = null; // date fermeture admin

    #[ORM\Column(type:"text")]
    #[Assert\NotBlank]
    #[Assert\Length(min:20, max:250)]
    private ?string $description = null; // texte 20-250 chars

    #[ORM\ManyToOne(targetEntity: Categorie::class)]
    private ?Categorie $categorie = null; // cat choisie

    #[ORM\ManyToOne(targetEntity: Etat::class)]
    private ?Etat $etat = null; // état ticket

    #[ORM\ManyToOne(targetEntity: Responsable::class)]
    private ?Responsable $responsable = null; // qui traite

    // ----------------- GETTERS / SETTERS -----------------
    public function getId(): ?int { return $this->id; } // get id

    public function getAuteur(): ?string { return $this->auteur; }
    public function setAuteur(string $auteur): self { $this->auteur = $auteur; return $this; }

    public function getDateOuverture(): ?\DateTimeInterface { return $this->dateOuverture; }
    public function setDateOuverture(\DateTimeInterface $dateOuverture): self { $this->dateOuverture = $dateOuverture; return $this; }

    public function getDateCloture(): ?\DateTimeInterface { return $this->dateCloture; }
    public function setDateCloture(?\DateTimeInterface $dateCloture): self { $this->dateCloture = $dateCloture; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(string $description): self { $this->description = $description; return $this; }

    public function getCategorie(): ?Categorie { return $this->categorie; }
    public function setCategorie(?Categorie $categorie): self { $this->categorie = $categorie; return $this; }

    public function getEtat(): ?Etat { return $this->etat; }
    public function setEtat(?Etat $etat): self { $this->etat = $etat; return $this; }

    public function getResponsable(): ?Responsable { return $this->responsable; }
    public function setResponsable(?Responsable $responsable): self { $this->responsable = $responsable; return $this; }
}