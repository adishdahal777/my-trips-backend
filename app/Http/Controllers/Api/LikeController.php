<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendNotification;
use App\Models\Like;
use App\Models\Trip;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Request $request, Trip $trip)
    {
        abort_unless($trip->visibility === 'public' || $trip->user_id === $request->user()->id, 403);

        $like = Like::where('trip_id', $trip->id)->where('user_id', $request->user()->id)->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            try {
                Like::create(['trip_id' => $trip->id, 'user_id' => $request->user()->id]);
            } catch (QueryException) {
                // Concurrent request already created the like — treat as success.
            }
            $liked = true;

            if ($trip->user_id !== $request->user()->id) {
                SendNotification::dispatch(
                    userId: $trip->user_id,
                    actorId: $request->user()->id,
                    type: 'trip_liked',
                    tripId: $trip->id,
                    title: 'New like',
                    body: "{$request->user()->name} liked your trip \"{$trip->name}\".",
                );
            }
        }

        return response()->json([
            'liked' => $liked,
            'likes' => $trip->likes()->count(),
        ]);
    }
}
