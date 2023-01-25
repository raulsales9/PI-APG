<?php

namespace App\Repository;

use App\Entity\PRODUCTS;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PRODUCTS>
 *
 * @method PRODUCTS|null find($id, $lockMode = null, $lockVersion = null)
 * @method PRODUCTS|null findOneBy(array $criteria, array $orderBy = null)
 * @method PRODUCTS[]    findAll()
 * @method PRODUCTS[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PRODUCTSRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PRODUCTS::class);
    }

    public function save(PRODUCTS $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PRODUCTS $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PRODUCTS[] Returns an array of PRODUCTS objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PRODUCTS
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
