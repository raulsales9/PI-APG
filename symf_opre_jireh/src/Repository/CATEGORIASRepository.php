<?php

namespace App\Repository;

use App\Entity\CATEGORIAS;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CATEGORIAS>
 *
 * @method CATEGORIAS|null find($id, $lockMode = null, $lockVersion = null)
 * @method CATEGORIAS|null findOneBy(array $criteria, array $orderBy = null)
 * @method CATEGORIAS[]    findAll()
 * @method CATEGORIAS[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CATEGORIASRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CATEGORIAS::class);
    }

    public function save(CATEGORIAS $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CATEGORIAS $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CATEGORIAS[] Returns an array of CATEGORIAS objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CATEGORIAS
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
