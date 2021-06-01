<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function save(Request $request){
        //validacion de los campos
        $validate = $this->validate($request,[
            'image_id' => 'integer|required',
            'content' => 'string|required'
        ]);

        //recojo los datos 
        $user = \Auth::user();
        $imagen_id = $request->input('image_id');
        $content = $request->input('content');

        //le asigno los valores
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $imagen_id;
        $comment->content = $content;

        //guardo en la base de datos 
        $comment->save();

        return redirect()->route('image.detail',['id' => $imagen_id])
                         ->with(['message' => 'you post a comment']);
     
    }

    public function delete($id){
        //obtner el usuario identificado 
        $user = \Auth::user();

        //obtener el objeto comentario
        $comment = Comment::find($id);

        /*
        Comprobar si es el dueño del comentario o de la publicacion de imagen
        */
        if($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)){
            $comment->delete();
            return redirect()->route('image.detail',['id' => $comment->image->id])
            ->with(['message' => 'you have remove the comment']);
        }else{
            return redirect()->route('image.detail',['id' => $comment->image->id])
            ->with(['message' => 'the comment can be delete']);
        }

    }
}
