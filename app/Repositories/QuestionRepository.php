<?php

namespace App\Repositories;


use App\Topic;
use App\Question;

/**
 * Class QuestionRepository
 *
 * @package App\Repositories
 */
class QuestionRepository
{
    /**
     * @param $id
     *
     * @return mixed
     */
    public function byIdWithTopicsAndAnswers($id)
    {
        return Question::where('id',$id)->with(['topics','answers'])->first();
    }

    public function create(array $attributes)
    {
        return Question::create($attributes);
    }

    public function byId($id)
    {
        return Question::find($id);
    }

    public function getQuestionFeed()
    {
        return Question::published()->latest('updated_at')->with('user')->get();
    }

    public function getQuestionCommentsById($id)
    {
        $question = Question::with('comments','comments.user')->where('id',$id)->first();

        return $question->comments;
    }

    public function normalizeTopic(array $topics)
    {
        return collect($topics)->map(function ($topic){
            if(is_numeric($topic) && $topic_number = (int)$topic){
                if( $newTopic = Topic::find($topic_number) ){
                    $newTopic->increment('questions_count');
                    return $topic_number;
                }

            }

            if($newTopic = Topic::where('name',$topic)->first()){
                $newTopic->increment('questions_count');
                return $newTopic->id;
            }

            $newTopic = Topic::create(['name'=>$topic , 'questions_count'=>1]);
            return $newTopic->id;
        })->toArray();
    }
}
