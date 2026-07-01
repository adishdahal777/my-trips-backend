<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request, Trip $trip)
    {
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

        return response()->json([
            'comment' => [
                'id' => (string) $comment->id,
                'body' => $comment->body,
                'user' => ['id' => (string) $request->user()->id, 'name' => $request->user()->name],
                'createdAt' => $comment->created_at->toISOString(),
            ],
            'comments' => $trip->comments()->count(),
        ]);
    }
}
