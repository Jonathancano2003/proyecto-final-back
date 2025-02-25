<?php

namespace App\Entity;

use App\Repository\FavoritoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoritoRepository::class)]
class Favorito
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $usuario = null;

    #[ORM\Column(length: 255)]
    private ?string $coche = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_guardado = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuario(): ?string
    {
        return $this->usuario;
    }

    public function setUsuario(string $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getCoche(): ?string
    {
        return $this->coche;
    }

    public function setCoche(string $coche): static
    {
        $this->coche = $coche;

        return $this;
    }

    public function getFechaGuardado(): ?\DateTimeInterface
    {
        return $this->fecha_guardado;
    }

    public function setFechaGuardado(\DateTimeInterface $fecha_guardado): static
    {
        $this->fecha_guardado = $fecha_guardado;

        return $this;
    }
}
