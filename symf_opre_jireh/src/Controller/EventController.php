<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Event;

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
    public function detailEvent(int $id, EntityManagerInterface $doctrine) : Response {
        $data = $doctrine->getRepository(Event::class)->find($id);
        return $this->render('/Events/updateEvent.html.twig', [
            'task' => $data
        ]);
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
