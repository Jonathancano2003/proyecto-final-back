<?php

namespace App\Entity;

use App\Repository\CocheRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CocheRepository::class)]
class Coche
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $marca = null;

    #[ORM\Column(length: 100)]
    private ?string $modelo = null;

    #[ORM\Column]
    private ?int $año = null;

    #[ORM\Column]
    private ?int $kilometraje = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarca(): ?string
    {
        return $this->marca;
    }

    public function setMarca(string $marca): static
    {
        $this->marca = $marca;

        return $this;
    }

    public function getModelo(): ?string
    {
        return $this->modelo;
    }

    public function setModelo(string $modelo): static
    {
        $this->modelo = $modelo;

        return $this;
    }

    public function getAño(): ?int
    {
        return $this->año;
    }

    public function setAño(int $año): static
    {
        $this->año = $año;

        return $this;
    }

    public function getKilometraje(): ?int
    {
        return $this->kilometraje;
    }

    public function setKilometraje(int $kilometraje): static
    {
        $this->kilometraje = $kilometraje;

        return $this;
    }
}
