<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
    /**
     * Display the current user's profile.
     */
    public function show(Request $request)
    {
        $user = $request->user();
        $profile = $user->profile ?? [
            'bio' => null,
            'dob' => null,
            'phone' => null,
            'gender' => null,
            'address' => null,
            'nationality' => null,
            'avatar' => UserProfile::DEFAULT_AVATAR,
            'total_trips' => 0,
            'countries' => 0,
            'km_traveled' => 0,
        ];

        return response()->json([
            'profile' => $profile,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'username' => $user->username,
            ]
        ]);
    }

    /**
     * Update or create the current user's profile.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $request->user()->id,
            'bio' => 'nullable|string',
            'dob' => 'nullable|date',
            'phone' => 'nullable|string',
            'gender' => 'nullable|string',
            'address' => 'nullable|string',
            'nationality' => 'nullable|string',
            'avatar' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = $request->user();
        
        // Update User table fields
        if ($request->has('name')) $user->name = $request->name;
        if ($request->has('username')) $user->username = $request->username;
        $user->save();

        $profile = $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $request->only(['bio', 'dob', 'phone', 'gender', 'address', 'nationality', 'avatar'])
        );

        return response()->json([
            'message' => 'Profile updated successfully.',
            'profile' => $profile,
            'user' => $user
        ]);
    }

    /**
     * Upload avatar image.
     */
    public function uploadAvatar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        if ($request->hasFile('avatar')) {
            $user = $request->user();
            $path = $request->file('avatar')->store('avatars', 'public');
            $url = asset('storage/' . $path);

            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                ['avatar' => $url]
            );

            return response()->json([
                'message' => 'Avatar uploaded successfully.',
                'avatar_url' => $url
            ]);
        }

        return response()->json(['error' => 'No image uploaded.'], 400);
    }
}
