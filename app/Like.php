<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';
    //many to one
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    //many to one
    public function Image(){
        return $this->belongsTo('App\Image', 'image_id');
    }
}
