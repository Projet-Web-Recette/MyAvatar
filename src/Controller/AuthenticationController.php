<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Services\FlashMessages\FlashMessageHelperInterface;
use App\Services\User\UserManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthenticationController extends AbstractController
{
    /**
     * Route to login
     */
    #[Route('/login', name: 'login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $utils,
                          FlashMessageHelperInterface $flashMessageHelper): Response
    {
        if($this->isGranted('ROLE_USER')) {
            $flashMessageHelper->addInfoFlash('Vous êtes déjà connecté !');
            return $this->redirectToRoute('home');
        }

        $lastLogin = $utils->getLastUsername();
        return $this->render("authentication/login.html.twig", ['last_login' => $lastLogin]);
    }


    /**
     * Route to logout
     */
    #[Route('/logout', name: 'logout', methods: ['GET'])]
    public function logout(): never {
        throw new \Exception("Cette route n'est pas censée être appelée. Vérifiez security.yaml");
    }


    /**
     * Route to register
     */
    #[Route('/register', name: 'register', methods: ['GET', 'POST'])]
    public function register(Request $request,
                             EntityManagerInterface $entityManager,
                             UserManagerInterface $manager,
                             FlashMessageHelperInterface $flashMessageHelper): Response
    {
        if($this->isGranted('ROLE_USER')) {
            $flashMessageHelper->addInfoFlash('Vous êtes déjà inscrit !');
            return $this->redirectToRoute('home');
        }

        $user = new User();

        $form = $this->createForm(
            UserType::class,
            $user,
            ['method' => 'POST', 'action' => $this->generateUrl('register')]
        );

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('plainPassword')->getData();
            $fileProfilePicture = $form->get('fileProfilePicture')->getData();

            $manager->processNewUser($user, $password, $fileProfilePicture);

            $entityManager->persist($user);
            $entityManager->flush();

            $flashMessageHelper->addSuccessFlash('Inscription réussie !');

            return $this->redirectToRoute('home');
        } else if ($form->isSubmitted()) {
            $flashMessageHelper->addFormErrorsAsFlash($form);
        }

        return $this->render("authentication/register.html.twig", ['form' => $form]);
    }
}
