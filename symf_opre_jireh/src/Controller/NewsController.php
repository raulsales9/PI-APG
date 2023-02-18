<?php

namespace App\Controller;

use App\Entity\Noticias;
use App\Repository\NoticiasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/twig')]
class NewsController extends AbstractController
{
    #[Route('/news/{page?}', name: 'list_news')]
    public function listNews(?int $page, EntityManagerInterface $doctrine, SessionInterface $session): Response
    {
        $news = $doctrine->getRepository(Noticias::class)->findAll();
        return $this->render('news/listNews.html.twig', [
            'data' => $news,
            "page" => $this->getLastPage($page, $session)
        ]);
    }

    #[Route('/insertNews', name: 'insert_news')]
    public function insertNews(Request $request, NoticiasRepository $repository): Response
    {
      if (count($request->request->all())){

        $repository->insert($request);
      }

      return $this->render('news/insertNews.html.twig', []);
    }

    #[Route('/deleteNews/{id}', name: 'delete_news')]
    public function deleteNews($id, NoticiasRepository $repository, EntityManagerInterface $doctrine): Response
    {
      $news = $doctrine->getRepository(Noticias::class)->find($id);
      $repository->remove($news, true);
      return $this->redirectToRoute('list_news');
    }

    #[Route('/detailsNews/{id}', name: 'details_news')]
    public function detailsNews($id, EntityManagerInterface $doctrine): Response
    {
      $news = $doctrine->getRepository(Noticias::class)->find($id);
      return $this->render('news/detailsNews.html.twig', [
        'task' => $news
      ]);
    }

    #[Route('/updateNews/{id}', name: 'update_news')]
    public function updateNews($id, Request $request, NoticiasRepository $repository, EntityManagerInterface $doctrine): Response
    {
      $news = $doctrine->getRepository(Noticias::class)->find($id);

      if (count($request->request->all())){

        $repository->update($request, $id);
      }

      return $this->render('news/updateNews.html.twig', [
        'task' => $news
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


