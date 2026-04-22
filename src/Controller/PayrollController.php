<?php

namespace App\Controller;

use App\Repository\PayslipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class PayrollController extends AbstractController
{
    #[Route('/payroll', name: 'app_payroll')]
    public function index(PayslipRepository $payslipRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        // Fetch real database records instead of simulated ones
        $payslips = $payslipRepository->findBy(['employee' => $user], ['paymentDate' => 'DESC']);

        return $this->render('payroll/index.html.twig', [
            'user' => $user,
            'payslips' => $payslips,
        ]);
    }
}
