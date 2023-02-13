<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/api')]
class RegistrationController extends AbstractController
{
    
    #[Route('/insert/user', name:'insertUser_api', methods:["POST"])]
    public function insertUser(Request $request, UserRepository $repository): JsonResponse {

        $data = json_decode($request->getContent(), true);

        $repository->insert($data);
  
        return new JsonResponse(["status" => "User created!"], Response::HTTP_CREATED);
    }
}
