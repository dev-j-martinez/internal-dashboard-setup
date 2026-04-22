<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class DirectoryController extends AbstractController
{
    #[Route('/directory', name: 'app_directory')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findBy([], ['name' => 'ASC']);

        return $this->render('directory/index.html.twig', [
            'users' => $users,
        ]);
    }
}
