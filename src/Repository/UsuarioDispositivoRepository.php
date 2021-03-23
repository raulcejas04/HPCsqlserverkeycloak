<?php

namespace App\Repository;

use App\Entity\usuarioDispositivo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method usuarioDispositivo|null find($id, $lockMode = null, $lockVersion = null)
 * @method usuarioDispositivo|null findOneBy(array $criteria, array $orderBy = null)
 * @method usuarioDispositivo[]    findAll()
 * @method usuarioDispositivo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsuarioDispositivoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, usuarioDispositivo::class);
    }

    // /**
    //  * @return usuarioDispositivo[] Returns an array of usuarioDispositivo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?usuarioDispositivo
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
