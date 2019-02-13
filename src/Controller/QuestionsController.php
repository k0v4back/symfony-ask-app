<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Questions;
use App\Entity\User;
use App\Form\AnswerType;
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
    public function showMyQuestions(User $user, Request $request)
    {
        if ($user->getId() == $this->getUser()->getId()) {

            $em = $this->getDoctrine()->getManager();
            $answer = $em->getRepository(Questions::class)->findAllByForOwner($user);

            return $this->render('questions/main-page.html.twig', [
                'questions' => $answer,
                'user' => $user
            ]);
        }
        return $this->redirectToRoute('news_feed');

    }

    /**
     * @Route("/show/{id}", name="question_show_by_id")
     */
    public function showOneQuestion(Questions $question, Request $request)
    {
        $answer = new Answer();

        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(Questions::class)->find($question->getId());
            $question = $em->getRepository(Questions::class)->find($question->getId());

            $question->setStatus(Questions::ANSWERED);

            $answer->setUserId($user->getToAsked());
            $answer->setToUserId($question->getWhoAsked());
            $answer->setQuestionId($question->getId());
            $answer->setTime(time());

            $question->setStatus(Questions::ANSWERED);
            $em->flush();

            return $this->redirectToRoute('questions_get_all',
                array(
                    'nick' => $this->getUser()->getNick()
                )
            );

        }

        return $this->render('questions/one-question.html.twig',
            [
                'question' => $question,
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/{nick}/answered", name="questions_get_answered")
     */
    public function showNotAnsweredQuestions(User $user, Request $request)
    {
        if ($user->getId() == $this->getUser()->getId()) {
            $em = $this->getDoctrine()->getManager();
            $answer = $em->getRepository(Questions::class)->findAllStatusAnswered($user);

            return $this->render('questions/main-page.html.twig', [
                'questions' => $answer,
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
            $answer = $em->getRepository(Questions::class)->findAllStatusNotAnswered($user);

            return $this->render('questions/main-page.html.twig', [
                'questions' => $answer,
                'user' => $user
            ]);
        }
        return $this->redirectToRoute('news_feed');
    }
}