<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $trips = Trip::with('user')
            ->when($request->search, function ($q, $search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('destination', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
            })
            ->when($request->status, fn ($q, $status) => $q->where('status', $status))
            ->when($request->visibility, fn ($q, $vis) => $q->where('visibility', $vis))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.trips.index', [
            'trips' => $trips,
        ]);
    }

    public function toggleFeatured(Trip $trip)
    {
        $trip->update(['is_featured' => !$trip->is_featured]);

        return back()->with('success', $trip->is_featured
            ? 'Trip marked as featured.'
            : 'Trip removed from featured.');
    }
}
