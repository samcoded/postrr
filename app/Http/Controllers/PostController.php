<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\Like;
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

    public function user_posts($id)
    {
        $posts = Post::where('user_id', $id)->get();
        return $posts;
    }

    public function following_posts($id)
    {
        $following = Follow::where('user_id', $id)->pluck('follower_id');
        $posts = Post::whereIn('user_id', $following)->get();
        return $posts;

    }

    public function like($id)
    {
        //check if user has liked this post then like them
        $like = Like::where('user_id', auth()->id())->where('post_id', $id)->first();
        if ($like) {
            $like->delete();
            return response()->json([
                'message' => 'Unliked',
            ]);

        } else {
            Like::create([
                'user_id' => auth()->id(),
                'post_id' => $id,
            ]);

            return response()->json([
                'message' => 'Liked',
            ]);

        }

    }

    public function likes($id)
    {
        //get users that like the post and timestamp

        $likes = Like::where('post_id', $id)->get();
        //link users to likes
        foreach ($likes as $like) {
            $like->user;
        }
        return $likes;
    }
}