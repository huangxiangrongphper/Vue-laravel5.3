<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Repositories\AnswerRepository;
use App\Repositories\CommentRepository;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;

/**
 * Class CommentsController
 *
 * @package App\Http\Controllers
 */
class CommentsController extends Controller
{
    /**
     * @var \App\Repositories\AnswerRepository
     */
    protected $answer;
    /**
     * @var \App\Repositories\QuestionRepository
     */
    protected $question;
    /**
     * @var \App\Repositories\CommentRepository
     */
    protected $comment;

    /**
     * CommentsController constructor.
     *
     * @param $answer
     * @param $question
     * @param $comment
     */
    public function __construct(AnswerRepository $answer,QuestionRepository $question,CommentRepository $comment)
    {
        $this->answer = $answer;
        $this->question = $question;
        $this->comment = $comment;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function answer($id)
    {
        return $this->answer->getAnswerCommentById($id);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function question($id)
    {
        return $this->question->getQuestionCommentsById($id);
    }

    /**
     * @return \App\Repositories\CommentRepository
     */
    public function store()
    {
        $model = $this->getModelNameFromType(request('type'));

        return $this->comment->create([
            'commentable_id'    => request('model'),
            'commentable_type'  => $model,
            'user_id'           => user('api')->id,
            'body'              => request('body')
        ]);
    }

    /**
     * @param $type
     *
     * @return string
     */
    private function getModelNameFromType($type)
    {
        return $type === 'question' ? 'App\Question' : 'App\Answer';
    }
}
