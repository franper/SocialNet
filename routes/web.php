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

Route::get('/image/file/{filename}', 'ImageController@getImage')->name('image.file');

Route::get('/image/{id}', 'ImageController@detail')->name('image.detail');

Route::post('comment/save','CommentController@save')->name('comment.save');

Route::get('/comment/delete/{id}', 'CommentController@delete')->name('comment.delete');

Route::get('like/{id}','LikeController@like')->name('like.save');

Route::get('dislike/{id}','LikeController@dislike')->name('dislike.delete');

Route::get('likes','LikeController@index')->name('likes');

Route::get('profile/{id}','UserController@profile')->name('user.profile');

Route::get('/image/delete/{id}', 'ImageController@delete')->name('image.delete');

Route::get('/image/edit/{id}', 'ImageController@edit')->name('image.edit');

Route::post('image/update','ImageController@update')->name('image.update');