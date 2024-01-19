<?php

namespace App\Services\FlashMessages;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class FlashMessageHelper implements FlashMessageHelperInterface
{

    public function __construct(
        private RequestStack $requestStack
    ){}

    public function addFormErrorsAsFlash(FormInterface $form) : void
    {
        $errors = $form->getErrors(true);
        //Ajouts des erreurs du formulaire comme messages flash de la catégorie "error".
        $flashBag = $this->requestStack->getSession()->getFlashBag();
        foreach ($errors as $error) {
            $errorMsg = $error->getMessage();
            $flashBag->add('error', $errorMsg);
        }
    }

    public function addSuccessFlash(string $message) : void
    {
        $flashBag = $this->requestStack->getSession()->getFlashBag();
        $flashBag->add('success', $message);
    }

    public function addInfoFlash(string $message): void
    {
        $flashBag = $this->requestStack->getSession()->getFlashBag();
        $flashBag->add('info', $message);
    }

    public function addErrorFlash(string $message) : void
    {
        $flashBag = $this->requestStack->getSession()->getFlashBag();
        $flashBag->add('error', $message);
    }
}