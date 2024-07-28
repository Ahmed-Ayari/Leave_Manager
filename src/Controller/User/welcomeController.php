<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user')]
class welcomeController extends AbstractController
{
    #[Route('/welcome', name: 'app_user_welcome')]
    public function index(): Response
    {
        return $this->render('user/welcome/index.html.twig', [
            'controller_name' => 'welcomeController',
        ]);
    }
}
