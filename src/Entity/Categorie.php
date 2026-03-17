<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Categorie
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type:"integer")]
    private ?int $id = null; // id unique catégorie

    #[ORM\Column(type:"string", length:100)]
    private ?string $nom = null; // nom catégorie (Incident, Panne...)

    // ----------------- GETTERS / SETTERS -----------------
    public function getId(): ?int { return $this->id; } // recup id
    public function getNom(): ?string { return $this->nom; } // recup nom
    public function setNom(string $nom): self { $this->nom = $nom; return $this; } // modif nom
}