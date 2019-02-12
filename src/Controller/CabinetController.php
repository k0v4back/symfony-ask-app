<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserSettingsType;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
                'user' => $user,
                'path' => $this->getParameter('avatar_directory')
            ]
        );
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     * @Route("/{nick}/settings", name="profile_settings_form")
     */
    public function settings(User $user, Request $request, FileUploader $fileUploader)
    {
        $currentUserNick = $this->getUser()->getNick();
        if ($user->getNick() !== $currentUserNick) {
            return $this->redirectToRoute('profile_view');
        }

        $form = $this->createForm(UserSettingsType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $file */
            $file = $user->getAvatar();

            $fileName = $fileUploader->upload($file);

            $user->setAvatar($fileName);


            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('profile_view',
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