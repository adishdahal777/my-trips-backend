<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use App\Models\TripView;
use Illuminate\Http\Request;

/**
 * Heuristic recommendation engine — rule-based content scoring, no ML/training.
 * Builds a frequency profile from the user's own trips (strong signal, 2x weight)
 * and their view history (weaker signal, 1x weight), then ranks public trips by a
 * hand-weighted sum of: destination-country affinity, style affinity (purpose/pace/food),
 * popularity, and recency.
 */
class RecommendationController extends Controller
{
    private const WEIGHTS = [
        'country' => 0.35,
        'purpose' => 0.25,
        'pace' => 0.15,
        'food' => 0.10,
        'popularity' => 0.10,
        'recency' => 0.05,
    ];

    private function countryOf(string $destination): string
    {
        $parts = array_map('trim', explode(',', $destination));

        return end($parts) ?: $destination;
    }

    private function normalize(array $counts): array
    {
        $max = max(1, ...array_values($counts) ?: [1]);

        return array_map(fn ($v) => $v / $max, $counts);
    }

    private function bump(array &$freq, ?string $key, int $amount): void
    {
        if (!$key) {
            return;
        }
        $freq[$key] = ($freq[$key] ?? 0) + $amount;
    }

    private function popularityScore(int $likes): float
    {
        return min(1, log10($likes + 1) / 3);
    }

    private function recencyScore(?string $createdAt): float
    {
        if (!$createdAt) {
            return 0;
        }
        $days = now()->diffInDays($createdAt);

        return max(0, 1 - $days / 180);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $limit = (int) $request->input('limit', 6);

        $ownTrips = Trip::where('user_id', $user->id)->get(['destination', 'pref_purpose', 'pref_pace', 'pref_food_priority']);

        $history = TripView::where('user_id', $user->id)
            ->with('trip:id,destination,pref_purpose,pref_pace,pref_food_priority')
            ->latest()
            ->limit(50)
            ->get()
            ->pluck('trip')
            ->filter();

        $country = [];
        $purpose = [];
        $pace = [];
        $food = [];

        foreach ($ownTrips as $t) {
            $this->bump($country, $this->countryOf($t->destination), 2);
            $this->bump($purpose, $t->pref_purpose, 2);
            $this->bump($pace, $t->pref_pace, 2);
            $this->bump($food, $t->pref_food_priority, 2);
        }
        foreach ($history as $t) {
            $this->bump($country, $this->countryOf($t->destination), 1);
            $this->bump($purpose, $t->pref_purpose, 1);
            $this->bump($pace, $t->pref_pace, 1);
            $this->bump($food, $t->pref_food_priority, 1);
        }

        $country = $this->normalize($country);
        $purpose = $this->normalize($purpose);
        $pace = $this->normalize($pace);
        $food = $this->normalize($food);

        $candidates = Trip::where('visibility', 'public')
            ->where('user_id', '!=', $user->id)
            ->with(['routeStops', 'expenses', 'photos', 'notes', 'user.profile'])
            ->withCount(['likes', 'comments'])
            ->limit(200)
            ->get();

        $scored = $candidates->map(function (Trip $trip) use ($country, $purpose, $pace, $food) {
            $c = $this->countryOf($trip->destination);
            $countryScore = $country[$c] ?? 0;
            $purposeScore = $purpose[$trip->pref_purpose] ?? 0;
            $paceScore = $pace[$trip->pref_pace] ?? 0;
            $foodScore = $food[$trip->pref_food_priority] ?? 0;
            $popScore = $this->popularityScore($trip->likes_count ?? 0);
            $recScore = $this->recencyScore($trip->created_at?->toISOString());

            $score = self::WEIGHTS['country'] * $countryScore
                + self::WEIGHTS['purpose'] * $purposeScore
                + self::WEIGHTS['pace'] * $paceScore
                + self::WEIGHTS['food'] * $foodScore
                + self::WEIGHTS['popularity'] * $popScore
                + self::WEIGHTS['recency'] * $recScore;

            $factors = collect([
                ['label' => "You've explored {$c} before", 'value' => $countryScore * self::WEIGHTS['country']],
                ['label' => 'Matches your '.($trip->pref_purpose ?: 'travel').' style', 'value' => $purposeScore * self::WEIGHTS['purpose']],
                ['label' => 'Fits your '.($trip->pref_pace ?: '').' pace', 'value' => $paceScore * self::WEIGHTS['pace']],
                ['label' => 'Trending with other travelers', 'value' => $popScore * self::WEIGHTS['popularity']],
            ])->sortByDesc('value')->first();

            $reason = $factors['value'] > 0 ? $factors['label'] : 'Popular with other travelers';

            return ['trip' => $trip, 'score' => $score, 'reason' => $reason];
        })
            ->sortByDesc('score')
            ->take($limit)
            ->values();

        return response()->json([
            'data' => $scored->map(fn ($r) => [
                'trip' => new TripResource($r['trip']),
                'score' => round($r['score'], 4),
                'reason' => $r['reason'],
            ]),
        ]);
    }
}
