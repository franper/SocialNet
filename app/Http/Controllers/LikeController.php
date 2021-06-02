<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;

class LikeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function like($image_id){
        //recoger datos del usuario logeado
        $user = \Auth::user();

        $isset_like = Like::where('user_id',$user->id)
                         ->where('image_id',$image_id)
                         ->count();

        if($isset_like == 0){
            $like = new Like();
            $like->user_id = $user->id;
            $like->image_id = (int)$image_id;

            //guardar en la base de datos
            $like->save();
            return response()->json([
                'like' => $like
            ]);
        }else{
            return response()->json([
                'message' => 'el like ya existe'
            ]);
        }
        
    }

    public function dislike($image_id){

        //recoger datos del usuario logeado
        $user = \Auth::user();

        $dislike = Like::where('user_id',$user->id)
                         ->where('image_id',$image_id)
                         ->first();

        if($dislike){

            //guardar en la base de datos
            $dislike->delete();
            return response()->json([
                'dislike' => $dislike,
                'message' => 'le has dado dislike'
            ]);
        }else{
            return response()->json([
                'message' => 'el like no existe'
            ]);
        }
    }
}
