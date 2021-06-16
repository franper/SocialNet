<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image as InterventionImage;
use App\Image;
use App\Comment;
use App\Like;

class ImageController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function create(){
        return view('image.create');
    }

    public function save(Request $request){
        
        //validacion    
        $validate = $this->validate($request, [
            'description' => 'required',
            'image_path' => 'required|mimes:jpg,jpeg,png,gif'
        ]);
        
        
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        //asignar los valores
        $image = new Image();
        $user = \Auth::user();

        $image->user_id = $user->id;
        
        $image->description = $description;

        //subir fichero
        if($image_path){
            //le asiganamos un nombre unico al fichero
            $image_path_name = time().$image_path->getClientOriginalName();

            //ruta del storage con el nombre del fichero unico
            $storagePath  = Storage::disk('images')->getDriver()->getAdapter()->getPathPrefix().$image_path_name;

            //para redimensionar la imagen con 1080 de ancho y que se adapte el alto
            InterventionImage::make($image_path)
                    ->resize(1080,null, function ($constraint){ 
                        $constraint->aspectRatio();
                    })
                    ->save($storagePath);

            //otra forma de guardar sin redimensionar la imagen
            //Storage::disk('images')->put($image_path_name, File::get($image_path));

            $image->image_path = $image_path_name;
        }
        $image->save();

        return redirect()->route('home')->with([
            'message' => 'the picture has been uploaded successfully'
        ]);
        
    }

    public function getImage($filename){
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }

    public function detail($id){
        $image = Image::find($id);
        return view('image.detail', ['image' => $image]);
    }

    public function delete($id){
        $user = \Auth::user();
        $image = Image::find($id);
        $comments = Comment::where('image_id',$id)->get();
        $likes = Like::where('image_id',$id)->get();

        if($user && $image && $image->user_id == $user->id){
            //eliminar comentarios
            if($comments && count($comments) >= 1){
                foreach($comments as $comment){
                    $comment->delete();
                }
            }
            //eliminar likes
            if($likes && count($likes) >= 1){
                foreach($likes as $like){
                    $like->delete();
                }
            }
            //eliminar la imagen del storage images
            Storage::disk('images')->delete($image->image_path);
            //eliminas post
            $image->delete();

            return redirect()->route('home')->with([
                'message' => 'the post has been removed succefully'
            ]);

        }else{
            return redirect()->route('home')->with([
                'message' => 'the post can not be remove'
            ]);
        }

    }

    public function edit($id){
        $user = \Auth::user();
        $image = Image::find($id);

        if($user && $image && $image->user_id == $user->id){
            return view('image.edit',[
                'image' => $image
            ]);

        }else{
            return redirect()->route('home');
        }
    }

    public function update(REQUEST $request){
        //validacion    
        $validate = $this->validate($request, [
            'description' => 'required',
            'image_path' => 'mimes:jpg,jpeg,png,gif'
        ]);

        $image_id = $request->input('image_id');
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        //conseguir el objeto image
        $image = Image::find($image_id);
        $image->description = $description;

        //subir fichero
        if($image_path){
            //le asiganamos un nombre unico al fichero
            $image_path_name = time().$image_path->getClientOriginalName();

            //ruta del storage con el nombre del fichero unico
            $storagePath  = Storage::disk('images')->getDriver()->getAdapter()->getPathPrefix().$image_path_name;

            //para redimensionar la imagen con 1080 de ancho y que se adapte el alto
            InterventionImage::make($image_path)
                    ->resize(1080,null, function ($constraint){ 
                        $constraint->aspectRatio();
                    })
                    ->save($storagePath);

            //otra forma de guardar sin redimensionar la imagen
            //Storage::disk('images')->put($image_path_name, File::get($image_path));

            $image->image_path = $image_path_name;
        }
        //actualizar registro
        $image->update();

        return redirect()->route('home')->with([
            'message' => 'the picture has been update successfully'
        ]);
        
    }


}
