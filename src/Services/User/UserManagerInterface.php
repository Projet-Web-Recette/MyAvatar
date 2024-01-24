<?php

namespace App\Services\User;

use App\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UserManagerInterface {
    /**
     * Process all the logic for a new user (hashing password, saving profile picture, etc...)
     */
    public function processNewUser(User $user, ?string $plainPassword, ?UploadedFile $fileProfilePicture): void;

    /**
     * Edit a user's profile picture and process all the logic (deleting old profile picture, saving new one, etc...)
     * The User object does not work with UserInterface
     */
    public function processEditUserPP(User $user, ?UploadedFile $fileProfilePicture): void;

    /**
     * Edit a user's password and process all the logic (hashing new password, etc...)
     */
    public function processEditUserPassword(User $user, ?string $oldPassword, ?string $plainPassword): void;

    /**
     * Check if the old password is correct
     */
    public function checkOldPassword(User $user, ?string $oldPassword): bool;
}