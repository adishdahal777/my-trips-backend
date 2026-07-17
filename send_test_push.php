<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$token = 'eEbmCc3x_k6cpa8xJZxw_0:APA91bG1Z55DhTo7t4-QVTY56oumcxZ8rY4BUXV5SC9SaDCeA3d357fM9_meBKdFkTN5jjObFZdPrHbcBbwKFw3s04TMNJnXvRw7yeVQbbgRMKbH0TsDjf8';

$credentials = config('services.firebase.credentials');
$messaging = (new \Kreait\Firebase\Factory)
    ->withServiceAccount($credentials)
    ->createMessaging();

$message = \Kreait\Firebase\Messaging\CloudMessage::new()
    ->withToken($token)
    ->withNotification(\Kreait\Firebase\Messaging\Notification::create(
        'MyTrips Test',
        'This is a manual test notification from the MyTrips backend!'
    ))
    ->withData([
        'type' => 'test',
        'trip_id' => '0',
        'screen' => 'Dashboard',
    ]);

try {
    $report = $messaging->send($message);
    echo "✅ Notification sent successfully!\n";
    echo "Message ID: " . $report['messageId'] . "\n";
} catch (\Throwable $e) {
    echo "❌ Error: " . get_class($e) . ": " . $e->getMessage() . "\n";
}
