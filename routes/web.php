<?php

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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Auth::routes();

Route::get('/email', function() {
   return new \App\Mail\NewUserWelcomeMail();
});

Route::get('/welcome', 'HomeController@welcome');

Route::post('follow/{user}', 'FollowsController@store');

Route::get('/', 'PostsController@index');
Route::get('/p/create', 'PostsController@create');
Route::get('/p/{post}', 'PostsController@show');
/*Route::get('/p/create', 'PostsController@create'); SE COLOCAR AQUI ESSA LINHA FICAMOS COM ERRO 404 NESSA PÁGINA, PQ?
PQ HÁ CONFLITO SE VOCÊ COLOCAR AS ROTAS NA ORDEM ERRADA, NOTE QUE create é específico enquanto {post} está pegando tudo
depois de /p/... como se fosse uma variável*/
Route::post('/p', 'PostsController@store');

// using all conventions for restful controllers from laravel
Route::get('/profile/{user}', 'ProfilesController@index')->name('profile.show');
Route::get('/profile/{user}/edit', 'ProfilesController@edit')->name('profile.edit');
Route::patch('/profile/{user}', 'ProfilesController@update')->name('profile.update');
