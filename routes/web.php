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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/intros/list', function() {
    $intros = \App\Intro::all();
    return $intros;
});
Route::resource('intros','IntroController');
// Route:get('mail', function(){
//     $article = App\Article::with('user')->find(1);
//     return Mail::send(
//         'emails.articles.created',
//         compact('article'),
//         function ($message)
//     );
// })