<?php

namespace App\Controller\Manager;

use App\Entity\Leave;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/manager')]
class LeaveRequestsController extends AbstractController
{
    #[Route('/leave_requests', name: 'app_manager_leave_requests')]
    public function index(ManagerRegistry $manage): Response
    {
        $leaveRequests = $manage->getRepository(Leave::class)->findAll();

        foreach ($leaveRequests as $leaveRequest) {
            $leaveRequest->setStartDateFormatted($leaveRequest->getStartDate()->format('Y-m-d'));
            $leaveRequest->setEndDateFormatted($leaveRequest->getEndDate()->format('Y-m-d'));
        }

        return $this->render('manager/leave_requests/index.html.twig', [
            'controller_name' => 'LeaveRequestsController',
            'leaveRequests' => $leaveRequests,
        ]);
    }

    #[Route('/leave_requests/{id}/approve', name: 'manager_request_approve')]
    public function approve(Leave $leave, EntityManagerInterface $em): Response
    {
        $leave->setManagerResponse(true);
        $em->flush();

        $this->addFlash('success', 'Leave request approved!');

        return $this->redirectToRoute('app_manager_leave_requests');
    }

    #[Route('/leave_requests/{id}/reject', name: 'manager_request_reject')]
    public function reject(Leave $leave, EntityManagerInterface $em): Response
    {
        $leave->setManagerResponse(false);
        $em->flush();

        $this->addFlash('success', 'Leave request rejected!');

        return $this->redirectToRoute('app_manager_leave_requests');
    }
}
