<?php

namespace App\Controller\User;

use App\Entity\Leave;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MyLeaveRequestsController extends AbstractController
{
    #[Route('/user/my_leave_request', name: 'app_user_my_leave_request')]
    public function index(): Response
    {
        return $this->render('user/my_leave_requests/index.html.twig', [
            'controller_name' => 'MyLeaveRequestsController',
        ]);
    }

    #[Route('/user/my_leave_requests', name: 'app_user_my_leave_requests')]
    public function list(ManagerRegistry $doctrine, Security $security): Response
    {
        $user = $security->getUser();

        $leaveRequests = $doctrine->getRepository(Leave::class)->findBy([
            'emp' => $user,
        ]);

        foreach ($leaveRequests as $leaveRequest) {
            $leaveRequest->setStartDateFormatted($leaveRequest->getStartDate()->format('Y-m-d'));
            $leaveRequest->setEndDateFormatted($leaveRequest->getEndDate()->format('Y-m-d'));
        }

        return $this->render('user/my_leave_requests/index.html.twig', [
            'leaveRequests' => $leaveRequests,
        ]);
    }
}
