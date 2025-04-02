<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('register/{invitation}', function ($invitation) {
    return view('register', ['invitation' => $invitation]);
})->middleware('signed')->name('register.show');
Route::post('register/{invitation}', [AuthController::class, 'register'])->name('register.store');
