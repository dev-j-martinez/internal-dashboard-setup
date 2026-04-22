<?php

namespace App\Controller;

use App\Entity\Payslip;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class AdminPayrollController extends AbstractController
{
    #[Route('/admin/payroll/execute', name: 'app_admin_payroll_execute', methods: ['POST'])]
    public function executePayroll(UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $employees = $userRepository->findAll();
        $totalPaid = 0;
        $count = 0;

        foreach ($employees as $employee) {
            // Only pay employees with a salary and a recorded bank account
            if ($employee->getSalary() && $employee->getBankAccountNumber()) {
                $monthlyGross = (float)$employee->getSalary() / 12;
                $monthlyNet = $monthlyGross * 0.78; // Simulate 22% tax/deductions

                $payslip = new Payslip();
                $payslip->setEmployee($employee);
                $payslip->setGrossAmount(number_format($monthlyGross, 2, '.', ''));
                $payslip->setNetAmount(number_format($monthlyNet, 2, '.', ''));
                $payslip->setStatus('Transferred');
                
                $entityManager->persist($payslip);
                $totalPaid += $monthlyNet;
                $count++;
            }
        }

        $entityManager->flush();

        $this->addFlash('success', sprintf('Payroll executed. Transferred a total of $%s to %d active employee bank accounts.', number_format($totalPaid, 2), $count));
        
        return $this->redirectToRoute('app_dashboard');
    }
}
