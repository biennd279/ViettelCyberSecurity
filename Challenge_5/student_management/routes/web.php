<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([], function () {
    Route::get('/', function () {
        return view('welcome');
    })->middleware(['auth', '2fa'])
    ->name('index');

    Route::get('/login', [
        'uses' => 'App\Http\Controllers\LoginController@getLogin',
        'as' => 'login'
    ]);

    Route::post('/login', [
        'uses' => 'App\Http\Controllers\LoginController@authenticate',
        'as' => 'auth'
    ]);

    Route::get('/logout', [
        'uses' => 'App\Http\Controllers\LoginController@logout',
        'as' => 'logout'
    ]);
});



Route::group(['prefix' => 'user', 'middleware' => ['auth', '2fa']], function () {
    //View
    Route::get('', [
        'uses' => 'App\Http\Controllers\UserController@getIndex',
        'as'=> 'user'
    ]);

    Route::get('index', [
        'uses' => 'App\Http\Controllers\UserController@getIndex',
        'as'=> 'user.index'
    ]);

    Route::get('student', [
       'uses' => 'App\Http\Controllers\UserController@getStudent',
        'as' => 'students'
    ]);

    Route::get('teacher', [
           'uses' => 'App\Http\Controllers\UserController@getTeacher',
            'as' => 'teachers'
    ]);

    Route::get('create', [
        'uses' => 'App\Http\Controllers\UserController@getCreateUser',
        'as' => 'user.create'
    ]);

    Route::get('{id}/edit', [
        'uses' => 'App\Http\Controllers\UserController@getEditUser',
        'as' => 'user.edit'
    ]);

    Route::get('{id}', [
        'uses' => 'App\Http\Controllers\UserController@getUser',
        'as' => 'user.show'
    ]);

    //API
    Route::post('store', [
        'uses' => 'App\Http\Controllers\UserController@postCreate',
        'as' => 'user.store'
    ]);

    Route::post('edit', [
        'uses' => 'App\Http\Controllers\UserController@postEditUser',
        'as' => 'user.update'
    ]);

    Route::get('{id}/delete', [
        'uses' => 'App\Http\Controllers\UserController@getDelete',
        'as' => 'user.destroy'
    ]);
});

Route::group(['prefix' => 'assignment', 'middleware' => ['auth', '2fa']], function () {
    //Assigment
    Route::get('',[
        'uses' => 'App\Http\Controllers\AssignmentController@getIndex',
        'as' => 'assignment'
    ]);

    Route::get('index',[
        'uses' => 'App\Http\Controllers\AssignmentController@getIndex',
        'as' => 'assignment.index'
    ]);

    Route::get('create',[
        'uses' => 'App\Http\Controllers\AssignmentController@getCreateAssignment',
        'as' => 'assignment.create'
    ]);

    Route::post('store',[
        'uses' => 'App\Http\Controllers\AssignmentController@postStoreAssignment',
        'as' => 'assignment.store'
    ]);

    Route::get('{id}/delete', [
        'uses' => 'App\Http\Controllers\AssignmentController@getDeleteAssignment',
        'as' => 'assignment.destroy'
    ]);

    //Submission
    Route::get('{id}', [
        'uses' => 'App\Http\Controllers\SubmissionController@getIndex',
        'as' => 'submission.index'
    ]);

    Route::get('{id}/submit', [
        'uses' => 'App\Http\Controllers\SubmissionController@getCreateSubmit',
        'as' => 'submission.create'
    ]);

    Route::post('{id}/store', [
        'uses' =>  'App\Http\Controllers\SubmissionController@postCreateSubmit',
        'as' => 'submission.store'
    ]);
});


Route::group(['prefix' => 'challenge', 'middleware' => ['auth', '2fa']], function () {
    //Challenge
    Route::get('', [
        'uses' => 'App\Http\Controllers\ChallengeController@getIndex',
        'as' => 'challenge'
    ]);

    Route::get('index', [
        'uses' => 'App\Http\Controllers\ChallengeController@getIndex',
        'as' => 'challenge.index'
    ]);

    Route::get('create', [
        'uses' => 'App\Http\Controllers\ChallengeController@getCreateChallenge',
        'as' => 'challenge.create'
    ]);

    Route::post('post', [
        'uses' => 'App\Http\Controllers\ChallengeController@postStoreChallenge',
        'as' => 'challenge.store'
    ]);

    Route::post('submit', [
        'uses' => 'App\Http\Controllers\ChallengeController@postSubmit',
        'as' => 'challenge.submit'
    ]);
});


Route::group(['prefix' => 'message', 'middleware' => ['auth', '2fa']], function () {
//Message
    Route::get('', [
        'uses' => 'App\Http\Controllers\MessageController@getIndex',
        'as' => 'message'
    ]);

    Route::get('index', [
        'uses' => 'App\Http\Controllers\MessageController@getIndex',
        'as' => 'message.index'
    ]);

    Route::get('{id}', [
        'uses' => 'App\Http\Controllers\MessageController@getFetchMessage',
        'as' => 'message.fetch'
    ]);

    Route::post('{id}', [
        'uses' => 'App\Http\Controllers\MessageController@postStoreMessage',
        'as' => 'message.store'
    ]);

    Route::get('{id}/delete', [
        'uses' => 'App\Http\Controllers\MessageController@getDeleteMessage',
        'as' => 'message.destroy'
    ]);

    Route::post('{id}/update', [
        'uses' => 'App\Http\Controllers\MessageController@postUpdateMessage',
        'as' => 'message.update'
    ]);
});

Route::group(['prefix' => 'two_face_auths', 'middleware' => 'auth'], function () {
    Route::get('/', [
        'uses' => 'App\Http\Controllers\TwoFaceAuthsController@index',
        'as' => '2fa.index',
    ]);
    Route::post('/enable', [
        'uses' => 'App\Http\Controllers\TwoFaceAuthsController@enable',
        'as' => '2fa.enable',
    ]);
});

Route::group(['prefix' => 'two_face', 'middleware' => 'auth'], function () {
    Route::get('/', [
        'uses' => 'App\Http\Controllers\VerifyTwoFaceAuthController@index',
        'as' => '2fa.verify.index'
    ]);

    Route::post('/verify', [
       'uses' => 'App\Http\Controllers\VerifyTwoFaceAuthController@verify',
        'as' => '2fa.verify'
    ]);
});

Route::get('/redirect/{social}', 'App\Http\Controllers\SocialAuthController@redirect')
    ->name('facebook.redirect');
Route::get('/callback/{social}', 'App\Http\Controllers\SocialAuthController@callback')
    ->name('facebook.callback');

