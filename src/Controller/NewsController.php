<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SearchUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/news")
 */
class NewsController extends AbstractController
{
    /**
     * @Route("/", name="news_feed")
     */
    public function index(Request $request)
    {
        $user = new User();

        $form = $this->createForm(SearchUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            var_dump($form->getData()->getNick());
            die();
        }

        return $this->render(
            'news/news.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}