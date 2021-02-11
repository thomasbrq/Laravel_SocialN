<?php
use App\Http\Controllers\Controller;
?>

@extends('layouts.navbar')

@section('title', 'Post')

@section('sidebar')
    @parent
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-photo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loading-bar.min.css') }}">
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
            <div class="t-de">
                <h3>{{ $post->title }}</h3>
                @if (!empty($post->website_url))
                    <div class="links-website">
                        <a href="{{ $post->website_url }}" target="_blank">{{ Controller::shortenLink(($post->id)-1) }}<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg></a>
                    </div>
                @endif
                <p>{{ $post->description }}</p>
            </div>
            @if (!empty($post->picture_name))
                <div class="image-post">
                    <img src="{{ url('storage/uploads/'.$post->picture_name) }}">
                </div>
            @endif
            <img class="user-photo h-8 w-8 rounded-full object-cover" src="{{ $author[$post->author-1]['profile_photo_url'] }}" alt="" />
            <a href="/user/profile/{{ $author[$post->author-1]['name'] }}">@<span>{{ $author[$post->author-1]['name'] }}</span></a>
            <span class="time-ago">{{ Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</span>

            @if (auth()->user() && auth()->user()->id == $post->author)
                <form action="{{ route('post.edit', [$post->slug, $post->id]) }}">
                    <button type="submit" class="btn edelete">
                        <svg class="w-6 h-6 edit-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </button>
                </form>

                <button type="button" class="btn edelete" data-toggle="modal" data-target="#exampleModalCenter">
                    <svg class="w-6 h-6 svg-close" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </button>
                  
                  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">Do you really want to delete your post?</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          ...
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <form action="{{ route('post.destroy', [$post->slug, $post->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                      </div>
                    </div>
                  </div>
            @endif
        </div>
        <h5>Comments ({{ $count_comments }}) :</h5>
        @auth
            <div x-data="{ open: false }" class="x-data" x-cloak>
                <button class="add-comment" @click="open = ! open">Add comment</button>
                <form action="{{ route('comment.store', $post->id) }}" method="post" x-show="open" class="form-comment">
                    @csrf
                    <input type="text" name="author" id="author" value="{{ auth()->user()->id }}" class="hider">
                    <label for="message">Message</label>
                    <textarea name="message" id="message" cols="30" rows="10" maxlength="500"></textarea>
                    
                    <div class="loading-bar">
                        <div class="ldBar" data-value="0" id="myItem1" data-max='500' data-preset="circle" style="width: 25px;height: 25px">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-secondary">Send</button>
                </form>
            </div>
        @endauth

        @guest
        <div class="x-data">
            <a href="/login">
                <button class="add-comment">Please log in to create a comment</button>
            </a>
        </div>
        @endguest

            @foreach ($comments as $comment)
            <div class="comments">
                <div class="one-comment">
                    <p>{{ $comment->message }}</p>
                    <img class="user-photo h-8 w-8 rounded-full object-cover" src="{{ $comment_author[$comment->author-1]['profile_photo_url'] }}" alt="" />
                    <a href="/user/profile/{{ $comment_author[$comment->author-1]['name'] }}">@<span>{{ $comment_author[$comment->author-1]['name'] }}</span></a>
                    <span class="time-ago-comment">{{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
                    @if (auth()->user() && auth()->user()->id == $comment->author)
                    <form action="{{ route('comment.destroy', $comment->id) }}">
                        <button type="submit">
                            <svg class="w-6 h-6 svg-close" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach

    </div>

    <script>
        setTimeout(function() {
            $('.alert-msg').remove();
        }, 7000);

    </script>
    <script src="{{ asset('js/hide.js') }}"></script>
    <script src="{{ asset('js/loading-bar.min.js') }}"></script>
    <script>

    let txtarea = $('textarea');
    ta_value = 0;
    

    txtarea.on('input', function() {
        if(txtarea.val().length > 480) {
            $('path.mainline').css('stroke', '#FF0000')
            $('.ldBar-label').css('color', '#FF0000')
        } else {
            $('path.mainline').css('stroke', '#2277ff')
            $('.ldBar-label').css('color', '#2277ff')
        }

        ta_value = txtarea.val().length;
        bar1.set(ta_value);
    });

    var bar1 = new ldBar("#myItem1");

    </script>
@endsection
