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
//use App\Image;
/*
Route::get('/', function () {
    
    $images = Image::all();

    foreach($images as $image){
        echo $image->image_path.'<br>';
        echo $image->description.'<br>'; 
        echo $image->user->name.' '.$image->user->surname.'<br>'; 
        echo '<strong>Likes<strong> '.count($image->likes);
        if(count($image->comments) >= 1){
            echo '<h4>Comentarios: </h4>';
            foreach($image->comments as $comment){
                echo '<strong>'.$comment->user->name.' '.$comment->user->surname.'</strong> '; 
                echo $comment->content.'<br>';
            }
        }
        
        
        echo '<hr>';
    
    }

    die();
    return view('welcome');
});
*/
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/configuration', 'UserController@config')->name('config');

Route::post('/update', 'UserController@update')->name('user.update');

Route::get('/user/avatar/{filename}', 'UserController@getImage')->name('user.avatar');

Route::get('/upload-image','ImageController@create')->name('image.create');

Route::post('image/save','ImageController@save')->name('image.save');

Route::get('/image/file/{filename}', 'imageController@getImage')->name('image.file');