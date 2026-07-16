<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendNotification;
use App\Models\Trip;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function index(Request $request, Trip $trip)
    {
        abort_unless($trip->visibility === 'public' || $trip->user_id === $request->user()->id, 403);

        $comments = $trip->comments()->with('user.profile')->latest()->paginate(20);

        return response()->json([
            'data' => $comments->getCollection()->map(fn ($c) => [
                'id' => (string) $c->id,
                'body' => $c->body,
                'user' => [
                    'id' => (string) $c->user->id,
                    'name' => $c->user->name,
                    'avatar' => $c->user->profile?->avatar ?? UserProfile::DEFAULT_AVATAR,
                ],
                'createdAt' => $c->created_at->toISOString(),
            ]),
            'meta' => [
                'currentPage' => $comments->currentPage(),
                'lastPage' => $comments->lastPage(),
                'total' => $comments->total(),
            ],
        ]);
    }

    public function store(Request $request, Trip $trip)
    {
        abort_unless($trip->visibility === 'public' || $trip->user_id === $request->user()->id, 403);

        $validator = Validator::make($request->all(), [
            'body' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $comment = $trip->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $request->body,
        ]);

        if ($trip->user_id !== $request->user()->id) {
            SendNotification::dispatch(
                userId: $trip->user_id,
                actorId: $request->user()->id,
                type: 'trip_commented',
                tripId: $trip->id,
                title: 'New comment',
                body: "{$request->user()->name} commented on your trip \"{$trip->name}\".",
            );
        }

        return response()->json([
            'comment' => [
                'id' => (string) $comment->id,
                'body' => $comment->body,
                'user' => [
                    'id' => (string) $request->user()->id,
                    'name' => $request->user()->name,
                    'avatar' => $request->user()->profile?->avatar ?? UserProfile::DEFAULT_AVATAR,
                ],
                'createdAt' => $comment->created_at->toISOString(),
            ],
            'comments' => $trip->comments()->count(),
        ]);
    }
}
