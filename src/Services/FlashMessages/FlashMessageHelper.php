<?php

namespace App\Services\FlashMessages;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class FlashMessageHelper implements FlashMessageHelperInterface
{

    public function __construct(
        private RequestStack $requestStack
    ){}

    /**
     * Flash messages from form errors
     */
    public function addFormErrorsAsFlash(FormInterface $form) : void
    {
        $errors = $form->getErrors(true);
        $flashBag = $this->requestStack->getSession()->getFlashBag();
        foreach ($errors as $error) {
            $errorMsg = $error->getMessage();
            $flashBag->add('error', $errorMsg);
        }
    }

    /**
     * Flash messages for success
     */
    public function addSuccessFlash(string $message) : void
    {
        $flashBag = $this->requestStack->getSession()->getFlashBag();
        $flashBag->add('success', $message);
    }

    /**
     * Flash messages for info
     */
    public function addInfoFlash(string $message): void
    {
        $flashBag = $this->requestStack->getSession()->getFlashBag();
        $flashBag->add('info', $message);
    }

    /**
     * Flash messages for error
     */
    public function addErrorFlash(string $message) : void
    {
        $flashBag = $this->requestStack->getSession()->getFlashBag();
        $flashBag->add('error', $message);
    }
}