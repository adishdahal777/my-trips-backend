<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TripResource;
use App\Models\Expense;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
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
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'currency' => 'nullable|string|max:3',
            'date' => 'required|date',
            'category' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
            'aiSuggested' => 'nullable|boolean',
            'isPrivate' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        DB::transaction(function () use ($request, $trip) {
            $trip->expenses()->create([
                'description' => $request->description,
                'amount' => $request->amount,
                'currency' => $request->input('currency', $trip->currency),
                'date' => $request->date,
                'category' => $request->category,
                'icon' => $request->icon,
                'ai_suggested' => $request->boolean('aiSuggested'),
                'is_private' => $request->boolean('isPrivate'),
            ]);

            $trip->increment('spent', $request->amount);
        });

        return $this->freshTrip($trip);
    }

    public function update(Request $request, Trip $trip, Expense $expense)
    {
        abort_unless($trip->user_id === $request->user()->id, 403);
        abort_unless($expense->trip_id === $trip->id, 404);

        if ($request->has('isPrivate')) {
            $expense->update(['is_private' => $request->boolean('isPrivate')]);
        }

        return $this->freshTrip($trip);
    }

    public function destroy(Request $request, Trip $trip, Expense $expense)
    {
        abort_unless($trip->user_id === $request->user()->id, 403);
        abort_unless($expense->trip_id === $trip->id, 404);

        DB::transaction(function () use ($trip, $expense) {
            $trip->decrement('spent', $expense->amount);
            $expense->delete();
        });

        return $this->freshTrip($trip);
    }
}
