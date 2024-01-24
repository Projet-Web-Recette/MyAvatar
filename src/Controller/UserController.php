<?php

namespace App\Controller;

use App\Form\EditPasswordType;
use App\Form\EditPPType;
use App\Services\FlashMessages\FlashMessageHelperInterface;
use App\Services\User\UserManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * Route to display the profile of the user (need authentication)
     */
    #[Route('/profile', name: 'profile', methods: ['GET'])]
    public function profile(FlashMessageHelperInterface $flashMessageHelper): Response
    {
        if(!$this->isGranted('ROLE_USER')) {
            $flashMessageHelper->addErrorFlash('Vous devez être connecté pour accéder à cette page !');
            return $this->redirectToRoute('home');
        }
        return $this->render("user/profile.html.twig");
    }


    /**
     * Route to edit the profile picture of the user (need authentication)
     */
    #[Route('/profile/edit_pp', name: 'edit_pp', methods: ['GET', 'POST'])]
    public function profileEditPP(Request $request,
                                  EntityManagerInterface $entityManager,
                                  UserManagerInterface $manager,
                                  FlashMessageHelperInterface $flashMessageHelper): Response
    {
        if(!$this->isGranted('ROLE_USER')) {
            $flashMessageHelper->addErrorFlash('Vous devez être connecté pour accéder à cette page !');
            return $this->redirectToRoute('home');
        }

        $user = $this->getUser();
        $form = $this->createForm(
            EditPPType::class,
            $user,
            ['method' => 'POST', 'action' => $this->generateUrl('edit_pp')]
        );

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $profilePicture = $form->get('fileProfilePicture')->getData();
            $manager->processEditUserPP($user, $profilePicture);

            $entityManager->persist($user);
            $entityManager->flush();

            $flashMessageHelper->addSuccessFlash('Votre photo de profil a bien été modifiée !');
            return $this->redirectToRoute('profile');
        } else if ($form->isSubmitted()) {
            $flashMessageHelper->addErrorFlash('Une erreur est survenue lors de la modification de votre photo de profil !');
        }

        return $this->render("user/changepp.html.twig", ['form' => $form]);
    }


    /**
     * Route to edit the password of the user (need authentication)
     */
    #[Route('/profile/edit_password', name: 'edit_password', methods: ['GET', 'POST'])]
    public function profileEditPassword(Request $request,
                                        EntityManagerInterface $entityManager,
                                        UserManagerInterface $manager,
                                        FlashMessageHelperInterface $flashMessageHelper): Response
    {
        if(!$this->isGranted('ROLE_USER')) {
            $flashMessageHelper->addErrorFlash('Vous devez être connecté pour accéder à cette page !');
            return $this->redirectToRoute('home');
        }

        $user = $this->getUser();
        $form = $this->createForm(
            EditPasswordType::class,
            $user,
            ['method' => 'POST', 'action' => $this->generateUrl('edit_password')]
        );

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $form->get('oldPassword')->getData();
            $plainPassword = $form->get('plainPassword')->getData();

            if($oldPassword === $plainPassword) {
                $flashMessageHelper->addErrorFlash('Les deux mots de passe sont identiques !');
                return $this->redirectToRoute('edit_password');
            }
            if(!$manager->checkOldPassword($user, $oldPassword)) {
                $flashMessageHelper->addErrorFlash('Votre ancien mot de passe est incorrect !');
                return $this->redirectToRoute('edit_password');
            }

            $manager->processEditUserPassword($user, $oldPassword, $plainPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            $flashMessageHelper->addSuccessFlash('Votre mot de passe a bien été modifié !');
            return $this->redirectToRoute('profile');
        } else if ($form->isSubmitted()) {
            $flashMessageHelper->addErrorFlash('Une erreur est survenue lors de la modification de votre mot de passe !');
        }

        return $this->render("user/changepassword.html.twig", ['form' => $form]);
    }
}
