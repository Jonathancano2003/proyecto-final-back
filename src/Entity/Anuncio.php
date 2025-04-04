<?php

namespace App\Entity;

use App\Repository\AnuncioRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnuncioRepository::class)]
class Anuncio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    private ?int $usuario_id = null;

    #[ORM\Column(type: 'integer')]
    private ?int $coche_id = null;

    #[ORM\Column(length: 255)]
    private ?string $estado = null;

    #[ORM\Column(type: 'text')]
    private ?string $descripcion = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $fecha_publicacion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuarioId(): ?int
    {
        return $this->usuario_id;
    }

    public function setUsuarioId(int $usuario_id): self
    {
        $this->usuario_id = $usuario_id;
        return $this;
    }

    public function getCocheId(): ?int
    {
        return $this->coche_id;
    }

    public function setCocheId(int $coche_id): self
    {
        $this->coche_id = $coche_id;
        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;
        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    public function getFechaPublicacion(): ?\DateTimeInterface
    {
        return $this->fecha_publicacion;
    }

    public function setFechaPublicacion(\DateTimeInterface $fecha_publicacion): self
    {
        $this->fecha_publicacion = $fecha_publicacion;
        return $this;
    }
}
