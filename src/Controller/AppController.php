<?php

namespace App\Controller;

use App\Form\AvatarType;
use App\Repository\UserRepository;
use App\Services\App\AppManagerInterface;
use App\Services\FlashMessages\FlashMessageHelperInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * Base route of the application
     */
    #[Route('/', name: 'home', methods: ['GET'])]
    public function home(): Response
    {
        return $this->render("home.html.twig");
    }


    /**
     * Route to search an avatar with an email
     */
    #[Route('/avatar', name: 'avatar', methods: ['GET', 'POST'])]
    public function avatar(Request $request,
                           UserRepository $repository,
                           FlashMessageHelperInterface $flashMessageHelper): Response
    {
        $form = $this->createForm(
            AvatarType::class,
            null,
            ['method' => 'POST', 'action' => $this->generateUrl('avatar')]
        );

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $emailHash = md5($email);

            $user = $repository->findOneBy(['email' => $email]);

            if(!$user) {
                $flashMessageHelper->addErrorFlash('Cet utilisateur n\'existe pas !');
                return $this->redirectToRoute('avatar');
            }

            return $this->redirectToRoute('avatar_get', ['filename' => $emailHash]);
        } else if ($form->isSubmitted()) {
            $flashMessageHelper->addErrorFlash('Une erreur est survenue !');
        }

        return $this->render("avatar.html.twig", ['form' => $form]);
    }


    /**
     * Route to get an avatar as image response (with email)
     */
    #[Route('/avatar/{filename}', name: 'avatar_get', methods: ['GET'])]
    public function avatarGet(string $filename, AppManagerInterface $manager): Response
    {
        return new BinaryFileResponse($manager->getAvatarPath($filename));
    }
}
