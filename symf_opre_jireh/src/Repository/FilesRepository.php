<?php

namespace App\Repository;

use App\Entity\Files;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\TextUI\XmlConfiguration\File;

/**
 * @extends ServiceEntityRepository<Files>
 *
 * @method Files|null find($id, $lockMode = null, $lockVersion = null)
 * @method Files|null findOneBy(array $criteria, array $orderBy = null)
 * @method Files[]    findAll()
 * @method Files[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilesRepository extends ServiceEntityRepository
{
    private $doctrine;
    public function __construct(ManagerRegistry $registry)
    {
        $this->doctrine = $registry;
        parent::__construct($registry, Files::class);
    }

    public function save(Files $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Files $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function insert($request, $idUser)
    {
        //request = Array ( [name] => asd [type] => asd [isSubmited] => on )
        $File = new Files;
        
        $File
            ->setName($request->request->get('name'))
            ->setType($request->request->get('type'))
            ->setIsSubmited($request->request->get('isSubmited') === "on" ? true : false)
            ->setDate(new \DateTime('now'))
            ->setIdUser($this->doctrine->getRepository(User::class)->find($idUser));
        
            $this->doctrine->getManager()->persist($File);
            $this->doctrine->getManager()->flush();
        
    }

//    /**
//     * @return Files[] Returns an array of Files objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Files
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
