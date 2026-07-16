<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppRating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index(Request $request)
    {
        $ratings = AppRating::with('user')
            ->when($request->stars, fn ($q, $stars) => $q->where('stars', $stars))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.ratings.index', [
            'ratings' => $ratings,
        ]);
    }

    public function toggleFeatured(AppRating $rating)
    {
        $rating->update(['is_featured' => !$rating->is_featured]);

        return back()->with('success', $rating->is_featured ? 'Rating featured.' : 'Rating unfeatured.');
    }

    public function destroy(AppRating $rating)
    {
        $rating->delete();

        return back()->with('success', 'Rating deleted.');
    }
}
