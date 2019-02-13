<?php

namespace App\Controller;

use App\Entity\Questions;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Security("is_granted('ROLE_USER')")
 * @Route("/questions")
 */
class QuestionsController extends AbstractController
{
    /**
     * @Route("/{nick}", name="questions_get_all")
     */
    public function showMyQuestions(User $user)
    {
        if ($user->getId() == $this->getUser()->getId()) {
            $em = $this->getDoctrine()->getManager();
            $questions = $em->getRepository(Questions::class)->findAllByForOwner($user);

            return $this->render('questions/main-page.html.twig', [
                'questions' => $questions,
                'user' => $user
            ]);
        }
        return $this->redirectToRoute('news_feed');

    }

    /**
     * @Route("/{nick}/answered", name="questions_get_answered")
     */
    public function showNotAnsweredQuestions(User $user, Request $request)
    {
        if ($user->getId() == $this->getUser()->getId()) {
            $em = $this->getDoctrine()->getManager();
            $questions = $em->getRepository(Questions::class)->findAllStatusAnswered($user);

            return $this->render('questions/main-page.html.twig', [
                'questions' => $questions,
                'user' => $user
            ]);
        }
        return $this->redirectToRoute('news_feed');
    }

    /**
     * @Route("/{nick}/not-answered", name="questions_get_not_answered")
     */
    public function showAnsweredQuestions(User $user, Request $request)
    {
        if ($user->getId() == $this->getUser()->getId()) {
            $em = $this->getDoctrine()->getManager();
            $questions = $em->getRepository(Questions::class)->findAllStatusNotAnswered($user);

            return $this->render('questions/main-page.html.twig', [
                'questions' => $questions,
                'user' => $user
            ]);
        }
        return $this->redirectToRoute('news_feed');
    }
}