<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //find comments if post is id
        $comments = Comment::where('post_id', $id)->get();
        return response()->json([
            'comments' => $comments,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        //
        $fields = $request->validate([
            'body' => 'required',
        ]);

        //add user id
        $fields['user_id'] = auth()->id();

        //add post id
        $fields['post_id'] = $id;

        $post = Post::findOrFail($id);

        $comment = Comment::create($fields);

        return response()->json([
            'message' => 'Comment created',
            'comment' => $comment,
        ]);
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

        $comment = Comment::findOrFail($id);
        return response()->json([
            'comment' => $comment,
        ]);

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
        $comment = Comment::findOrFail($id);
        //check if the request if from current user
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $fields = $request->validate([
            'body' => 'required',
        ]);

        $comment->update($fields);

        return response()->json([
            'message' => 'Comment updated',
            'comment' => $comment,
        ]);

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
        $comment = Comment::findOrFail($id);
        if ($comment->user_id != auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted',
        ]);

    }
}