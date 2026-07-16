<?php

namespace App\Jobs;

use App\Models\AppNotification;
use App\Models\User;
use App\Services\PushService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendNotification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $userId,
        public ?int $actorId,
        public string $type,
        public ?int $tripId,
        public string $title,
        public string $body,
    ) {}

    public function handle(PushService $push): void
    {
        $user = User::find($this->userId);

        if (! $user) {
            return;
        }

        AppNotification::create([
            'user_id' => $this->userId,
            'actor_id' => $this->actorId,
            'trip_id' => $this->tripId,
            'type' => $this->type,
        ]);

        $push->send($user, $this->title, $this->body, [
            'type' => $this->type,
            'tripId' => $this->tripId,
            'actorId' => $this->actorId,
        ]);
    }
}
