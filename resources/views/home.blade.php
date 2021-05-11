@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('includes.message')

            @foreach ($images as $image)
                <div class="card pub_image">
                    <div class="card-header">
                        <div class="container-avatar">
                            <img src="{{ route('user.avatar', ['filename'=>$image->user->image]) }}" alt="" class="avatar">
                        </div>
                        <div class="data-user">
                            {{ $image->user->name.' '.$image->user->surname }}
                            <span class="nick">{{ ' | @'.$image->user->nick }}</span>
                        </div>
                        
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="image-container">
                            <img src="{{ route('image.file',['filename' => $image->image_path  ]) }}" alt="">
                        </div>

                        <div class="likes">

                        </div>
                        
                        <div class="description">
                            <p>
                                <span class="nick">{{'@'.$image->user->nick }}</span> 
                                {{ $image->description }}
                            </p>
                        </div>
                        
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
@endsection
