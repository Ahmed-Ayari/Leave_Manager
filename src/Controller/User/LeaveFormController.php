<?php

namespace App\Controller\User;

use App\Entity\Leave;
use App\Form\User\LeaveFormType;
use App\Repository\LeaveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user')]
class LeaveFormController extends AbstractController
{
    #[Route('/leave_form', name: 'app_user_leave_form', methods: ['GET', 'POST'])]
    public function leaveForm(Request $request, EntityManagerInterface $entityManager, Security $security, LeaveRepository $leaveRepository): Response
    {
        $user = $security->getUser();
        $leave = new Leave();
        $leave->setEmp($user);

        $form = $this->createForm(LeaveFormType::class, $leave);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($leave);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_welcome');
        }

        // Fetch pending requests regardless of form submission
        $pendingRequests = $leaveRepository->findPendingRequestsByUser($user);

        return $this->render('user/leave_form/index.html.twig', [
            'form' => $form->createView(),
            'pendingRequests' => $pendingRequests,
        ]);
    }
}
