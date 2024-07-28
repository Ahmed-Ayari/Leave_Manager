<?php

namespace App\Controller\Admin;

use App\Entity\Leave;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class WelcomeController extends AbstractController
{
    #[Route('/welcome', name: 'app_admin_welcome')]
    public function index(ManagerRegistry $manager): Response
    {
        $leaveRequests = $manager->getRepository(Leave::class)->findBy([
            'status' => 'pending',
        ]);

        return $this->render('admin/welcome/index.html.twig', [
            'leaveRequests' => $leaveRequests,
            'controller_name' => 'WelcomeController',
        ]);
    }
}
