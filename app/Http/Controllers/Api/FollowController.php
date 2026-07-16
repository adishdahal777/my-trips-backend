<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PublicUserResource;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function toggle(Request $request, User $user)
    {
        abort_if($user->id === $request->user()->id, 422, 'Cannot follow yourself.');

        $follow = Follow::where('follower_id', $request->user()->id)
            ->where('followee_id', $user->id)
            ->first();

        if ($follow) {
            $follow->delete();
            $following = false;
        } else {
            try {
                Follow::create(['follower_id' => $request->user()->id, 'followee_id' => $user->id]);
            } catch (QueryException) {
                // race — already followed
            }
            $following = true;
        }

        return response()->json([
            'following' => $following,
            'followers' => $user->followers()->count(),
        ]);
    }

    public function followers(User $user)
    {
        $followers = $user->followers()->with('follower.profile')->latest()->paginate(20);

        return response()->json([
            'data' => PublicUserResource::collection($followers->through(fn ($f) => $f->follower)),
            'meta' => [
                'currentPage' => $followers->currentPage(),
                'lastPage' => $followers->lastPage(),
                'total' => $followers->total(),
            ],
        ]);
    }

    public function following(User $user)
    {
        $following = $user->following()->with('followee.profile')->latest()->paginate(20);

        return response()->json([
            'data' => PublicUserResource::collection($following->through(fn ($f) => $f->followee)),
            'meta' => [
                'currentPage' => $following->currentPage(),
                'lastPage' => $following->lastPage(),
                'total' => $following->total(),
            ],
        ]);
    }

    public function show(Request $request, User $user)
    {
        $user->loadCount(['followers', 'following']);

        return (new PublicUserResource($user->load('profile')))->additional([
            'isFollowing' => $request->user()
                ? Follow::where('follower_id', $request->user()->id)->where('followee_id', $user->id)->exists()
                : false,
        ]);
    }
}
