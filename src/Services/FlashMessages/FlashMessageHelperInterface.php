<?php

namespace App\Services\FlashMessages;

use Symfony\Component\Form\FormInterface;

interface FlashMessageHelperInterface
{
    /**
     * Flash messages from form errors
     */
    public function addFormErrorsAsFlash(FormInterface $form): void;

    /**
     * Flash messages for success
     */
    public function addSuccessFlash(string $message): void;

    /**
     * Flash messages for info
     */
    public function addInfoFlash(string $message): void;

    /**
     * Flash messages for error
     */
    public function addErrorFlash(string $message): void;
}