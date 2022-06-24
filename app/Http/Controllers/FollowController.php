<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function follow($id)
    {
        // check if user is following then follow or unfollow them
        $follow = Follow::where('user_id', auth()->id())->where('follower_id', $id)->first();
        if ($follow) {
            $follow->delete();
            return response()->json([
                'message' => 'Unfollowed',
            ]);

        } else {
            Follow::create([
                'user_id' => auth()->id(),
                'follower_id' => $id,
            ]);

            return response()->json([
                'message' => 'Followed',
            ]);

        }

    }

    public function user_followers($id)
    {
        //

        $user = auth()->user();

        $followers = $user->followers()
            ->where('follower_id', $id)
            ->get();

        return response()->json([
            'followers' => $followers,
        ]);

    }

    public function user_following($id)
    {
        //

        $user = auth()->user();

        $following = $user->following()
            ->where('user_id', $id)
            ->get();

        return response()->json([
            'following' => $following,
        ]);

    }
}