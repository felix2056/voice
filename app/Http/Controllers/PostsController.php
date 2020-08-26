<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Post;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->get();
        return response()->json(['posts' => $posts]);
    }

    public function myPosts()
    {
        $user = User::find(Auth::user()->id);
        $posts = Post::where('user_id', $user->id)->with('user')->get();

        return response()->json(['posts' => $posts]);
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->with('user')->first();

        return response()->json(['post' => $post]);
    }

    public function store(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $headline = $request->headline;
        $body = $request->body;

        $post = new Post();
        $post->user_id = $user->id;
        $post->headline = $headline;

        $post->save();

        // broadcast(new NewPost($message->load('user')))->toOthers();

        return response()->json([
            'success' => 'Your post has been sent!'
        ]);        
    }

    public function destroy(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $post = Post::find($request->id);

        if (!$post) {
            return response()->json('error', 'This post does not exist!');
        }

        if ($post->user_id == $user->id || $user->hasRole('Admin')) {
            $post->delete();

            return response()->json([
                'success' => 'This post has been deleted!'
            ]); 
        }

        return response()->json([
            'error' => 'Unresolved permission!'
        ]);     
    }
}
