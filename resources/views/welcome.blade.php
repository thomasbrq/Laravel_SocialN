@extends('layouts.navbar')

@section('title', 'Home')

@section('sidebar')
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-photo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ue-scroll.min.css') }}">
    @parent
@endsection

@section('content')
<div id="ue-scroll" class="ue-scroll btn-white arrow-black circle shadow"></div>

<div class="alert-msg c-alert">
    @if (session()->has('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
    @guest
        <form action="/login" class="container-create-post">
            <input type="submit" value="Please log in to create a post" class="create-post" />
        </form>
    @endguest
    
    @auth
        <form action="/create" method="get" class="container-create-post">
            <input type="submit" value="Create post" class="create-post" />
        </form>
    @endauth
    <div class="scrolling-pagination">
        <div id="container">
            @foreach ($posts as $post)
                <a href="{{ route('post.show', [$post->slug, $post->id]) }}" class="a-div">
                    <div class="post-container">
                        <img class="user-photo h-8 w-8 rounded-full object-cover" src="{{ $author[$post->author-1]['profile_photo_url'] }}" alt="" />
                        @<span>{{ $author[$post->author-1]['name'] }}</span>
                        <div class="t-de">
                            <h4>{{ $post->title }}</h4>
                            <p class="desc-w">{{ $post->description }}</p>
                        </div>
                        @if (!empty($post->picture_name))
                            <div class="image-post">
                                <img src="{{ url('/images/'.$post->picture_name) }}">
                            </div>
                        @endif
                        <div class="comment-post">
                            <span>{{ $post->comments->count() }}</span>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            <span class="time-ago">{{ Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <script src="{{ asset('js/infinite-scroll.min.js') }}"></script>
    <script>
        $('.scrolling-pagination').infiniteScroll({
            // options
            path: '.next-page',
            append: '#container',
            history: false,
            scrollThreshold: 50,
        });
    </script>
    <script>
        setTimeout(function() {
            $('.alert-msg').remove();
        }, 7000);

    </script>
    <script src="{{ asset('js/hide.js') }}"></script>
    <script src="{{ asset('js/ue-scroll.min.js') }}"></script>
    <script>
      UeScroll.init();
    </script>
@endsection

{{ $posts->links() }}