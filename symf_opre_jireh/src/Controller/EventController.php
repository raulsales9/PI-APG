<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
#[Route('/twig')]
class EventController extends AbstractController
{
    #[Route('/listEvent/{page?}', name: 'app_events')]
    public function listEvents(?int $page, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $event = $entityManager->getRepository(Event::class);
        $curDate = new \DateTime('now');
        return $this->render('/Events/AdminEvents.html.twig', [
            'data' => $event->findAll(),
            "page" => $this->getLastPage($page, $session),
            'curDate' => $curDate
        ]);
    }

    #[Route('/detailEvent/{id}', name: 'detail_events')]
    public function detail(EntityManagerInterface $entityManager, $id) : Response {
      $event = $entityManager->getRepository(Event::class)->find($id);
      return $this->render('/Events/detailEvent.html.twig', [
        'task' => $event,
        'cantPeople' => count($event->getIdUser()),
        'people' => $event->getIdUser()
    ]);
    }
    #[Route('/tmp/{img}', name: 'image')]
    public function showImg($img) : Response{
      return $this->render('/image.html.twig', [
        'img' => $img,
      ]);
    }

    #[Route('/updateEvent/{id}', name: 'update_events')]
    public function detailEvent(int $id, EntityManagerInterface $doctrine, Request $request, EventRepository $repository) : Response {
        $data = $doctrine->getRepository(Event::class)->find($id);

        if (count($request->request->all())){
            $repository->update($data, $request);
        }

        return $this->render('/Events/updateEvent.html.twig', [
            'task' => $data
        ]);
    }

    #[Route('/insertEvent', name: 'insert_event')]
    public function insert(Request $request, EventRepository $repository) : Response {

      if (count($request->request->all())){

        $repository->insert($request);
      }
      return $this->render('/Events/insertEvent.html.twig', []);
    }

    #[Route('/deleteEvent/{id}', name: 'delete_event')]
    public function delete($id, EventRepository $repository, EntityManagerInterface $doctrine) : Response {
      $Event = $doctrine->getRepository(Event::class)->find($id);
      $repository->remove($Event, true);
      return $this->redirectToRoute('app_events');
    }


    private function getLastPage($page, $session): int
    {
      if ($page != null) {
        $session->set("page",$page);
        return $page;
      } elseif (!$session->has("page") || !is_numeric($session->get("page"))) {
        $session->set("page",1);
        return 1;
      }
      return $session->get("page");
    } 
}
