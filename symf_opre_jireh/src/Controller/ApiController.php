<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Event;
use App\Entity\Noticias;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ApiController extends AbstractController
{
    #[Route('/users/{id}', name: 'getUser_api', methods:["GET"])]
    public function getUsers(ManagerRegistry $doctrine, $id): JsonResponse
    {
        $getUser = $doctrine->getRepository(User::class)->find($id);
        $data = [
            "name" => $getUser->getName(),
            "surname" => $getUser->getSurnames(),
            "Email" => $getUser->getEmail(),
            "phone" => $getUser->getPhone()
        ];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/users', name: 'getAllUser_api', methods:["GET"])]
    public function getAllUsers(ManagerRegistry $doctrine): JsonResponse
    {
        $getUser = $doctrine->getRepository(User::class)->findAll();

        $data = [];

        foreach ($getUser as $response){
            $data[] = [
                "name" => $response->getName(),
                "surname" => $response->getSurnames(),
                "Email" => $response->getEmail(),
                "phone" => $response->getPhone()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/events/{id}', name:'getEvent_api', methods:["GET"])]
    public function getEvent(ManagerRegistry $doctrine, $id): JsonResponse
    {
        $getEvent = $doctrine->getRepository(Event::class)->find($id);

        $data = [
            "name" => $getEvent->getName(),
            "place" => $getEvent->getPlace(),
            "end_date" => $getEvent->getEndDate(),
            "start_date" => $getEvent->getStartDate(),
            "description" => $getEvent->getDescription()
        ];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/events', name:'getAllEvents_api', methods:["GET"])]
    public function getAllEvents(ManagerRegistry $doctrine): JsonResponse{
        $getAllEvents = $doctrine->getRepository(Event::class)->findAll();
        
        foreach ($getAllEvents as $getEvent){
            $data[] = [
                "name" => $getEvent->getName(),
                "place" => $getEvent->getPlace(),
                "end_date" => $getEvent->getEndDate(),
                "start_date" => $getEvent->getStartDate(),
                "description" => $getEvent->getDescription()
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/news/{id}', name:'getNews_api', methods:["GET"])]
    public function getNews(ManagerRegistry $doctrine, $id): JsonResponse
    {
        $getNews = $doctrine->getRepository(Noticias::class)->find($id);
        $data = [
            "Titulo" => $getNews->getTitulo(),
            "imagen" => $getNews->getImagen(),
            "texto" => $getNews->getTexto()
        ];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/news', name:'getAllNews_api', methods:["GET"])]
    public function getAllNews(ManagerRegistry $doctrine):JsonResponse{
        $getAllNews = $doctrine->getRepository(Noticias::class)->findAll();
        foreach ($getAllNews as $getNews){
            $data[] = [
                "Titulo" => $getNews->getTitulo(),
                "imagen" => $getNews->getImagen(),
                "texto" => $getNews->getTexto()
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }
}
