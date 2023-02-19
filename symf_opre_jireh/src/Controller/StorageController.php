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

    #[Route('/deleteCategories/{categoria}', name: 'deleteCategories')]
    public function delete(EntityManagerInterface $gestor, string $categoria): Response
    {
         $gestor->getRepository(Categorias::class)->deleteCategoria($categoria); 
        return $this->redirect($this->generateUrl('app_listCategories'));
    }

    #[Route('/updateCategories/{categoria}', name: 'updateCategories')]
    public function updateCategoria(EntityManagerInterface $gestor, Request $request, string $categoria): Response
    {
        $data = $gestor->getRepository(Categorias::class)->find($categoria);
        $container = $request->request->all();
        if (count($container) > 1) {
             $gestor->getRepository(Categorias::class)->updateCategoria($categoria, $request); 
             return $this->redirect($this->generateUrl('app_listCategories'));
        } else {
            return $this->render('Storage/AdminUpdateCategories.html.twig', [
                'data' => $data
            ]);
        }
    }  


    
    //Este lista los products con esa categoria
     #[Route('/listProducts/{categoria}', name: 'ListProducts')]
    public function listProducts( EntityManagerInterface $entityManager,int $categoria): Response
    {
        $product = $entityManager->getRepository(Products::class)->findBy(["IdCategoria"=>$categoria]);
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
            'data' => $data
        ]);
    }
    #[Route('/DetailProducts/{product?}', name: 'DetailProducts')]
    public function DetailProducts(int $product, EntityManagerInterface $entityManager): Response
    {
        $idProduct = $entityManager->getRepository(Products::class);
        $data= $idProduct->find($product);
        return $this->render('Storage/AdminDetailProducts.html.twig', [
            'data'=>$data
        ]);
    } 

    #[Route('/insertProducts/{idCategoria}', name: 'insertProducts')]
    public function insertProducts(EntityManagerInterface $gestor, Request $request, int $idCategoria): Response
    {
        $container = $request->request->all();
        if (count($container) > 1) {
            $gestor->getRepository(Products::class)->insertProducts($container, $idCategoria);
            
        }
        return $this->render('Storage/AdminInsertProducts.html.twig', []);
    }

    #[Route('/deleteProducts/{product}', name: 'deleteProducts')]
    public function deleteProducts(EntityManagerInterface $gestor, int $product): Response
    {
         $gestor->getRepository(Products::class)->deleteProducts($product); 
         return $this->redirect($this->generateUrl('app_ListCategories')); 
    }
    

    #[Route('/updateProducts/{product}', name: 'updateProducts')]
    public function updateProducts(EntityManagerInterface $gestor, Request $request, int $product): Response
    {
        $IdProduct = $gestor->getRepository(Products::class)->find($product);
        $container = $request->request->all();
        if (count($container) > 1) {
             $gestor->getRepository(Products::class)->updateProducts($IdProduct, $request); 
        }
            $categoria = $gestor->getRepository(Categorias::class)->find($IdProduct->getIdCategoria());
            return $this->render('Storage/AdminUpdateProducts.html.twig', [
                'categoria' => $categoria,
                'data' => $IdProduct
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
