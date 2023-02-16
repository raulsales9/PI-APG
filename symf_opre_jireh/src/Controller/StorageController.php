<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Categorias;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class StorageController extends AbstractController
{
    
    #[Route('/listCategories/{page?}', name: 'app_listCategories')]
    public function listCategories(?int $page, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $event = $entityManager->getRepository(Categorias::class);
        return $this->render('Storage/AdminCategories.html.twig', [
            'data' => $event->findAll(),
            "page" => $this->getLastPage($page, $session)
        ]);
    }
    
    #[Route('/insertCategories', name: 'app_insertCategories')]
    public function insert(EntityManagerInterface $gestor, Request $request): Response
    {
        $container = $request->request->all();
        if (count($container) > 1) {
             $gestor->getRepository(User::class)->insert($request); 
            return $this->redirect($this->generateUrl("app_listCategories"));
        } else {
            /* $clients = $gestor->getRepository(Clientes::class)->findAll(); */
           /*  $emps = $gestor->getRepository(Empresa::class)->findAll(); */
            return $this->render('User/AdminPanelInsert.html.twig', [
                /* "clients" => $clients, */
                /* "emps" => $emps, */
            ]);
        }
    }

    #[Route('/deleteCategories/{categories}', name: 'app_deleteCategories')]
    public function delete(EntityManagerInterface $gestor, string $categorias): Response
    {
         $gestor->getRepository(User::class)->delete($categorias); 
        return $this->redirect($this->generateUrl('app_listCategories'));
    }

    #[Route('/updateCategories/{categories}', name: 'app_updateCategories')]
    public function update(EntityManagerInterface $gestor, Request $request, string $categorias): Response
    {
    $container = $request->request->all();
        if (count($container) > 1) {
             $gestor->getRepository(Categorias::class)->update($request, $categorias); 
            return $this->redirect($this->generateUrl("app_listCategories"));
        } else {
            $clients = $gestor->getRepository(Clientes::class)->find($categorias);
            $emps = $gestor->getRepository(Empresa::class)->findAll();
            return $this->render('Storage/AdminUpdateCategories.html.twig', [
                "clients" => $clients,
                "emps" => $emps 
            ]);
        }
    } 

    
    //Este lista los products con esa categoria
    #[Route('/listProducts/{page?}', name: 'app_Listproducts')]
    public function listProducts(?int $page, EntityManagerInterface $entityManager, SessionInterface $session,int $categories): Response
    {
        $event = $entityManager->getRepository(Products::class);
        $category = $entityManager->getRepository(Categorias::class)->findBy($categories);
        return $this->render('Storage/AdminProducts.html.twig', [
            'data' => $event->findAll(),
            'categories' => $categories,
            "page" => $this->getLastPage($page, $session)
        ]);
    }

    #[Route('/listProductos/{page?}', name: 'app_ListProducts')]
    public function DetailProducts(?int $page, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $event = $entityManager->getRepository(Products::class);
        return $this->render('Storage/AdminProductsDetail.html.twig', [
            'data' => $event->findBy(),
            "page" => $this->getLastPage($page, $session)
        ]);
    }

    #[Route('/insertProducts', name: 'app_insertProducts')]
    public function insertProducts(EntityManagerInterface $gestor, Request $request): Response
    {
        $container = $request->request->all();
        if (count($container) > 1) {
             $gestor->getRepository(User::class)->insert($request); 
            return $this->redirect($this->generateUrl("app_list"));
        } else {
            /* $clients = $gestor->getRepository(Clientes::class)->findAll(); */
           /*  $emps = $gestor->getRepository(Empresa::class)->findAll(); */
            return $this->render('User/AdminPanelInsert.html.twig', [
                /* "clients" => $clients, */
                /* "emps" => $emps, */
            ]);
        }
    }

    #[Route('/deleteProducts/{product}', name: 'app_deleteCategories')]
    public function deleteProducts(EntityManagerInterface $gestor, int $usuario): Response
    {
         $gestor->getRepository(User::class)->delete($usuario); 
        return $this->redirect($this->generateUrl('app_list'));
    }

    #[Route('/updateProducts/{product}', name: 'app_updateCategories')]
    public function updateProducts(EntityManagerInterface $gestor, Request $request, string $product): Response
    {
    $container = $request->request->all();
        if (count($container) > 1) {
             $gestor->getRepository(User::class)->update($request, $product); 
            return $this->redirect($this->generateUrl("app_list"));
        } else {
            $clients = $gestor->getRepository(Clientes::class)->find($product);
            $emps = $gestor->getRepository(Empresa::class)->findAll();
            return $this->render('update.html.twig', [
                "clients" => $clients,
                "emps" => $emps 
            ]);
        }
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
