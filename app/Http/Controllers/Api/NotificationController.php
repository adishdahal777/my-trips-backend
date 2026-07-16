<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()->appNotifications()
            ->with(['actor.profile', 'trip'])
            ->latest()
            ->paginate(20);

        return response()->json([
            'data' => $notifications->getCollection()->map(fn (AppNotification $n) => [
                'id' => (string) $n->id,
                'type' => $n->type,
                'actor' => $n->actor ? [
                    'id' => (string) $n->actor->id,
                    'name' => $n->actor->name,
                    'avatar' => $n->actor->profile?->avatar ?? UserProfile::DEFAULT_AVATAR,
                ] : null,
                'trip' => $n->trip ? ['id' => (string) $n->trip->id, 'name' => $n->trip->name] : null,
                'readAt' => $n->read_at?->toISOString(),
                'createdAt' => $n->created_at->toISOString(),
            ]),
            'unreadCount' => $request->user()->appNotifications()->whereNull('read_at')->count(),
            'meta' => [
                'currentPage' => $notifications->currentPage(),
                'lastPage' => $notifications->lastPage(),
                'total' => $notifications->total(),
            ],
        ]);
    }

    public function markRead(Request $request, AppNotification $notification)
    {
        abort_unless($notification->user_id === $request->user()->id, 403);

        $notification->update(['read_at' => now()]);

        return response()->json(['message' => 'Marked as read.']);
    }

    public function markAllRead(Request $request)
    {
        $request->user()->appNotifications()->whereNull('read_at')->update(['read_at' => now()]);

        return response()->json(['message' => 'All marked as read.']);
    }
}
