<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppRating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function mine(Request $request)
    {
        $rating = AppRating::where('user_id', $request->user()->id)->first();

        return response()->json([
            'data' => $rating ? ['stars' => $rating->stars, 'comment' => $rating->comment] : null,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'stars' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $rating = AppRating::updateOrCreate(
            ['user_id' => $request->user()->id],
            $data
        );

        return response()->json([
            'message' => 'Thanks for your feedback!',
            'data' => ['stars' => $rating->stars, 'comment' => $rating->comment],
        ]);
    }
}
