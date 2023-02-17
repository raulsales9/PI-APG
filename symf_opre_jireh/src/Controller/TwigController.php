<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\User;
use App\Repository\FilesRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/twig', name: 'app_')]
class TwigController extends AbstractController
{
    #[Route('/listUser/{page?}', name: 'User')]
    public function listUser(?int $page, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $User = $entityManager->getRepository(User::class)->findAll();
        $data = [];
        for ($i=0; $i < count($User); $i++) { 
          $data[$i] = [
            "id" => $User[$i]->getId(),
            "name" => $User[$i]->getName(),
            "email" => $User[$i]->getEmail(),
            "roles" => ($User[$i]->getRoles()[0] === "USER") ? "Usuario" : "Administrador",
            "phone" => $User[$i]->getPhone(),
            "surnames" => $User[$i]->getSurnames()
          ];
        }        
        return $this->render('User/AdminPanel.html.twig', [
            'data' => $data,
            'page' => $this->getLastPage($page, $session)
        ]);
    }

    #[Route('/detailUser/{usuario?null}', name: 'detailUser')]
    public function detailUser(EntityManagerInterface $entityManager, int $usuario): Response
    {
        $User = $entityManager->getRepository(User::class)->find($usuario);
        $data = [
            "id" => $User->getId(),
            "name" => $User->getName(),
            "surnames" => $User->getSurnames(),
            "email" => $User->getEmail(),
            "roles" => ($User->getRoles()[0] === "USER") ? "Usuario" : "Administrador",
            "files" => [], 
            "phone" => $User->getPhone(),
            "events" => []
          ];

          for($i = 0; $i < count($User->getFiles()); $i++){
            $data["files"][$i] = [
                "idFile" => $User->getFiles()[$i]->getIdFile(),
                "name" => $User->getfiles()[$i]->getName(),
                "type" => $User->getFiles()[$i]->getType(),
                "isSubmited" => html_entity_decode(($User->getFiles()[$i]->isIsSubmited()) ? '&#x2713;' : "")
            ];
          }

          for($i = 0; $i < count($User->getEvents()); $i++){
            $data["events"][$i] = [
                "id" => $User->getEvents()[$i]->getId(),
                "name" => $User->getEvents()[$i]->getName(),
                "place" => $User->getEvents()[$i]->getPlace()
            ];
          }
        return $this->render('User/AdminDetailPanel.html.twig', [
            'detalleClient' => $data 
        ]);
    }

    #[Route('/insertUser', name: 'insertUser')]
    public function insert(EntityManagerInterface $gestor, Request $request): Response
    {
        $container = $request->request->all();
        if (count($container) > 1) {
             $gestor->getRepository(User::class)->insertUser($request); 
            return $this->redirect($this->generateUrl("User"));
        } else {
            /* $clients = $gestor->getRepository(Clientes::class)->findAll(); */
           /*  $emps = $gestor->getRepository(Empresa::class)->findAll(); */
            return $this->render('User/AdminInsertPanel.html.twig', [
                /* "clients" => $clients, */
                /* "emps" => $emps, */
            ]);
        }
    }
    #[Route('/insertFiles/{idUser}', name: 'insertUser')]
    public function insertFile(int $idUser, EntityManagerInterface $doctrine, Request $request, FilesRepository $repository): Response{
        $user = $doctrine->getRepository(User::class)->find($idUser);

        if (count($request->request->all())) {
            $repository->insert($request, $idUser);
        }
        return $this->render('Files/insertFiles.html.twig', [
            'user' => $user
        ]);
    }
    #[Route('/updateFiles/{idUser}', name: 'insertUser')]
    public function updateFiles(int $idUser, EntityManagerInterface $doctrine, Request $request, FilesRepository $repository): Response{
        $user = $doctrine->getRepository(User::class)->find($idUser);
        $userFiles = $user->getFiles();
        if (count($request->request->all())) {
            $repository->updateFiles($request, $idUser);
        }
        return $this->render('Files/updateFiles.html.twig', [
            'user' => $user,
            'userFiles' => $userFiles
        ]);
    }

    #[Route('/deleteUser/{usuario}', name: 'deleteUser')]
    public function delete(EntityManagerInterface $gestor, int $usuario): Response
    {
         $gestor->getRepository(User::class)->delete($usuario); 
        return $this->redirect($this->generateUrl('User'));
    }

    #[Route('/updateUser/{usuario}', name: 'updateUser')]
    public function update(EntityManagerInterface $gestor, Request $request, int $usuario): Response
    {
    $container = $request->request->all();
        if (count($container) > 1) {
             $gestor->getRepository(User::class)->updateUser($request, $usuario); 
            return $this->redirect($this->generateUrl("User"));
        } else {
            $clients = $gestor->getRepository(User::class)->find($usuario);
            return $this->render('User/AdminUpdatePanel.html.twig', [
                "clients" => $clients
            ]);
        }
    } 

  
    #[Route('/listEvent/{page?}', name: 'notices')]
    public function listNotices(?int $page, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $event = $entityManager->getRepository(Noticias::class);
        return $this->render('AdminNotices.html.twig', [
            'data' => $event->findAll(),
            "page" => $this->getLastPage($page, $session)
        ]);
    }

    #[Route('/listEvent/{page?}', name: 'files')]
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

