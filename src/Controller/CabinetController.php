<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserSettingsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile")
 */
class CabinetController extends AbstractController
{
    /**
     * @Route("/{nick}", name="profile_view")
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

    /**
     * @Security("is_granted('ROLE_USER')")
     * @Route("/{nick}/settings", name="profile_settings_form")
     */
    public function settings(User $user, Request $request)
    {
        $currentUserNick = $this->getUser()->getNick();
        if ($user->getNick() !== $currentUserNick) {
            return $this->redirectToRoute('profile_view');
        }

        $form = $this->createForm(UserSettingsType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('profile_settings_form',
                array(
                    'nick' => $user->getNick()
                )
            );
        }

        return $this->render(
            'profile/user-settings.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}