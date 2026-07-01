<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\PhotoController;
use App\Http\Controllers\Api\PublicController;
use App\Http\Controllers\Api\TripController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::prefix('auth')->group(function () {
    Route::post('/otp/send', [AuthController::class, 'sendOTP']);
    Route::post('/otp/verify', [AuthController::class, 'verifyOTP']);
});

// Public routes
Route::get('/feed', [PublicController::class, 'index']);
Route::get('/public-trips/{trip}', [PublicController::class, 'show']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return new UserResource($request->user()->load('profile'));
    });

    Route::get('/profile', [UserProfileController::class, 'show']);
    Route::post('/profile', [UserProfileController::class, 'update']);
    Route::post('/profile/avatar', [UserProfileController::class, 'uploadAvatar']);

    Route::post('/uploads/image', [UploadController::class, 'store']);

    Route::apiResource('trips', TripController::class);

    Route::post('/trips/{trip}/expenses', [ExpenseController::class, 'store']);
    Route::match(['put', 'patch'], '/trips/{trip}/expenses/{expense}', [ExpenseController::class, 'update']);
    Route::delete('/trips/{trip}/expenses/{expense}', [ExpenseController::class, 'destroy']);

    Route::post('/trips/{trip}/photos', [PhotoController::class, 'store']);
    Route::match(['put', 'patch'], '/trips/{trip}/photos/{photo}', [PhotoController::class, 'update']);
    Route::delete('/trips/{trip}/photos/{photo}', [PhotoController::class, 'destroy']);

    Route::post('/trips/{trip}/notes', [NoteController::class, 'store']);
    Route::match(['put', 'patch'], '/trips/{trip}/notes/{note}', [NoteController::class, 'update']);
    Route::delete('/trips/{trip}/notes/{note}', [NoteController::class, 'destroy']);

    Route::post('/trips/{trip}/like', [LikeController::class, 'toggle']);
    Route::post('/trips/{trip}/comments', [CommentController::class, 'store']);
});
