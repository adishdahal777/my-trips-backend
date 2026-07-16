<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\MulticastSendReport;
use Kreait\Firebase\Messaging\Notification;

class PushService
{
    public function send(User $user, string $title, string $body, array $data = []): void
    {
        $tokens = $user->deviceTokens()->pluck('token')->all();

        if (empty($tokens)) {
            return;
        }

        $credentials = config('services.firebase.credentials');

        if (empty($credentials)) {
            Log::info('Push skipped (no FIREBASE_CREDENTIALS configured)', ['user_id' => $user->id, 'title' => $title]);

            return;
        }

        $messaging = (new Factory)->withServiceAccount($credentials)->createMessaging();

        $message = CloudMessage::new()
            ->withNotification(Notification::create($title, $body))
            ->withData(array_map('strval', $data));

        /** @var MulticastSendReport $report */
        $report = $messaging->sendMulticast($message, $tokens);

        foreach ($report->invalidTokens() as $invalidToken) {
            $user->deviceTokens()->where('token', $invalidToken)->delete();
        }
    }
}
