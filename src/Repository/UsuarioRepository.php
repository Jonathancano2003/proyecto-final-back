<?php

namespace App\Repository;

use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UsuarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuario::class);
    }

    public function add(Usuario $usuario, bool $flush = true): void
    {
        $this->getEntityManager()->persist($usuario);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Usuario $usuario, bool $flush = true): void
    {
        $this->getEntityManager()->remove($usuario);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByEmail(string $email): ?Usuario
    {
        return $this->findOneBy(['email' => $email]);
    }
}
