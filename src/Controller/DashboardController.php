<?php

namespace App\Controller;

use App\Repository\AnnouncementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(AnnouncementRepository $announcementRepository): Response
    {
        $announcements = $announcementRepository->findBy([], ['createdAt' => 'DESC'], 5);

        return $this->render('dashboard/index.html.twig', [
            'announcements' => $announcements,
        ]);
    }
}
