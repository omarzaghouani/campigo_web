<?php

namespace App\Repository;

use App\Entity\Transpoteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Transpoteur>
 *
 * @method Transpoteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transpoteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transpoteur[]    findAll()
 * @method Transpoteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TranspoteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transpoteur::class);
    }

//    /**
//     * @return Transpoteur[] Returns an array of Transpoteur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Transpoteur
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
