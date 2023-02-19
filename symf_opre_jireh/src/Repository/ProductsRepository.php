<?php

namespace App\Repository;

use App\Entity\Categorias;
use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Products>
 *
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends ServiceEntityRepository
{
    private $doctrine;
    public function __construct(ManagerRegistry $registry)
    {
        $this->doctrine = $registry;
        parent::__construct($registry, Products::class);
    }

    public function save(Products $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Products $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    
    public function deleteProducts(int $id): void
    {
        $usuario = $this->find($id);
        //la funcion remove es creada al modelar, y esta ejerce el borrado
        $this->remove($usuario, true);
    }

        
    public function updateProducts(int $id, array $data): void
    {
        $result = $this->find($id);
        $result
        ->setNameProduct($data["nameProduct"])
        ->setIdProduct($data["idProduct"])
        ->setPrice($data["price"]);
        $this->save($result, true);
    } 
           
    public function insertProducts( $request, $idCategoria): void
    {
        $result = new Products;
        $id = $this->getEntityManager()->getRepository(Categorias::class)->find($idCategoria);
        $result
        ->setNameProduct($request["nameProduct"])
        ->setPrice($request["price"])
        ->setIdCategoria($id);
        $this->save($result, true);
    } 
//    /**
//     * @return Products[] Returns an array of Products objects
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

//    public function findOneBySomeField($value): ?Products
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
