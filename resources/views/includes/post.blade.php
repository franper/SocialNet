<div class="card pub_image shadow">
    <div class="card-header d-flex">
        <div class="container-avatar">
            <?php if($image->user->image != null) {?>
                <img src="{{ route('user.avatar', ['filename'=>$image->user->image]) }}" alt="" class="avatar">
            <?php }?>
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
            <img class="" src="{{ route('image.file',['filename' => $image->image_path  ]) }}" alt="" >
        </div>

        <div class="likes">
            
            <!-- Comprobar si el usuario dió like -->
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
            <p class="btn">
                <a class="text-dark" href="{{ route('image.detail', ['id' => $image->id]) }}">  
                    <i class="fal fa-comment-alt fa-2x"></i> {{ count($image->comments) }} 
                </a>
            </p>

            <p class="btn btn-send">
                <i class="fal fa-paper-plane fa-2x"></i>
            </p>
            
        </div>
        <!-- solo muestra los botones si el usuario es dueño del post -->
        <?php $uri = '/profile/'.$image->user_id ?>
        
        @if ($_SERVER['REQUEST_URI'] == $uri)
            
        
            @if (Auth::user() && Auth::user()->id === $image->user_id)
                <div class="action">
                    <a href="{{ route('image.edit',['id' => $image->id]) }}" class="btn btn-lg text-primary">Update</a>
                    <a href="{{ route('image.delete',['id' => $image->id]) }}" class="btn btn-lg text-danger">Delete</a>
                </div>
            @endif

        @endif
        
        <div class="description">
            <p>
                <span class="nick">{{'@'.$image->user->nick }}</span>   

                {{ $image->description }}
            </p>
           
            <span class="nick">{{ \FormatTime::LongTimeFilter($image->created_at) }}</span> 
            <!--
            <a href="{{ route('image.detail', ['id' => $image->id]) }}" class="text-black-50 btn-comments">View all {{ count($image->comments) }} Comments</a>
            -->
        </div>

        
        
        <hr class="separador">
        <div>
            <form action="{{ route('comment.save') }}" method="post" >
                @csrf
                <input type="hidden" name="image_id" value="{{ $image->id }}"> 
                <div class="input-group coment-format">
               
                    <textarea class="form-control border border-0 {{ $errors->has('content')? 'is-invalid' : '' }}" placeholder="   Add a comment..." name="content"></textarea>
                    
                    <button class="btn btn-outline-primary btn-lg border border-0" type="submit" id="inputGroupFileAddon04">Post</button>
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