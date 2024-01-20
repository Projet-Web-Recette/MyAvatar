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


    #[AsEventListener]
    public function onLoginSuccess(LoginSuccessEvent $event) {
        $this->flashMessageHelper->addSuccessFlash('Connexion réussie !');
    }

    #[AsEventListener]
    public function onLoginFailure(LoginFailureEvent $event) {
        $this->flashMessageHelper->addErrorFlash('Login et/ou mot de passe incorrect !');
    }

    #[AsEventListener]
    public function onLogout(LogoutEvent $event) {
        $this->flashMessageHelper->addSuccessFlash('Déconnexion réussie !');
    }

}