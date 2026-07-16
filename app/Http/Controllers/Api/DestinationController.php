<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::where('status', 'approved')
            ->orderByDesc('is_featured')
            ->orderByDesc('trip_count')
            ->get();

        return response()->json([
            'data' => $destinations->map(fn (Destination $d) => $this->transform($d)),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'flag' => ['nullable', 'string', 'max:10'],
            'cover_image' => ['nullable', 'string'],
        ]);

        $destination = Destination::create([
            ...$data,
            'created_by' => $request->user()->id,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Destination submitted for review.',
            'data' => $this->transform($destination),
        ], 201);
    }

    private function transform(Destination $d): array
    {
        return [
            'id' => (string) $d->id,
            'name' => $d->name,
            'country' => $d->country,
            'flag' => $d->flag,
            'coverImage' => $d->cover_image,
            'tripCount' => $d->trip_count,
            'isFeatured' => $d->is_featured,
            'status' => $d->status,
        ];
    }
}
