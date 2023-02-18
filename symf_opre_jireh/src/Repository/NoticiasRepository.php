<?php

namespace App\Repository;

use App\Entity\Noticias;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Noticias>
 *
 * @method Noticias|null find($id, $lockMode = null, $lockVersion = null)
 * @method Noticias|null findOneBy(array $criteria, array $orderBy = null)
 * @method Noticias[]    findAll()
 * @method Noticias[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoticiasRepository extends ServiceEntityRepository
{
    private $doctrine;
    public function __construct(ManagerRegistry $registry)
    {
        $this->doctrine = $registry;
        parent::__construct($registry, Noticias::class);
    }

    public function save(Noticias $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Noticias $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function insert($request): void
    {

        $file = $request->files->get('imagen');
        $extension = "." . $file->getClientOriginalExtension();


        $file->move('assets/img/tmp/', $file . $extension);

        $noticia = new Noticias;

        $noticia
                ->setTitulo($request->request->get('titulo'))
                ->setTexto($request->request->get('texto'))
                ->setDate(new \DateTime('now'))
                ->setImagen($file . $extension);
        $this->doctrine->getManager()->persist($noticia);
        $this->doctrine->getManager()->flush();
    }

//    /**
//     * @return Noticias[] Returns an array of Noticias objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Noticias
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
