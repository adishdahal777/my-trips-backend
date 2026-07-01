<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Trip;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Request $request, Trip $trip)
    {
        $like = Like::where('trip_id', $trip->id)->where('user_id', $request->user()->id)->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            Like::create(['trip_id' => $trip->id, 'user_id' => $request->user()->id]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likes' => $trip->likes()->count(),
        ]);
    }
}
