<?php

namespace App\Services\App;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

class AppManager implements AppManagerInterface
{

    public function __construct(
        #[Autowire('%folder_profile_pictures%')] private readonly string $folderProfilePictures
    )
    {}

    public function getAvatarPath(string $filename): string
    {
        $path = $this->folderProfilePictures . '/' . $filename . '.png';
        if(!file_exists($path)) {
            $path = $this->folderProfilePictures . '/' . $filename . '.jpeg';
            if(!file_exists($path)) {
                $path = $this->folderProfilePictures . '/../../img/defaultuser.jpg';
            }
        }
        return $path;
    }
}