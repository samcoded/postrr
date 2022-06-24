<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return Post::all();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $fields = $request->validate([
            'body' => 'required',
        ]);

        //add user id
        $fields['user_id'] = auth()->id();

        return Post::create($fields);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        return Post::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $post = Post::findOrFail($id);
        //check if the request if from current user
        if ($post->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $fields = $request->validate([
            'body' => 'required',
        ]);

        $post->update($fields);
        return $post;

    }

    public function search($searchTerm)
    {
        $posts = Post::where('body', 'like', '%' . $searchTerm . '%')->get();
        return $posts;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::findOrFail($id);
        if ($post->user_id != auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $post->delete();
        return response()->json(['message' => 'Deleted'], 200);
    }

    public function user_posts()
    {
        $posts = Post::where('user_id', auth()->id())->get();
        return $posts;
    }

    public function following_posts()
    {
        $posts = Post::whereIn('user_id', auth()->user()->following()->pluck('following_id'))->get();
        return $posts;
    }

    public function like()
    {
        $post = Post::findOrFail(request('post_id'));
        if (!$post->likes()->where('user_id', auth()->id())->exists()) {
            $post->likes()->attach(auth()->id());
            return response()->json(['message' => 'Liked'], 200);
        } else {
            $post->likes()->detach(auth()->id());
            return response()->json(['message' => 'Unliked'], 200);
        }
    }

    public function likes($id)
    {
        $post = Post::findOrFail($id);
        return $post->likes;
    }
}