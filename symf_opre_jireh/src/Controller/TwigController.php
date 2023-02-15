<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TwigController extends AbstractController
{
    #[Route('/twig/{page?}', name: 'app_panel')]
    public function index(?int $page, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $panel = $entityManager->getRepository(User::class);
        return $this->render('AdminPanel.html.twig', [
            'data' => $panel->findAll(),
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

