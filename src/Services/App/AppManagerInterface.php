<?php

namespace App\Services\App;

interface AppManagerInterface
{

    /**
     * Get the avatar of a user by his filename
     */
    public function getAvatarPath(string $filename): string;

}