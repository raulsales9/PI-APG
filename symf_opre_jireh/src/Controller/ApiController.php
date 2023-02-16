<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Event;
use App\Entity\Noticias;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/api')]
class ApiController extends AbstractController
{
    #[Route('/users/{id}', name: 'getUser_api', methods: ["GET"])]
    public function getUsers(ManagerRegistry $doctrine, $id): JsonResponse
    {
        $getUser = $doctrine->getRepository(User::class)->find($id);

        $data = [
            "name" => $getUser->getName(),
            "surname" => $getUser->getSurnames(),
            "Email" => $getUser->getEmail(),
            "phone" => $getUser->getPhone(),
            "events" => []
        ];

        for ($i = 0; $i < count($getUser->getEvents()); $i++) {
            $data["events"][$i] = "localhost:8000/api/events/" . $getUser->getEvents()[$i]->getId();
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/users', name: 'getAllUser_api', methods: ["GET"])]
    public function getAllUsers(ManagerRegistry $doctrine): JsonResponse
    {
        $getUser = $doctrine->getRepository(User::class)->findAll();

        $data = [];

        foreach ($getUser as $response) {
            $data[] = [
                "name" => $response->getName(),
                "surname" => $response->getSurnames(),
                "Email" => $response->getEmail(),
                "phone" => $response->getPhone()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/events/{id}', name: 'getEvent_api', methods: ["GET"])]
    public function getEvent(ManagerRegistry $doctrine, $id): JsonResponse
    {
        $getEvent = $doctrine->getRepository(Event::class)->find($id);

        $data = [
            "name" => $getEvent->getName(),
            "place" => $getEvent->getPlace(),
            "end_date" => $getEvent->getEndDate(),
            "start_date" => $getEvent->getStartDate(),
            "description" => $getEvent->getDescription(),
            "Users" => $getEvent->getIdUser()
        ];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/events', name: 'getAllEvents_api', methods: ["GET"])]
    public function getAllEvents(ManagerRegistry $doctrine): JsonResponse
    {
        $getAllEvents = $doctrine->getRepository(Event::class)->findAll();

        foreach ($getAllEvents as $getEvent) {
            $data[] = [
                "name" => $getEvent->getName(),
                "place" => $getEvent->getPlace(),
                "end_date" => $getEvent->getEndDate(),
                "start_date" => $getEvent->getStartDate(),
                "description" => $getEvent->getDescription(),
                "imagen" => $getEvent->getImagen(),
                "id" => $getEvent->getId()
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/news/{id}', name: 'getNews_api', methods: ["GET"])]
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

    #[Route('/news', name: 'getAllNews_api', methods: ["GET"])]
    public function getAllNews(ManagerRegistry $doctrine): JsonResponse
    {
        $getAllNews = $doctrine->getRepository(Noticias::class)->findAll();
        foreach ($getAllNews as $getNews) {
            $data[] = [
                "Titulo" => $getNews->getTitulo(),
                "imagen" => $getNews->getImagen(),
                "texto" => $getNews->getTexto()
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/login', name: 'login_api', methods: ["POST"])]
    public function login(ManagerRegistry $doctrine, Request $request, UserRepository $repository, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {

        $json = json_decode($request->getContent(), true);
        $user = $doctrine->getRepository(User::class)->findBy(["email" => $json["email"]])[0];

        if ($user !== null) {
            $password = $json["password"];
            if ($passwordHasher->isPasswordValid($user, $password)) {
                $data = [
                    "email" => $user->getEmail(),
                    "user" => $user->getName(),
                    "rol" => ($user->getRoles() === ["USER"]) ? "USER" : "ADMIN"
                ];
            } else {
                $data = "";
            }
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/update/users/{id}', name: 'updateUser_api', methods: ["PUT"])]
    public function updateUser(ManagerRegistry $doctrine, UserRepository $repository, Request $request, $id): JsonResponse
    {

        $getUser = $doctrine->getRepository(User::class)->find($id);

        $json = json_decode($request->getContent(), true);

        empty($json["name"]) ? true : $getUser->setName($json["name"]);
        empty($json["email"]) ? true : $getUser->setEmail($json["email"]);
        empty($json["phone"]) ? true : $getUser->setPhone($json["phone"]);
        empty($json["surname"]) ? true : $getUser->setSurnames($json["surname"]);

        $repository->update($getUser);

        return new JsonResponse(["status" => "User updated!"], Response::HTTP_OK);
    }

    #[Route('/update/event/{id}/{idUser}', name: 'updateEvent_api', methods: ["PUT"])]
    public function updateEvent(int $id, int $idUser, EventRepository $repository, ManagerRegistry $doctrine, UserRepository $userRepository): JsonResponse
    {

        $getUser = $doctrine->getRepository(User::class)->findBy(["id" => $idUser]);
        $getEvent = $doctrine->getRepository(Event::class)->findBy(["id" => $id]);
        $userRepository->updateAssistant($getEvent, $getUser);
        return new JsonResponse(["status" => "Event updated!"], Response::HTTP_OK);
    }

    /*    FUNCIÓN A IMPLEMENTAR EN EL FUTURO
    
    #[Route('/email', name: 'email_api', methods: ["POST"])]
    public function email(Request $request): JsonResponse
    {

        $json = json_decode($request->getContent(), true);

        $nombre = $json["nombre"];
        $apellidos = $json["apellidos"];
        $email = $json["email"];
        $ciudad = $json["ciudad"];
        $telefono = $json["telefono"];
        $asunto = $json["asunto"] ?? 'Sin asunto';
        $mensaje = "<strong> Nombre: </strong> " . $nombre . "  <strong> Apellidos: </strong> " . $apellidos . "<br> <strong> Email: </strong> $email <br> <strong> Ciudad: </strong> $ciudad <br> <strong> telefono: </strong> $telefono <br> <strong>Mensaje: </strong>" . $json["mensaje"];

        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

        if (mail('nllanescastell@gmail.com', $asunto, $mensaje, implode("\r\n", $headers))) {
            return new JsonResponse(["status" => "Email sent!"], Response::HTTP_OK);
        } else {
            return new JsonResponse(["status" => "Email not sent!"], Response::HTTP_OK);
        }
    } */
}
