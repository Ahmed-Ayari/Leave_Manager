<?php

namespace App\Controller\Admin;

use App\Entity\Emp;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/employees')]
class EmployeesController extends AbstractController
{
    #[Route('', name: 'app_admin_employees')]
    public function index(ManagerRegistry $manager): Response
    {
        $emps = $manager->getRepository(Emp::class)->findAll();
        
        foreach ($emps as $emp) {
            $emp->setempStartDateFormatted($emp->getEmpStartDate()->format('Y-m-d'));
        }

        return $this->render('admin/employees/index.html.twig', [
            'controller_name' => 'EmployeesController',
            'emps' => $emps,
        ]);
    }

    #[Route('/{id}', name: 'admin_employees_delete')]
    public function delete(Emp $emp, ManagerRegistry $manager): Response
    {
        $manager->getManager()->remove($emp);
        $manager->getManager()->flush();

        return $this->redirectToRoute('app_admin_employees');
    }
}
