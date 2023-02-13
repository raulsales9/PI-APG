<?php

namespace App\Controller;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ApiController extends AbstractController
{
    #[Route('/users/{id}', name: 'getUser_api')]
    public function index(ManagerRegistry $doctrine, $id): JsonResponse
    {
        $getUser = $doctrine->getRepository(User::class)->find($id);
        $data = [
            "name" => $getUser->getName(),
            "surname" => $getUser->getSurname(),
            "Email" => $getUser->getEmail(),
            "phone" => $getUser->getPhone()
        ];
        return new JsonResponse($data, Response::HTTP_OK);
    }
}
