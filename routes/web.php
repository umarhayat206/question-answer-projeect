<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|https://www.bootdey.com/snippets/view/profile-with-data-and-skills
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|composer require laravel/ui
|php artisan ui bootstarp --auth
|composer self-update --2
|step 2 – Database Configuration  Step 3 – Install Laravel UI  composer require laravel/ui
|Step 4 – Install Bootstrap Auth Scaffolding php artisan ui bootstrap --auth|
|Step 5 – Install Npm Packages npm install  npm run dev
|Step 6 – Run php artisan Migrate
|this line is for once db error php artisan config:cache
|https://stackoverflow.com/questions/39767619/menu-filter-permission-with-laratrust
|https://github.com/shamscorner/tinymce-laravel
|
|To display different roles of users 
|@foreach ($roles as $role)
|        <input type="checkbox" value="{{$role->id}}" name="{{$role->name}}" 
|       @if(auth()->check()) 
|            @foreach(auth()->user()->roles as $userRole)
|                 @if($userRole->id==$role->id) {{"checked"}}
|                 @endif
|             @endforeach
|       @endif> {{$role->name}}</input>
|   @endforeach
|
|Menu configuration of admin lte
|https://stackoverflow.com/questions/39760922/admin-lte-with-laratrust
|
|and code is here
|class MyMenuFilter implements FilterInterface
|
|   public function transform($item)
|    {
|       if (isset($item['permission']) && !Laratrust::isAbleTo($item['permission'])) {
|            return false;
|       }
|        return $item;
|   }
|    }
|and in adminlte.php menu is 
|     [
|            'text' => 'All Categories',
|            'url'  => '/admin/categories',
|            'permission'=>'can_view_categories'
|
|
|   //            'icon' => 'fas fa-fw fa-user',
|        ],
|


*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/question','QuestionController@index')->name('questionhome');

Route::get('/create','QuestionController@create')->name('question.create');

Route::POST('/store','QuestionController@store')->name('question.store');
Route::get('question/{id}/edit','QuestionController@edit')->name('question.edit');
Route::Post('question/{id}/update','QuestionController@update')->name('question.update');
Route::get('question/{id}/delete','QuestionController@destroy')->name('question.delete');
Route::get('/question/{slug}','QuestionController@show')->name('question.show');


// Routes for answers

Route::Post('question/{question}/answer/store','AnswerController@store')->name('question.answer.store');
Route::get('question/{question}/answer/{answer}/edit','AnswerController@edit')->name('question.answer.edit');
Route::Post('question/{question}/answer/{answer}/update','AnswerController@update')->name('question.answer.update');
Route::get('question/{question}/answer/{answer}/delete','AnswerController@destroy')->name('question.answer.delete');
