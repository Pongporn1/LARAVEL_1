<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SocialMediaLinkController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiaryEntryController;
use App\Http\Controllers\ReminderController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Profile photo
    Route::patch('/profile/photo/update', [UserController::class, 'updateProfilePhoto'])
        ->name('profile.photo.update');
    Route::get('/profile/photo/{filename}', [UserController::class, 'showProfilePhoto'])
        ->where('filename', '.*')
        ->name('user.photo');

    // Social Media Links (CRUD) — align route param with authorizeResource('social_link')
    Route::resource('social-links', SocialMediaLinkController::class)
        ->parameters(['social-links' => 'social_link']);

    // User Bio (1:1)
    Route::get('/profile/bio',   [UserController::class, 'showBio'])->name('profile.show-bio');
    Route::patch('/profile/bio', [UserController::class, 'updateBio'])->name('profile.update-bio');


    // Diary Entries (CRUD)
     Route::resource('diary', DiaryEntryController::class);

    // Reminders (CRUD)
    Route::resource('reminders', ReminderController::class);

});

require __DIR__.'/auth.php';
