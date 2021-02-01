@extends('layouts.navbar')

@section('title', 'Home')

@section('sidebar')
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
    @parent
@endsection

@section('content')
    <div class="alert-msg">
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

    <div id="container">
        <div class="message">
            <h3>{{ $post->title }}</h3>
            <p>{{ $post->description }}</p>
            <span>By: {{ $post->author }}</span>
            <span class="time-ago">{{ Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</span>
            <form action="{{ route('post.edit', [$post->slug, $post->id]) }}">
                <button type="submit">
                    <svg class="w-6 h-6 edit-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                </button>
            </form>
            <form action="{{ route('post.destroy', [$post->slug, $post->id]) }}" method="POST">
                @csrf
                <button type="submit">
                    <svg class="w-6 h-6 svg-close" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </button>
            </form>
        </div>
        <h5>Comments: </h5>
        <div x-data="{ open: false }" class="x-data" x-cloak>
            <button class="add-comment" @click="open = ! open">Add comment</button>
            <form action="{{ route('comment.store', $post->id) }}" method="post" x-show="open" class="form-comment">
                @csrf
                <label for="author">Author</label>
                <input type="text" name="author" id="author">
                <label for="message">Message</label>
                <textarea name="message" id="message" cols="30" rows="10"></textarea>
                <button type="submit" class="btn btn-secondary">Send</button>
            </form>
        </div>

        <div class="comments">
            @foreach ($comments as $comment)
                <div class="one-comment">
                    <p>{{ $comment->message }}</p>
                    <span>By: {{ $comment->author }}</span>
                    <span class="time-ago">{{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
                    <form action="{{ route('comment.destroy', $comment->id) }}">
                        <button type="submit">
                            <svg class="w-6 h-6 svg-close" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </button>
                    </form>
                    <hr>
            </div>
            @endforeach
        </div>
    </div>

    <script>
        setTimeout(function() {
            $('.alert-msg').remove();
        }, 7000);

    </script>
@endsection
