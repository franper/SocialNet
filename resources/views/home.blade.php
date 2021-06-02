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
                            <a href="{{ route('image.detail', ['id' => $image->id]) }}">
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
                                <a href="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-heart-fill text-danger" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                                    </svg>
                                </a>                               
                            @else
                                <a href="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-heart text-secondary" viewBox="0 0 16 16">
                                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                                    </svg>
                                </a>
                            @endif
                            

                            <a href="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-chat text-secondary" viewBox="0 0 16 16">
                                <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                                </svg>
                            </a>
                                
                            <a href="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cursor text-secondary" viewBox="0 0 16 16">
                                <path d="M14.082 2.182a.5.5 0 0 1 .103.557L8.528 15.467a.5.5 0 0 1-.917-.007L5.57 10.694.803 8.652a.5.5 0 0 1-.006-.916l12.728-5.657a.5.5 0 0 1 .556.103zM2.25 8.184l3.897 1.67a.5.5 0 0 1 .262.263l1.67 3.897L12.743 3.52 2.25 8.184z"/>
                                </svg>
                            </a>
                                

                        </div>
                        
                        <div class="description">
                            <p>
                                <span class="nick">{{'@'.$image->user->nick }}</span>   

                                {{ $image->description }}
                            </p>
                           
                            <span class="nick">{{ \FormatTime::LongTimeFilter($image->created_at) }}</span> 
                           
                        </div>

                        <a href="{{ route('image.detail', ['id' => $image->id]) }}" class="btn btn-light btn-comments">View all {{ count($image->comments) }} Comments</a>
                        
                        <hr class="separador">
                        <div>
                            <form action="{{ route('comment.save') }}" method="post" >
                                @csrf
                                <input type="hidden" name="image_id" value="{{ $image->id }}"> 
                                <div class="input-group coment-format">
                               
                                    <textarea class="form-control {{ $errors->has('content')? 'is-invalid' : '' }}" placeholder="Add a comment..." name="content"></textarea>
                                    
                                    <button class="btn btn-outline-primary" type="submit" id="inputGroupFileAddon04">Post</button>
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
            @endforeach

            <!-- pagination -->
            <div class="clearfix"></div>
            {{ $images->links() }}
        </div>
    </div>

</div>
@endsection
