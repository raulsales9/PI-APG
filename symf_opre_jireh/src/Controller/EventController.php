<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
/* use Symfony\Component\Form\FormBuilderInterface; */

class EventController extends AbstractController
{
    #[Route('/listEvent/{page?}', name: 'app_events')]
    public function listEvents(?int $page, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $event = $entityManager->getRepository(Event::class);
        return $this->render('/Events/AdminEvents.html.twig', [
            'data' => $event->findAll(),
            "page" => $this->getLastPage($page, $session)
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
