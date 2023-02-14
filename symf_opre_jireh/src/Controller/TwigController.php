<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TwigController extends AbstractController
{
     #[Route('/listUser/{page?}', name: 'app_panel')]
    public function index(?int $page, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $panel = $entityManager->getRepository(User::class)->findAll();
        $data = [];
        for ($i=0; $i < count($panel); $i++) { 
          $data[$i] = [
            "name" => $panel[$i]->getName(),
            "email" => $panel[$i]->getEmail(),
            "roles" => ($panel[$i]->getRoles()[0] === "USER") ? "Usuario" : "Administrador",
            "phone" => $panel[$i]->getPhone(),
            "surnames" => $panel[$i]->getSurnames()
          ];

        }

        
        return $this->render('AdminPanel.html.twig', [
            'data' => $data,
            'page' => $this->getLastPage($page, $session)
        ]);
    }
 
    #[Route('/listEvent/{page?}', name: 'app_events')]
    public function listEvents(?int $page, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $event = $entityManager->getRepository(Event::class);
        return $this->render('AdminEvents.html.twig', [
            'data' => $event->findAll(),
            "page" => $this->getLastPage($page, $session)
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

