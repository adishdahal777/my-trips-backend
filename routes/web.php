<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DestinationController as AdminDestinationController;
use App\Http\Controllers\Admin\LandingContentController;
use App\Http\Controllers\Admin\RatingController as AdminRatingController;
use App\Http\Controllers\Admin\TripController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use App\Models\Trip;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index']);

Route::get('/u/{user}', [ProfileController::class, 'show'])->name('profile.show');

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

        Route::get('landing', [LandingContentController::class, 'index'])->name('landing.index');
        Route::put('landing/sections', [LandingContentController::class, 'updateSections'])->name('landing.sections.update');
        Route::post('landing/feature-cards', [LandingContentController::class, 'storeFeatureCard'])->name('landing.feature-cards.store');
        Route::put('landing/feature-cards/{featureCard}', [LandingContentController::class, 'updateFeatureCard'])->name('landing.feature-cards.update');
        Route::delete('landing/feature-cards/{featureCard}', [LandingContentController::class, 'destroyFeatureCard'])->name('landing.feature-cards.destroy');
        Route::post('landing/process-steps', [LandingContentController::class, 'storeProcessStep'])->name('landing.process-steps.store');
        Route::put('landing/process-steps/{processStep}', [LandingContentController::class, 'updateProcessStep'])->name('landing.process-steps.update');
        Route::delete('landing/process-steps/{processStep}', [LandingContentController::class, 'destroyProcessStep'])->name('landing.process-steps.destroy');

        Route::get('destinations', [AdminDestinationController::class, 'index'])->name('destinations.index');
        Route::post('destinations', [AdminDestinationController::class, 'store'])->name('destinations.store');
        Route::put('destinations/{destination}', [AdminDestinationController::class, 'update'])->name('destinations.update');
        Route::patch('destinations/{destination}/approve', [AdminDestinationController::class, 'approve'])->name('destinations.approve');
        Route::patch('destinations/{destination}/reject', [AdminDestinationController::class, 'reject'])->name('destinations.reject');
        Route::patch('destinations/{destination}/toggle-featured', [AdminDestinationController::class, 'toggleFeatured'])->name('destinations.toggle-featured');
        Route::delete('destinations/{destination}', [AdminDestinationController::class, 'destroy'])->name('destinations.destroy');

        Route::get('ratings', [AdminRatingController::class, 'index'])->name('ratings.index');
        Route::patch('ratings/{rating}/toggle-featured', [AdminRatingController::class, 'toggleFeatured'])->name('ratings.toggle-featured');
        Route::delete('ratings/{rating}', [AdminRatingController::class, 'destroy'])->name('ratings.destroy');
    });
});
