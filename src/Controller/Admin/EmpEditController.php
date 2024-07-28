<?php

namespace App\Controller\Admin;

use App\Entity\Emp;
use App\Form\Admin\EmpEditType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/employees')]
class EmpEditController extends AbstractController
{
    #[Route('/edit/{id}', name: 'admin_employees_edit', methods: ['GET', 'POST'])]
    public function edit(Emp $emp, ManagerRegistry $manager, Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        $emp = $em->getRepository(Emp::class)->find($emp->getId());

        $form = $this->createForm(EmpEditType::class, $emp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('password')->getData();
            $hashedPassword = $hasher->hashPassword($emp, $plainPassword);
            $emp->setPassword($hashedPassword);
            
            $manager->getManager()->flush();

            return $this->redirectToRoute('app_admin_employees');
        }

        return $this->render('admin/emp_edit/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
