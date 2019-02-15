<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('question', [$this, 'QuestionAnswerFilter'])
        ];
    }

    public function QuestionAnswerFilter($data)
    {

        $result = array();

        foreach ($data as $key => $value){
            $result[] = [
                'question_text' => $value['text'],
                'question_time' => $value['time'],
                'question_who_asked' => $value['who_asked'],
                'question_to_asked' => $value['to_asked'],
                'question_status' => $value['status'],
                'question_anon' => $value['anon'],
                'answer_text' => $value[0]->getText(),
                'answer_user_id' => $value[0]->getUserId(),
                'answer_to_user_id' => $value[0]->getToUserId(),
                'answer_time' => $value[0]->getTime()
            ];
        }

        return $result;
    }

}