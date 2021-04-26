<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Image;

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
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }
        $image->save();

        return redirect()->route('home')->with([
            'message' => 'the picture has been uploaded successfully'
        ]);
        
    }
}
