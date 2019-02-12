<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Security("is_granted('ROLE_USER')")
 */
class FollowingController extends AbstractController
{
    /**
     * @Route("/follow/{id}", name="following_follow")
     */
    public function follow(User $userToFollow)
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if ($userToFollow->getId() !== $currentUser->getId()) {
            $currentUser->getFollowing()->add($userToFollow);
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->redirectToRoute('profile_view', ['nick' => $userToFollow->getNick()]);
    }

    /**
     * @Route("/unfollow/{id}", name="follow_unfollow")
     */
    public function unFollow(User $userToUnFollow)
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        $currentUser->getFollowing()->removeElement($userToUnFollow);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('profile_view', ['nick' => $userToUnFollow->getNick()]);
    }
}