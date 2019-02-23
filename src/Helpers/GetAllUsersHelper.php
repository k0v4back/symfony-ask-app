<?php

namespace App\Helpers;

use App\Repository\UserRepository;

class GetAllUsersHelper
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository = null)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll()
    {
        return [
            'Kosolapov Vadim' => 1,
            'Dlinoryck Andrey' => 2
        ];
    }
}