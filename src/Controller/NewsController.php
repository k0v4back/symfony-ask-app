<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function index()
    {
        return $this->render(
            'news/news.html.twig'
        );
    }


    /**
     * @Route("/search", name="search_by_nick")
     */
    public function search(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userBySearch = $em->getRepository(User::class)->findUserByNick($request->request->get('search'));

        $data = array();

        foreach ($userBySearch as $item){
            $data[] = [
                'nick' => $item->getNick()
            ];
        }
        return new JsonResponse($data);
    }
}