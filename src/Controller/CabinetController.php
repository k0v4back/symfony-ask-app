<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Questions;
use App\Entity\User;
use App\Form\QuestionFormType;
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
    public function userProfile(User $user, Request $request)
    {
        $questions = new Questions();
        $form = $this->createForm(QuestionFormType::class, $questions);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $questions->setWhoAsked($this->getUser()->getId());
            $questions->setToAsked($user->getId());
            $questions->setTime(time());
            $questions->setStatus(Questions::NOT_ANSWERED);
            $questions->setAnon($form->get('anon')->getData());

            $em = $this->getDoctrine()->getManager();
            $em->persist($questions);
            $em->flush();
        }

        $em = $this->getDoctrine()->getManager();

        $questions = $em->getRepository(Questions::class)->findAllStatusNotAnswered($user);

//        var_dump($questions);die();

        $answers = array();

        foreach ($questions as $question) {
            $answer = $em->getRepository(Answer::class)->findByQuestionId($question['id']);
            $answers[] = array_merge($answer, $question);


        }

        $result = [$answers];

//        var_dump($result);die();

//        var_dump($answers);die();
//        var_dump($questions);die();

        return $this->render(
            'profile/user-profile.html.twig',
            [
                'user' => $user,
                'path' => $this->getParameter('avatar_directory'),
                'form_question' => $form->createView(),
                'questions' => $questions,
                'answers' => $answers,
                'result' => $result
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