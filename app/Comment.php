<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    //many to one
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    //many to one
    public function Image(){
        return $this->belongsTo('App\Image', 'image_id');
    }
}
