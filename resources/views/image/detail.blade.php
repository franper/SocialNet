@extends('layouts.app')

@section('content')
<main class="py-4">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            @include('includes.message')

                <div class="card pub_image shadow">
                    <div class="card-header">
                        <div class="container-avatar">
                            <img src="{{ route('user.avatar', ['filename'=>$image->user->image]) }}" alt="" class="avatar">
                        </div>
                        <div class="data-user">
                            <a href="{{ route('user.profile', ['id' => $image->user->id]) }}">
                                {{ $image->user->name.' '.$image->user->surname }}
                                <span class="nick">{{ ' | @'.$image->user->nick }}</span>
                            </a>
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
                            
                            <!-- Comprobar si el usuario dio like -->
                            <?php $user_like = false; ?>

                            @foreach ($image->likes as $like )
                                @if ($like->user_id == Auth::user()->id)
                                    <?php $user_like = true; ?>
                                    
                                @endif
                            @endforeach
                            @if ($user_like)
                                <p class="btn btn-like" data-id="{{ $image->id }}">
                                    <i class="fas fa-heart fa-2x"></i> {{ count($image->likes) }}
                                </p>                               
                            @else
                                <p class="btn btn-dislike" data-id="{{ $image->id }}">
                                    <i class="fal fa-heart fa-2x"></i> {{ count($image->likes) }}
                                </p>
                            @endif
                            <p class="btn btn-comment">
                                <i class="fal fa-comment-alt fa-2x"></i> {{ count($image->comments) }}
                            </p>

                            <p class="btn btn-send">
                                <i class="fal fa-paper-plane fa-2x"></i>
                            </p>
                            
                        </div>
                        
                        <!-- solo muestra los botones si el usuario es dueño del post -->
                        @if (Auth::user() && Auth::user()->id === $image->user_id)
                            <div class="action">
                                <a href="{{ route('image.edit',['id' => $image->id]) }}" class="btn btn-lg text-primary">Update</a>
                                <a href="{{ route('image.delete',['id' => $image->id]) }}" class="btn btn-lg text-danger">Delete</a>
                            </div>
                        @endif
                        
                        <div class="description">
                            <p>
                                <span class="nick">{{'@'.$image->user->nick }}</span>   

                                {{ $image->description }}
                            </p>
                           
                            <span class="nick">{{ \FormatTime::LongTimeFilter($image->created_at) }}</span> 
                           
                        </div>

                        <hr class="separador">
                        <p class="btn-comments">({{ count($image->comments) }}) Comments</p>
                        
                        @foreach ($image->comments as $comment)
                            <div class="comment">
                                <p>
                                    <span class="nick">{{'@'.$comment->user->nick }}</span>   

                                    {{ $comment->content }}
                                </p>
                            
                                <span class="nick">{{ \FormatTime::LongTimeFilter($comment->created_at) }}</span> 
                                @if (Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id))
                                    <a href="{{ route('comment.delete',['id' => $comment->id]) }}" class="btn btn-sm text-danger">Delete</a>
                                @endif
                                <br>
                            
                            </div> 
                        @endforeach
                        

                        <hr class="separador">
                        <div>
                            <form action="{{ route('comment.save') }}" method="post" >
                                @csrf
                                <input type="hidden" name="image_id" value="{{ $image->id }}"> 
                                <div class="input-group comment-format">
                               
                                    <textarea class="form-control {{ $errors->has('content')? 'is-invalid' : '' }}" placeholder="Add a comment..." name="content"></textarea>
                                    
                                    <button class="btn btn-outline-primary btn-lg" type="submit" id="inputGroupFileAddon04">Post</button>
                                    @if ($errors->has('content'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('content') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                            </form>
                        </div>
                        
                    </div>
                </div>
          
        </div>
    </div>

</div>
</main>
@endsection
