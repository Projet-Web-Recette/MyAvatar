<?php

namespace App\Services\FlashMessages;

use Symfony\Component\Form\FormInterface;

interface FlashMessageHelperInterface
{
    public function addFormErrorsAsFlash(FormInterface $form): void;
    public function addSuccessFlash(string $message): void;
    public function addInfoFlash(string $message): void;
    public function addErrorFlash(string $message): void;
}