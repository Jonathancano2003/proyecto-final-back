<?php

namespace App\Repository;

use App\Entity\Favorito;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class FavoritoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Favorito::class);
    }

    public function agregarFavorito(Favorito $favorito): void
    {
        $this->_em->persist($favorito);
        $this->_em->flush();
    }

    public function obtenerFavorito(int $id): ?Favorito
    {
        return $this->find($id);
    }

    public function listarFavoritos(): array
    {
        return $this->findAll();
    }

    public function eliminarFavorito(Favorito $favorito): void
    {
        $this->_em->remove($favorito);
        $this->_em->flush();
    }
}
