<?php

namespace App\Repository;

use App\Entity\Housemaid;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Housemaid>
 *
 * @method Housemaid|null find($id, $lockMode = null, $lockVersion = null)
 * @method Housemaid|null findOneBy(array $criteria, array $orderBy = null)
 * @method Housemaid[]    findAll()
 * @method Housemaid[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HousemaidRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Housemaid::class);
    }

//    /**
//     * @return Housemaid[] Returns an array of Housemaid objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Housemaid
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
