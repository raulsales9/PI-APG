<?php

namespace App\Controller;

use App\Entity\Categorias;
use App\Entity\Event;
use App\Entity\Products;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TwigController extends AbstractController
{
     #[Route('/listUser/{page?}', name: 'app_panel')]
    public function listUser(?int $page, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $panel = $entityManager->getRepository(User::class)->findAll();
        $data = [];
        for ($i=0; $i < count($panel); $i++) { 
          $data[$i] = [
            "id" => $panel[$i]->getId(),
            "name" => $panel[$i]->getName(),
            "email" => $panel[$i]->getEmail(),
            "roles" => ($panel[$i]->getRoles()[0] === "USER") ? "Usuario" : "Administrador",
            "phone" => $panel[$i]->getPhone(),
            "surnames" => $panel[$i]->getSurnames()
          ];
        }        
        return $this->render('User/AdminPanel.html.twig', [
            'data' => $data,
            'page' => $this->getLastPage($page, $session)
        ]);
    }

    #[Route('/detailUser/{user?null}', name: 'app_detailUser')]
    public function detailUser(EntityManagerInterface $gestor, int $usuario): Response
    {
        $User = $gestor->getRepository(User::class);
        $detailUser = $User->find($usuario);
        return $this->render('detail.html.twig', [
            'detalleClient' => $detailUser 
        ]);
    }

    #[Route('/insertUser', name: 'app_insertUser')]
    public function insert(EntityManagerInterface $gestor, Request $request): Response
    {
        $container = $request->request->all();
        if (count($container) > 1) {
             $gestor->getRepository(User::class)->insert($request); 
            return $this->redirect($this->generateUrl("app_list"));
        } else {
            /* $clients = $gestor->getRepository(Clientes::class)->findAll(); */
           /*  $emps = $gestor->getRepository(Empresa::class)->findAll(); */
            return $this->render('insert.html.twig', [
                /* "clients" => $clients, */
                /* "emps" => $emps, */
            ]);
        }
    }

    #[Route('/deleteUser/{user}', name: 'app_deleteUser')]
    public function delete(EntityManagerInterface $gestor, int $user): Response
    {
         $gestor->getRepository(User::class)->delete($user); 
        return $this->redirect($this->generateUrl('app_list'));
    }

    #[Route('/updateUser/{user}', name: 'app_updateUser')]
    public function update(EntityManagerInterface $gestor, Request $request, int $user): Response
    {
    $container = $request->request->all();
        if (count($container) > 1) {
             $gestor->getRepository(User::class)->update($request, $user); 
            return $this->redirect($this->generateUrl("app_list"));
        } else {
            $clients = $gestor->getRepository(Clientes::class)->find($user);
            $emps = $gestor->getRepository(Empresa::class)->findAll();
            return $this->render('update.html.twig', [
                "clients" => $clients,
                "emps" => $emps 
            ]);
        }
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

    #[Route('/listProducts/{page?}', name: 'app_products')]
    public function listProducts(?int $page, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $event = $entityManager->getRepository(Products::class);
        return $this->render('AdminProducts.html.twig', [
            'data' => $event->findAll(),
            "page" => $this->getLastPage($page, $session)
        ]);
    }

    #[Route('/listCategories/{page?}', name: 'app_categories')]
    public function listCategories(?int $page, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $event = $entityManager->getRepository(Categorias::class);
        return $this->render('AdminCategories.html.twig', [
            'data' => $event->findAll(),
            "page" => $this->getLastPage($page, $session)
        ]);
    }

    #[Route('/listEvent/{page?}', name: 'app_notices')]
    public function listNotices(?int $page, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $event = $entityManager->getRepository(Noticias::class);
        return $this->render('AdminNotices.html.twig', [
            'data' => $event->findAll(),
            "page" => $this->getLastPage($page, $session)
        ]);
    }

    #[Route('/listEvent/{page?}', name: 'app_files')]
    public function listfiles(?int $page, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $event = $entityManager->getRepository(Event::class);
        return $this->render('AdminFiles.html.twig', [
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

