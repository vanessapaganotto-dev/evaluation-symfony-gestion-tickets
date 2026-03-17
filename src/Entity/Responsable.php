<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Responsable
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type:"integer")]
    private ?int $id = null; // id resp

    #[ORM\Column(type:"string", length:255)]
    private ?string $nom = null; // nom resp

    #[ORM\Column(type:"string", length:255)]
    private ?string $email = null; // email resp

    // ----------------- GETTERS / SETTERS -----------------
    public function getId(): ?int { return $this->id; }
    public function getNom(): ?string { return $this->nom; }
    public function setNom(string $nom): self { $this->nom = $nom; return $this; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }
}