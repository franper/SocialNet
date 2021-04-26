<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function config(){

        return view('user.config');

    }

    public function update(Request $request){

        //conseguir usuario identificado
        $user = \Auth::user();
        $id = $user->id;

        //validacion del formulario
        $validate = $this->validate($request,[
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'nick' => 'required|string|max:255|unique:users,nick,'.$id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$id
        ]);

        //recoger los datos del formulario
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');

        //asignar nuevos valores al objeto de usuario
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;

        //subir las imagenes
        $image_path = $request->file('image_path');
        if($image_path){
            //poner un nombre unico a la imagen
            $image_path_name = time().$image_path->getClientOriginalName();

            //guardar en la carpeta storage (storage/app/users )
            Storage::disk('users')->put($image_path_name, File::get($image_path));

            //le doy el valor al objeto usuario
            $user->image = $image_path_name;
        }

        //ejecutar consulta y cambios en la base de datos
        $user->update();

        return redirect()->route('config')
                         ->with(['message' => 'your detail has been updated succefully']);
    }

    public function getImage($filename){
        $file = Storage::disk('users')->get($filename);
        return new Response($file, 200);
    }
}
