<?php

namespace App\Controller\Admin;

use App\Entity\Emp;
use App\Form\Admin\EmpAddType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/emp_add')]
class EmpAddController extends AbstractController
{
    #[Route('', name: 'app_admin_emp_add' , methods: ['GET', 'POST'])]
    public function index(EntityManagerInterface $em, Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $emp = new Emp();

        $form = $this->createForm(EmpAddType::class, $emp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('password')->getData();
            $hashedPassword = $hasher->hashPassword($emp, $plainPassword);
            $emp->setPassword($hashedPassword);

            $em->persist($emp);
            $em->flush();

            return $this->redirectToRoute('app_admin_employees');
        }

        return $this->render('admin/emp_add/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
