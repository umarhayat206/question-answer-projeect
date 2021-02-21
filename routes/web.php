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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/question','QuestionController@index')->name('questionhome');

Route::get('/create','QuestionController@create')->name('question.create');

Route::post('/store','QuestionController@store')->name('question.store');

Route::get('/question/{id}','QuestionController@show')->name('question.show');