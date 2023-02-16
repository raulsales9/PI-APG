<?php

namespace App\Controller;

use App\Entity\Categorias;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class StorageController extends AbstractController
{
    //Este lista las categorias
    #[Route('/listCategories/{page?}', name: 'app_categories')]
    public function listCategories(?int $page, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $event = $entityManager->getRepository(Categorias::class);
        return $this->render('Storage/AdminCategories.html.twig', [
            'data' => $event->findAll(),
            "page" => $this->getLastPage($page, $session)
        ]);
    }

    //Este lista los products con esa categoria
    #[Route('/listProducts/{page?}', name: 'app_Listproducts')]
    public function listProducts(?int $page, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $event = $entityManager->getRepository(Products::class);
        return $this->render('Storage/AdminProducts.html.twig', [
            'data' => $event->findAll(),
            "page" => $this->getLastPage($page, $session)
        ]);
    }

    #[Route('/listProductos/{page?}', name: 'app_ListProducts')]
    public function DetailProducts(?int $page, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $event = $entityManager->getRepository(Products::class);
        return $this->render('Storage/AdminProducts.html.twig', [
            'data' => $event->findBy(),
            "page" => $this->getLastPage($page, $session)
        ]);
    }

    //Este detalla el producto en si
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
