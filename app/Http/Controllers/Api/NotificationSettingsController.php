<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NotificationPreference;
use Illuminate\Http\Request;

class NotificationSettingsController extends Controller
{
    public function show(Request $request)
    {
        $pref = $request->user()->notificationPreference;

        return response()->json(['data' => $this->transform($pref)]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'newFollower' => 'sometimes|boolean',
            'tripLiked' => 'sometimes|boolean',
            'tripCommented' => 'sometimes|boolean',
            'followedUserTrip' => 'sometimes|boolean',
        ]);

        $map = [
            'newFollower' => 'new_follower',
            'tripLiked' => 'trip_liked',
            'tripCommented' => 'trip_commented',
            'followedUserTrip' => 'followed_user_trip',
        ];

        $updates = [];
        foreach ($map as $input => $column) {
            if (array_key_exists($input, $data)) {
                $updates[$column] = $data[$input];
            }
        }

        $pref = NotificationPreference::updateOrCreate(
            ['user_id' => $request->user()->id],
            $updates
        );

        return response()->json(['data' => $this->transform($pref)]);
    }

    private function transform(?NotificationPreference $pref): array
    {
        return [
            'newFollower' => $pref?->new_follower ?? true,
            'tripLiked' => $pref?->trip_liked ?? true,
            'tripCommented' => $pref?->trip_commented ?? true,
            'followedUserTrip' => $pref?->followed_user_trip ?? true,
        ];
    }
}
