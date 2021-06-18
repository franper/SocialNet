@extends('layouts.app')

@section('content')
<main class="py-4">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
           <div class="card">
               <div class="card-header">Update Post</div>
               <div class="card-body">
                    <form action="{{ route('image.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="image_id" value="{{ $image->id }}">
                        <div class="form-group row">
                            <div class="image-container">
                                <img src="{{ route('image.file',['filename' => $image->image_path  ]) }}" alt="">
                            </div>
                            <label for="image_path" class="col-md-4 col-form-label text-md-right">Image</label>
                            <div class="col-md-6">
                                <input type="file" class="form-control" name="image_path" id="image_path">
                                @if ($errors->has('image_path'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('image_path') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="description" id="description"> {{ $image->description }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <input type="submit" value="Update Post" class="btn btn-success">
                            </div>
                        </div>
                    </form>
               </div>
           </div>
        </div>
    </div>
</div>
</main>
@endsection