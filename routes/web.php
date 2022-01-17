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

// Route::get('/', function () {
//     return view('welcome');
// });




//Auth::routes();
Auth::routes(['verify' => true]);


//mustverify＝メール認証した人のみのルート
Route::middleware(['verified'])->group(function(){
   
   //homeをログイン画面に変更
    Route::get('/',function(){
        return view('auth.login');
    });
   Route::get('/home','HomeController@index')->name('home');
    //Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    //リソースコントローラー
    Route::resource('/post' , 'PostController');
   
    //commentのルート
    Route::post('/post/comment/store', 'CommentController@store')->name('comment.store');

    //mypostのルート
    Route::get('/mypost', 'HomeController@mypost')->name('home.mypost');
    
    //mycommentのルート
    Route::get('/mycomment','HomeController@mycomment')->name('home.mycomment');
   
    //user一覧のルート
    //管理者のGate有効
    Route::middleware(['can:admin'])->group(function()
    {
        Route::get('/profile/index' ,'ProfileController@index')->name('profile.index');
    });
    
    //user編集のルート
    Route::get('/profile/{user}/edit' ,'ProfileController@edit')->name('profile.edit');
    Route::put('/profile/{user}' ,'ProfileController@update')->name('profile.update');
});

//contactのルート
Route::get('/contact/create','ContactController@create')->name('contact.create');
Route::post('/contact/store','ContactController@store')->name('contact.store');












