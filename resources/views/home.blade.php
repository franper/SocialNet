@extends('layouts.app')

@section('content')
<main class="py-4">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            @include('includes.message')

            <!-- aqui se muestra las publicaciones importante pasarle la variable-->
            @foreach ($images as $image)
                @include('includes.post',['image' => $image])
            @endforeach

            <!-- pagination -->
            <div class="clearfix"></div>
            {{ $images->links() }}
        </div>
    </div>

</div>
</main>
@endsection
