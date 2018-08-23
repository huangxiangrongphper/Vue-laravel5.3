<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/topics','TopicsController@index')->middleware('api');

Route::post('/question/follower','QuestionFollowController@follower')->middleware('auth:api');

Route::post('/question/follow','QuestionFollowController@followThisQuestion')->middleware('auth:api');

Route::get('/user/followers/{id}','FollowersController@index');
Route::post('/user/follow','FollowersController@follow');

Route::post('/answer/{id}/votes/users','VotesController@users');
Route::post('/answer/vote','VotesController@vote');
Route::post('/message/store','MessagesController@store');

Route::get('answer/{id}/comments','CommentsController@answer');
Route::get('question/{id}/comments','CommentsController@question');

Route::post('comment','CommentsController@store');

Route::get('/todos', function () {
    return App\Task::all();
});

Route::get('/todo/{id}', function ($id) {
    return App\Task::find($id);
});

Route::post('/todo/create',function (Request $request){
    $data = ['title' => $request->get('title'),'completed' => 0];
    $todo = App\Task::create($data);

    return $todo;
});

Route::patch('/todo/{id}/completed',function ($id){
    $todo = App\Task::find($id);
    $todo->completed = ! $todo->completed;
    $todo->save();

    return $todo;
});

Route::delete('/todo/{id}/delete',function ($id){
    $todo = App\Task::find($id);
    $todo->delete();
    return response()->json(['deleted']);
});
