<?php

namespace App\Controller;

use App\Entity\Announcement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class AnnouncementController extends AbstractController
{
    #[Route('/admin/announcement/new', name: 'app_announcement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $title = $request->request->get('title');
            $content = $request->request->get('content');

            if ($title && $content) {
                $announcement = new Announcement();
                $announcement->setTitle($title);
                $announcement->setContent($content);
                // The current user must be User entity
                /** @var \App\Entity\User $user */
                $user = $this->getUser();
                $announcement->setAuthor($user);
                
                $entityManager->persist($announcement);
                $entityManager->flush();

                $this->addFlash('success', 'Announcement published.');
                return $this->redirectToRoute('app_dashboard');
            }
        }

        return $this->render('announcement/new.html.twig');
    }
}
