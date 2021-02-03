@extends('layouts.navbar')

@section('title', 'Home')

@section('sidebar')
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
    @parent
@endsection

@section('content')

@auth
<div id="container">
    <h1>Create post</h1>
    <div class="message">
        <form action="{{ route('post.store') }}" method="POST">
            @csrf
            <input type="text" name="author" id="author" value="{{ auth()->user()->id }}" class="hider">
            <label for="title">Title</label>
            <input type="text" name="title" id="title">
            <label for="description">Description</label>
            <textarea name="description" id="description" cols="30" rows="10"></textarea>
            <button type="submit">Envoyer</button>
        </form>
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
</div>
<script src="{{ asset('js/hide.js') }}"></script>
@endauth

@guest
    <script>window.location.href = "/";</script>
@endguest

@endsection
