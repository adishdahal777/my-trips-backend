<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TripController;
use App\Http\Controllers\Admin\UserController;
use App\Models\Trip;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $publicTrips = Trip::where('visibility', 'public')
        ->where('is_featured', true)
        ->with('user')
        ->latest()
        ->limit(6)
        ->get();

    $totalTrips = Trip::where('visibility', 'public')->count();
    $totalUsers = \App\Models\User::count();

    return view('pages.landing', [
        'publicTrips' => $publicTrips,
        'totalTrips' => $totalTrips,
        'totalUsers' => $totalUsers,
    ]);
});

Route::get('/trip/{trip}', function (Trip $trip) {
    abort_unless($trip->visibility === 'public', 404);

    $trip->load([
        'user',
        'routeStops' => fn ($q) => $q->orderBy('position'),
        'expenses' => fn ($q) => $q->orderByDesc('date'),
        'photos',
        'notes' => fn ($q) => $q->orderByDesc('date'),
        'likes',
        'comments' => fn ($q) => $q->with('user')->latest(),
    ]);

    $trip->setRelation('photos', $trip->privacy_photos ? $trip->photos->where('is_private', false)->values() : collect());
    $trip->setRelation('notes', $trip->privacy_notes ? $trip->notes->where('is_private', false)->values() : collect());
    $trip->setRelation('expenses', $trip->privacy_expenses ? $trip->expenses->where('is_private', false)->values() : collect());

    $expensesByCategory = $trip->expenses->groupBy('category')->map(fn ($items) => [
        'total' => $items->sum('amount'),
        'count' => $items->count(),
    ]);

    return view('pages.trip', [
        'trip' => $trip,
        'expensesByCategory' => $expensesByCategory,
    ]);
})->name('trip.show');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'role:Super Admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', UserController::class);

        Route::get('trips', [TripController::class, 'index'])->name('trips.index');
        Route::patch('trips/{trip}/toggle-featured', [TripController::class, 'toggleFeatured'])->name('trips.toggle-featured');
    });
});
