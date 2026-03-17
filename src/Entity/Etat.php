<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Etat
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type:"integer")]
    private ?int $id = null; // id état

    #[ORM\Column(type:"string", length:100)]
    private ?string $nom = null; // nom état (Nouveau, Ouvert...)

    // ----------------- GETTERS / SETTERS -----------------
    public function getId(): ?int { return $this->id; } 
    public function getNom(): ?string { return $this->nom; }
    public function setNom(string $nom): self { $this->nom = $nom; return $this; }
}