@extends('layouts.app')
@section('content')
<main class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <div class="row">
                    <!-- aqui se muestra las publicaciones favortitas >>importante pasarle la variable-->
                    @foreach ($likes as $like)
                        <div class="col-12 col-md-4">
                            @include('includes.post',['image' => $like->image])
                        </div>
                    @endforeach

                    <!-- pagination -->
                    <div class="clearfix"></div>
                    {{ $likes->links() }}
                </div>
            </div>
        </div>

    </div>
</main>
@endsection