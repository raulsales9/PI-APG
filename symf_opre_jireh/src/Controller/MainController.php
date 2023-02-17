<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if(!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')){
            return $this->redirectToRoute('app_login');
        }
        return $this->render('main.html.twig', [
          
        ]);
    }
}
