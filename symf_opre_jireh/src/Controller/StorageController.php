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

#[Route('/twig', name: 'app_')]
class StorageController extends AbstractController
{
    
    #[Route('/listCategories/{page?}', name: 'listCategories')]
    public function listCategories(?int $page, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        
        $categoria = $entityManager->getRepository(Categorias::class)->findAll();
        $data = [];
        for ($i=0; $i < count($categoria); $i++) { 
            $data[$i] = [
              "idCategoria" => $categoria[$i]->getIdCategoria(),
              "nameCategoria" => $categoria[$i]->getNameCategoria(),
            ];
          } 
        return $this->render('Storage/AdminCategories.html.twig', [
            'data' => $data,
            "page" => $this->getLastPage($page, $session)
        ]);
    }
    
     #[Route('/insertCategories', name: 'insertCategories')]
    public function insert(EntityManagerInterface $gestor, Request $request): Response
    {
        $container = $request->request->all();
        if (count($container) > 1) {
             $gestor->getRepository(Categorias::class)->insertCategorias($request); 
        }
            return $this->render('Storage/AdminInsertCategories.html.twig', []);
    }

    #[Route('/deleteCategories/{categoria}', name: 'deleteCategoria')]
    public function delete(EntityManagerInterface $gestor, string $categoria): Response
    {
         $gestor->getRepository(Categorias::class)->deleteCategorias($categoria); 
        return $this->redirect($this->generateUrl('app_listCategories'));
    }

    #[Route('/updateCategories/{categoria}', name: 'updateCategories')]
    public function updateCategoria(EntityManagerInterface $gestor, Request $request, string $categoria): Response
    {
        $data = $gestor->getRepository(Categorias::class)->find($categoria);
    $container = $request->request->all();
        if (count($container) > 1) {
             $gestor->getRepository(Categorias::class)->updateCategoria($request, $data); 
            return $this->redirect($this->generateUrl("listCategories"));
        } else {
            return $this->render('Storage/AdminUpdateCategories.html.twig', [
                'data' => $data
            ]);
        }
    }  


    
    //Este lista los products con esa categoria
    #[Route('/listProducts/{categoria}', name: 'ListProducts')]
    public function listProducts(?int $page, EntityManagerInterface $entityManager, SessionInterface $session,int $categoria): Response
    {
        $product = $entityManager->getRepository(Products::class)->findAll();
        $data = [];
        for ($i=0; $i < count($product); $i++) { 
            $data[$i] = [
              "idProduct" => $product[$i]->getIdProduct(),
              "nameProduct" => $product[$i]->getNameProduct(),
              "price" => $product[$i]->getPrice(),
              "IdCategoria" =>$product[$i]->getIdCategoria()->getIdCategoria()
            ];
          } 
        return $this->render('Storage/AdminProducts.html.twig', [
            'data' => $data,
            "page" => $this->getLastPage($page, $session)
        ]);
    }

    #[Route('/DetailProducts/{product?}', name: 'DetailProducts')]
    public function DetailProducts(int $product, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $idProduct = $entityManager->getRepository(Products::class);
        $data= $idProduct->find($product);
        return $this->render('Storage/AdminDetailProducts.html.twig', [
            'data'=>$data
        ]);
    } 

    #[Route('/insertProducts', name: 'insertProducts')]
    public function insertProducts(EntityManagerInterface $gestor, Request $request): Response
    {

        $container = $request->request->all();
        if (count($container) > 1) {
            $gestor->getRepository(Products::class)->insertProducts($request); 
        }
            $data = $gestor->getRepository(Categorias::class)->findAll();
            return $this->render('Storage/AdminInsertProducts.html.twig', [
                'data' => $data
            ]);
    }

    #[Route('/deleteProducts/{product}', name: 'deleteProducts')]
    public function deleteProducts(EntityManagerInterface $gestor, int $product): Response
    {
         $gestor->getRepository(Products::class)->deleteProducts($product); 
        return $this->redirect($this->generateUrl('ListProducts'));
    }
    

    #[Route('/updateProducts/{product}', name: 'updateProducts')]
    public function updateProducts(EntityManagerInterface $gestor, Request $request, int $product): Response
    {
        $IdProduct = $gestor->getRepository(Products::class)->find($product);
        $container = $request->request->all();
        if (count($container) > 1) {
             $gestor->getRepository(Products::class)->updateProducts($request, $product); 
            return $this->redirect($this->generateUrl("list"));
        } else {
            $data = $gestor->getRepository(Categorias::class)->find($IdProduct->getIdCategoria());
            return $this->render('Storage/AdminUpdateProducts.html.twig', [
                'data' => $data
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
