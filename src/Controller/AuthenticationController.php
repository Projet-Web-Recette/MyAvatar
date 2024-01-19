<?php

namespace App\Controller;

use App\Services\FlashMessages\FlashMessageHelperInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthenticationController extends AbstractController
{
    #[Route('/login', name: 'login', methods: ['GET'])]
    public function login(FlashMessageHelperInterface $flashMessageHelper): Response
    {
        return $this->render("authentication/login.html.twig");
    }

    #[Route('/register', name: 'register', methods: ['GET'])]
    public function register(FlashMessageHelperInterface $flashMessageHelper): Response
    {
        return $this->render("authentication/register.html.twig");
    }
}
