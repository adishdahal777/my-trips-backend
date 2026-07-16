<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $destinations = Destination::with('creator')
            ->when($request->status, fn ($q, $status) => $q->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('admin.destinations.index', [
            'destinations' => $destinations,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'flag' => ['nullable', 'string', 'max:10'],
            'cover_image' => ['nullable', 'url'],
            'trip_count' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        Destination::create([
            ...$data,
            'is_featured' => $request->boolean('is_featured'),
            'status' => 'approved',
        ]);

        return back()->with('success', 'Destination added.');
    }

    public function update(Request $request, Destination $destination)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'flag' => ['nullable', 'string', 'max:10'],
            'cover_image' => ['nullable', 'url'],
            'trip_count' => ['nullable', 'integer', 'min:0'],
        ]);

        $destination->update($data);

        return back()->with('success', 'Destination updated.');
    }

    public function approve(Destination $destination)
    {
        $destination->update(['status' => 'approved']);

        return back()->with('success', 'Destination approved.');
    }

    public function reject(Destination $destination)
    {
        $destination->update(['status' => 'rejected']);

        return back()->with('success', 'Destination rejected.');
    }

    public function toggleFeatured(Destination $destination)
    {
        $destination->update(['is_featured' => !$destination->is_featured]);

        return back()->with('success', $destination->is_featured ? 'Destination featured.' : 'Destination unfeatured.');
    }

    public function destroy(Destination $destination)
    {
        $destination->delete();

        return back()->with('success', 'Destination deleted.');
    }
}
