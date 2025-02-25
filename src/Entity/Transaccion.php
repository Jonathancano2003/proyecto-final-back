<?php

namespace App\Entity;

use App\Repository\TransaccionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransaccionRepository::class)]
class Transaccion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $anuncio = null;

    #[ORM\Column(length: 255)]
    private ?string $comprador = null;

    #[ORM\Column]
    private ?float $vendedor = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_venta = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnuncio(): ?string
    {
        return $this->anuncio;
    }

    public function setAnuncio(string $anuncio): static
    {
        $this->anuncio = $anuncio;

        return $this;
    }

    public function getComprador(): ?string
    {
        return $this->comprador;
    }

    public function setComprador(string $comprador): static
    {
        $this->comprador = $comprador;

        return $this;
    }

    public function getVendedor(): ?float
    {
        return $this->vendedor;
    }

    public function setVendedor(float $vendedor): static
    {
        $this->vendedor = $vendedor;

        return $this;
    }

    public function getFechaVenta(): ?\DateTimeInterface
    {
        return $this->fecha_venta;
    }

    public function setFechaVenta(\DateTimeInterface $fecha_venta): static
    {
        $this->fecha_venta = $fecha_venta;

        return $this;
    }
}
