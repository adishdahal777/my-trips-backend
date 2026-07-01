<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TripResource;
use App\Models\Note;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    private function freshTrip(Trip $trip): TripResource
    {
        return new TripResource(
            $trip->fresh(['routeStops', 'expenses', 'photos', 'notes', 'user.profile'])
                ->loadCount(['likes', 'comments'])
        );
    }

    public function store(Request $request, Trip $trip)
    {
        abort_unless($trip->user_id === $request->user()->id, 403);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'mood' => 'nullable|string|max:10',
            'date' => 'required|date',
            'color' => 'nullable|string|max:20',
            'isPrivate' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $trip->notes()->create([
            'title' => $request->title,
            'body' => $request->body,
            'mood' => $request->mood,
            'date' => $request->date,
            'color' => $request->color,
            'is_private' => $request->boolean('isPrivate'),
        ]);

        return $this->freshTrip($trip);
    }

    public function update(Request $request, Trip $trip, Note $note)
    {
        abort_unless($trip->user_id === $request->user()->id, 403);
        abort_unless($note->trip_id === $trip->id, 404);

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'body' => 'sometimes|string',
            'mood' => 'sometimes|nullable|string|max:10',
            'date' => 'sometimes|date',
            'color' => 'sometimes|nullable|string|max:20',
            'isPrivate' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $map = ['title' => 'title', 'body' => 'body', 'mood' => 'mood', 'date' => 'date', 'color' => 'color'];
        $updates = [];
        foreach ($map as $input => $column) {
            if ($request->has($input)) {
                $updates[$column] = $request->input($input);
            }
        }
        if ($request->has('isPrivate')) {
            $updates['is_private'] = $request->boolean('isPrivate');
        }

        $note->update($updates);

        return $this->freshTrip($trip);
    }

    public function destroy(Request $request, Trip $trip, Note $note)
    {
        abort_unless($trip->user_id === $request->user()->id, 403);
        abort_unless($note->trip_id === $trip->id, 404);

        $note->delete();

        return $this->freshTrip($trip);
    }
}
