@extends('layouts.navbar')

@section('title', 'Home')

@section('sidebar')
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    @parent
@endsection

@section('content')

    <form action="/create" method="get" class="container-create-post">
        <input type="submit" value="Create post" class="create-post" />
    </form>

    @if (session()->has('message'))
        {{ session()->get('message') }}
    @endif


    <div class="scrolling-pagination">
        <div id="container">
            @foreach ($posts as $post)
                <a href="{{ route('post.show', $post->slug) }}" class="a-div">
                    <div class="post-container">
                        Posted by : <b>{{ $post->author }}</b>
                        <h5>{{ $post->title }}</h5>
                        <p>{{ $post->description }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/infinite-scroll@4/dist/infinite-scroll.pkgd.min.js"></script>
    <script>
        $('.scrolling-pagination').infiniteScroll({
            // options
            path: '.next-page',
            append: '#container',
            history: false,
        });

    </script>
@endsection

{{ $posts->links() }}