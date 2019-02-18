<?php

namespace App\Service;

use Predis\Client;

class Like
{
    public function getLike($id)
    {
        $redis = new Client();
        return $redis->smembers("question:{$id}:unlike");
    }

    public function getUnlike($id)
    {
        $redis = new Client();
        return $redis->smembers("question:{$id}:unlike");
    }


    public function getCountLike($id)
    {
        $redis = new Client();
        return $redis->scard("question:{$id}:like");
    }

    public function getCountUnlike($id)
    {
        $redis = new Client();
        return $redis->scard("question:{$id}:unlike");
    }
}