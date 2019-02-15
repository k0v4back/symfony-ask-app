<?php

namespace App\Controller;

use Predis\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
    /**
     * @Route("/like/{id}/{nick}", name="like_question")
     */
    public function like($id, $nick)
    {
        $redis = new Client();

        $redis->sadd("question:{$id}:like", $nick);

        return $this->redirectToRoute('profile_view',
            array(
                'nick' => $nick
            )
        );
    }

    /**
     * @Route("/unlike/{id}/{nick}", name="unlike_question")
     */
    public function unlike($id, $nick)
    {
        $redis = new Client();

        $redis->sadd("question:{$id}:unlike", $nick);

        return $this->redirectToRoute('profile_view',
            array(
                'nick' => $nick
            )
        );
    }
}