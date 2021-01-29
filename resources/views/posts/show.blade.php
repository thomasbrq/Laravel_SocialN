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
        </div>
        <h5>Comments: </h5>
        <div x-data="{ open: false }" class="x-data">
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
                <p>{{ $comment->message }}</p>
                <span>By: {{ $comment->author }}</span>
                <span class="time-ago">{{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
                <hr>
            @endforeach
        </div>
    </div>

    <script>
        setTimeout(function() {
            $('.alert-msg').remove();
        }, 7000);

    </script>
@endsection
