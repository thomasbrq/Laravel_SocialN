<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Exists;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->simplePaginate(10);
        $author = User::with('post_author')->get();
        return view('welcome', compact('posts', 'author'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:100',
            'author' => 'required',
            'description' => 'required|max:500',
        ]);

        $slugex = Str::slug($request->title, '-');

        DB::table('post')->insert([
            'title' => $request->title,
            'slug' => $slugex,
            'description' => $request->description,
            'author' => $request->author,
            'created_at' => Carbon::now(),
        ]); 

        $idd = DB::table('post')->select('id')->orderBy('id', 'desc')->get()->first();

        $idd = $idd->id;

        return redirect('/'.$slugex.'/'.$idd)->with('message', 'Successfully created post!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, $slug, $id)
    {
        $post = DB::table('post')->where('slug', $slug)->where('id', '=', $id)->first();
        $comments = Post::where('slug', $slug)->where('id', $id)->first()->comments;
        $author = User::with('post_author')->get();
        $comment_author = User::with('comment_author')->get();

        $count_comments = Post::find($id);
        $count_comments = $count_comments->comments->count();

        return view('posts.show', compact('post', 'comments', 'author', 'comment_author', 'count_comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post, $slug)
    {
        $post = DB::table('post')->where('slug', '=', $slug)->first();
        if(auth()->user() && auth()->user()->id == $post->author)
        {
            return view('posts.edit', compact('post'));
        }
        else
        {
            return redirect('/')->with('error', 'Action unauthorized!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post, $id)
    {

        $validated = $request->validate([
            'title' => 'required|max:100',
            'author' => 'required',
            'description' => 'required|max:500',
        ]);

        DB::table('post')->where('id', '=', $id)->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'description' => $request->description,
            'author' => $request->author,
        ]);

        return redirect('/')->with('message', 'Post successfully update!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, $slug, $id)
    {
        DB::table('post')->where('id', $id)->where('slug', $slug)->delete();
        return redirect('/')->with('message', 'Post successfully deleted!');
    }
}
