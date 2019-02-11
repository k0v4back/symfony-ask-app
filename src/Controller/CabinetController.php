<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CabinetController extends AbstractController
{
    /**
     * @Route("/profile/{nick}", name="profile_view")
     */
    public function userProfile(User $user)
    {
        return $this->render(
            'profile/user-profile.html.twig',
            [
                'user' => $user
            ]
        );
    }
}