<?php

namespace App\EventSubscriber;

use App\Services\FlashMessages\FlashMessageHelperInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class AuthenticationSubscriber
{

    public function __construct(
        private FlashMessageHelperInterface $flashMessageHelper
    ){}


    /**
     * Flash message on login success
     */
    #[AsEventListener]
    public function onLoginSuccess(LoginSuccessEvent $event) {
        $this->flashMessageHelper->addSuccessFlash('Connexion réussie !');
    }

    /**
     * Flash message on login failure
     */
    #[AsEventListener]
    public function onLoginFailure(LoginFailureEvent $event) {
        $this->flashMessageHelper->addErrorFlash('Login et/ou mot de passe incorrect !');
    }

    /**
     * Flash message on logout
     */
    #[AsEventListener]
    public function onLogout(LogoutEvent $event) {
        $this->flashMessageHelper->addSuccessFlash('Déconnexion réussie !');
    }

}