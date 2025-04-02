<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\InvitationController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('password/forgot', [AuthController::class, 'forgotPassword'])->name('password.forgot');
Route::post('password/reset', [AuthController::class, 'resetPassword'])->name('password.reset');

Route::middleware(['auth:sanctum', 'active.user'])->group(function () {
    Route::middleware(['can:admin'])->group(function () {
        Route::apiResource('users', UserController::class)->only(['index', 'update', 'destroy']);
        // Invitations
        Route::post('invitations/send', [InvitationController::class, 'send']);

        Route::delete('reviews/{review}', [ReviewController::class, 'destroy']);
    });
    Route::post('update-profile', [UserController::class, 'updateProfile']);
    // Favorites
    Route::get('favorites', [FavoriteController::class, 'index']);
    Route::post('favorites', [FavoriteController::class, 'store']);
    Route::delete('favorites/{id}', [FavoriteController::class, 'destroy']);
    // Reviews
    Route::post('reviews', [ReviewController::class, 'store']);
    // Movies
    Route::get('movies/{movie}/reviews', [MovieController::class, 'getReviews']);
    Route::get('movies', [MovieController::class, 'index'])->middleware('cache.response');
});
