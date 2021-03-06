<?php

namespace App\Controller;

use App\Entity\User;
use App\Event\UserRegisterEvent;
use App\Form\UserType;
use App\Security\TokenGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="user_register")
     */
    public function register(
        UserPasswordEncoderInterface $userPasswordEncoder,
        Request $request,
        EventDispatcherInterface $eventDispatcher,
        TokenGenerator $tokenGenerator
    )
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $userPasswordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setConfirmToken($tokenGenerator->getRandomSecureToken(50));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $userRegisterEvent = new UserRegisterEvent($user);
            $eventDispatcher->dispatch(
                UserRegisterEvent::NAME,
                $userRegisterEvent
            );

            return $this->redirectToRoute('news_feed');
        }

        return $this->render('register/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {
    }
}