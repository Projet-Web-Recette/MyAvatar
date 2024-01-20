<?php

namespace App\Controller;

use App\Services\App\AppManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function home(): Response
    {
        return $this->render("home.html.twig");
    }

    #[Route('/avatar', name: 'avatar', methods: ['GET'])]
    public function avatar(): Response
    {
        return $this->render("avatar.html.twig");
    }

    #[Route('/avatar/{filename}', name: 'avatar_get', methods: ['GET'])]
    public function avatarGet(string $filename, AppManagerInterface $manager): Response
    {
        return new BinaryFileResponse($manager->getAvatarPath($filename));
    }
}
