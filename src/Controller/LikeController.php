<?php

namespace App\Controller;

use Predis\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
    /**
     * @Route("/like/{id}/{nick}/{usernick}", name="like_question")
     */
    public function like($id, $nick, $usernick)
    {
        $redis = new Client();

        $redis->srem("question:{$id}:unlike", $nick);
        $redis->sadd("question:{$id}:like", $nick);

        return $this->redirectToRoute('profile_view',
            array(
                'nick' => $usernick
            )
        );
    }

    /**
     * @Route("/unlike/{id}/{nick}/{usernick}", name="unlike_question")
     */
    public function unlike($id, $nick, $usernick)
    {
        $redis = new Client();

        $redis->srem("question:{$id}:like", $nick);
        $redis->sadd("question:{$id}:unlike", $nick);

        return $this->redirectToRoute('profile_view',
            array(
                'nick' => $usernick
            )
        );
    }
}