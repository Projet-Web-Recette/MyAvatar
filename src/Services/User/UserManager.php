<?php

namespace App\Services\User;

use App\Entity\User;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserManager implements UserManagerInterface
{

    public function __construct(
        #[Autowire('%folder_profile_pictures%')] private readonly string $folderProfilePictures,
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {}

    public function processNewUser(User $user, ?string $plainPassword, ?UploadedFile $fileProfilePicture): void
    {
        $this->hashPassword($user, $plainPassword);
        $this->saveProfilePicture($user, $fileProfilePicture);
    }

    public function processEditUserPP(User $user, ?UploadedFile $fileProfilePicture): void
    {
        $this->saveProfilePicture($user, $fileProfilePicture);
    }

    public function processEditUserPassword(User $user, ?string $oldPassword, ?string $plainPassword): void
    {
        $this->hashPassword($user, $plainPassword);
    }

    public function checkOldPassword(User $user, ?string $oldPassword): bool
    {
        return $this->passwordHasher->isPasswordValid($user, $oldPassword);
    }



    /**
     * Hash the password of the user
     */
    private function hashPassword(User $user, ?string $plainPassword) : void {
        $hash = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hash);
    }

    /**
     * Save the profile picture of the user (the name of the file is the md5 of the email of the user)
     */
    private function saveProfilePicture(?User $user, ?UploadedFile $fileProfilePicture) : void {
        if($fileProfilePicture != null) {
            if($user->getProfilePicture() != null) {
                unlink($this->folderProfilePictures . '/' . $user->getProfilePicture());
            }
            $fileName = md5($user->getEmail()) . '.' . $fileProfilePicture->guessExtension();
            $fileProfilePicture->move($this->folderProfilePictures, $fileName);
            $user->setProfilePicture($fileName);
        }
    }
}