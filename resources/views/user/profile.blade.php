@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="row">
                <div class="col-xs-4 mx-3">
                    @if (Auth::user()->image)
                        <div class="">
                            <img src="{{ route('user.avatar', ['filename'=>$user->image]) }}" alt="" class="rounded-circle">
                        </div>  
                    @endif
                </div>
                <div class="col-xs-8 text-center">
                    <h3>{{ '@'.$user->nick }}</h3>
                    <p>{{ $user->name }} {{ $user->surname }}</p>
                </div>
            </div>             
            <hr>
            
            
                <!-- aqui se muestra las publicaciones importante pasarle la variable-->
                @foreach ($user->images as $image)
                    
                        @include('includes.post',['image' => $image])

                        
                    
                @endforeach
            
        </div>
    </div>

</div>
@endsection