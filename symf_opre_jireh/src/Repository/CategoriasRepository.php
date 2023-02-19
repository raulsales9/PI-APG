<?php

namespace App\Repository;

use App\Entity\Products;
use App\Entity\Categorias;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categorias>
 *
 * @method Categorias|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorias|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorias[]    findAll()
 * @method Categorias[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriasRepository extends ServiceEntityRepository
{
    private $doctrine;
    public function __construct(ManagerRegistry $registry)
    {
        $this->doctrine = $registry;
        parent::__construct($registry, Categorias::class);
    }

    public function save(Categorias $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Categorias $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function deleteCategoria(int $Categoria, $productsRepository): void
    {
        $categoria = $this->find($Categoria);
        $products = $this->doctrine->getRepository(Products::class)->findBy(["IdCategoria" => $Categoria]);
        $countProducts = count($products);

        for ($i=0; $i < $countProducts; $i++) { 
            $productsRepository->remove($products[$i], true);
        }
        $this->remove($categoria, true);
    }

    public function insertCategorias( $request) : void {

        $User = new Categorias;
        $User
            ->setNameCategoria($request->request->get("nameCategoria"));
        $this->save($User, true);
    }

    
    public function updateCategoria($id, $request): void
    {
        $result = $this->find($id);
        $result
        ->setNameCategoria($request->request->get("nameCategoria"));
        $this->save($result, true);
    } 

//    /**
//     * @return Categorias[] Returns an array of Categorias objects
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

//    public function findOneBySomeField($value): ?Categorias
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
