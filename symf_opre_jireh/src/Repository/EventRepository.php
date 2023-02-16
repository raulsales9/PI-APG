<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\FileUploader;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    private $doctrine;
    private $uploader;
    public function __construct(ManagerRegistry $registry,  /* FileUploader $uploader */)
    {
/*         $this->uploader = $uploader; */
        $this->doctrine = $registry;
        parent::__construct($registry, Event::class);
    }

    public function save(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function update($Event, $data) : void
    {

        $startDate = new \DateTime($data->request->get("startDate"));
        $endDate = new \DateTime($data->request->get("endDate"));
        $Event
            ->setName($data->request->get("name"))
            ->setDescription($data->request->get("description"))
            ->setStartDate($startDate)
            ->setEndDate($endDate)
            ->setPlace($data->request->get("place"));
            $this->doctrine->getManager()->persist($Event);
            $this->doctrine->getManager()->flush();
    }

    public function insert($data) : void
    {
        $Event = new Event;
        $startDate = new \DateTime($data->request->get("startDate"));
        $endDate = new \DateTime($data->request->get("endDate"));
        $file = $data->files->get('imagen');
        $type = $file->getMimeType();
        if ($type === "image/png") {
            $extension = ".png";
        }else if($type === "image/jpg"){
            $extension = ".jpg";
        }else if($type === "image/jpeg"){
            $extension = ".jpeg";
        }


        $file->move('assets/img/tmp/', $file . $extension);

        $getIds = $this->doctrine->getRepository(Event::class)->findAll();
        $maxId = 0;
        for ($i=0; $i < count($getIds); $i++) { 
            if ($getIds[$i]->getId() > $maxId) {
                $maxId = $getIds[$i]->getId(); 
            }
        }
        $maxId++;
       $newId = $maxId;

        $Event
            ->setId($newId)
            ->setName($data->request->get("name"))
            ->setPlace($data->request->get("place"))
            ->setStartDate($startDate)
            ->setEndDate($endDate)
            ->setDescription($data->request->get("description"))
            ->setImagen($file . $extension);
        $this->doctrine->getManager()->persist($Event);
        $this->doctrine->getManager()->flush();
    }

/*     public function updateAssistant($Event, $User)
    {

        $Event[0]->addIdUser($User[0]);
    } */

//    /**
//     * @return Event[] Returns an array of Event objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Event
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
