<?php

namespace App\Controller\Admin;

use App\Entity\Leave;
use App\Enum\LeaveStatus;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/leave_requests')]
class LeaveRequestsController extends AbstractController
{
    #[Route('', name: 'app_admin_leave_requests')]
    public function index(ManagerRegistry $manager): Response
    {
        $leaveRequests = $manager->getRepository(Leave::class)->findAll();

        foreach ($leaveRequests as $leaveRequest) {
            $leaveRequest->setStartDateFormatted($leaveRequest->getStartDate()->format('Y-m-d'));
            $leaveRequest->setEndDateFormatted($leaveRequest->getEndDate()->format('Y-m-d'));
        }

        return $this->render('admin/leave_requests/index.html.twig', [
            'controller_name' => 'LeaveRequestsController',
            'leaveRequests' => $leaveRequests,
        ]);
    }

    #[Route('/{id}/approve', name: 'admin_request_approve')]
    public function approve(Leave $leave, EntityManagerInterface $em): Response
    {   
        $leave->setStatus(LeaveStatus::Approved);
        $em->flush();

        $this->addFlash('success', 'Leave request approved!');

        $startDate = $leave->getStartDate();
        $endDate = $leave->getEndDate();
        
        // Calculate the difference in days
        $leaveDays = $startDate->diff($endDate)->days; 
        $emp = $leave->getEmp();
    
        $emp->setLeaveBalance($emp->getLeaveBalance() - $leaveDays);
        $em->flush();
        
        return $this->redirectToRoute('app_admin_leave_requests');
    }

    #[Route('/{id}/reject', name: 'admin_request_reject')]
    public function reject(Leave $leave, EntityManagerInterface $em, Request $request): Response
    {
        $leave = $em->getRepository(Leave::class)->find($leave->getId());
        $denyReason = $request->request->get('denyReason'); 

        $leave->setStatus(LeaveStatus::Rejected);
        $leave->setDenyReason($denyReason);
        $em->flush();

        $this->addFlash('success', 'Leave request rejected!');

        return $this->redirectToRoute('app_admin_leave_requests');
    }
}
