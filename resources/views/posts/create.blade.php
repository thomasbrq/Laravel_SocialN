@extends('layouts.navbar')

@section('title', 'Create post')

@section('sidebar')
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loading-bar.min.css') }}">
    @parent
@endsection

@section('content')

@auth
<div id="container">
    <h1>Create post</h1>
    <div class="message">
        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <a class="nav-link active" id="pills-post-tab" data-bs-toggle="pill" href="#pills-post" role="tab" aria-controls="pills-post" aria-selected="true">Post</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-picture-tab" data-bs-toggle="pill" href="#pills-picture" role="tab" aria-controls="pills-picture" aria-selected="false">Picture</a>
                  </li>
                <li class="nav-item" role="presentation">
                  <a class="nav-link" id="pills-website-tab" data-bs-toggle="pill" href="#pills-website" role="tab" aria-controls="pills-website" aria-selected="false">Website link</a>
                </li>
              </ul>
              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-post" role="tabpanel" aria-labelledby="pills-post-tab">
                    <input type="text" name="author" id="author" value="{{ auth()->user()->id }}" class="hider">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" maxlength="100">

                    <div class="loading-bar">
                        <div class="ldBarTitle" data-value="0" id="ldBarTitle" data-max='100' data-preset="circle" style="width: 25px;height: 25px">
                        </div>
                    </div>

                    <label for="description">Description</label>
                    <textarea name="description" id="description" cols="30" rows="10" maxlength="500"></textarea>
                    
                    <div class="loading-bar">
                        <div class="ldBarDescription" data-value="0" id="ldBarDescription" data-max='500' data-preset="circle" style="width: 25px;height: 25px">
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-picture" role="tabpanel" aria-labelledby="pills-picture-tab">
                    <input type="file" name="picture" id="picture">
                </div>
                <div class="tab-pane fade" id="pills-website" role="tabpanel" aria-labelledby="pills-website-tab">
                    
                </div>
              </div>

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

<script src="{{ asset('js/loading-bar.min.js') }}"></script>

<script>

// Title

let title = $('#title');
title_value = 0;

title.on('input', function() {
    if(title.val().length > 90) {
        $('#ldBarTitle').find('path.mainline').css('stroke', '#FF0000')
        $('#ldBarTitle').children('.ldBar-label').css('color', '#FF0000')
    } else {
        $('#ldBarTitle').find('path.mainline').css('stroke', '#2277ff')
        $('#ldBarTitle').children('.ldBar-label').css('color', '#2277ff')
    }

    title_value = title.val().length;
    bar1.set(title_value);
});

var bar1 = new ldBar("#ldBarTitle");

// Description

let description = $('#description')
description_value = 0;

description.on('input', function() {
    if(description.val().length > 480) {
        $('#ldBarDescription').find('path.mainline').css('stroke', '#FF0000')
        $('#ldBarDescription').children('.ldBar-label').css('color', '#FF0000')
    } else {
        $('#ldBarDescription').find('path.mainline').css('stroke', '#2277ff')
        $('#ldBarDescription').children('.ldBar-label').css('color', '#2277ff')
    }

    description_value = description.val().length;
    bar2.set(description_value);
});

var bar2 = new ldBar("#ldBarDescription");


</script>

@endsection
