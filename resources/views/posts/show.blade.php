@extends('layouts.navbar')

@section('title', 'Home')

@section('sidebar')
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
    @parent
@endsection

@section('content')

    <div id="container">
        <div class="message">
            <h3>{{ $post->title }}</h3>
            <p>{{ $post->description }}</p>
            <span>By: {{ $post->author }}</span>
            <span class="time-ago">{{ Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</span>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h5>Comments: </h5>
        <button class="add-comment">Add comment</button>
        <div class="comments">
            @foreach ($comments as $comment)
            <p>{{ $comment->message }}=</p>
            <span>By: {{ $comment->author }}</span>
            <span class="time-ago">{{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
            <hr>
            @endforeach
        </div>
    </div>
@endsection
