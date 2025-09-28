<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SocialMediaLinkController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiaryEntryController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\QueryBuilderController;

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

    // Query Builder Examples
    Route::prefix('query-builder')->name('query-builder.')->group(function () {
        Route::get('/', function () {
            return view('query-builder.index');
        })->name('index');
        Route::get('/comparison', function () {
            return view('query-builder.comparison');
        })->name('comparison');
        // Basic operations
        Route::get('diary/display', [QueryBuilderController::class, 'display_diary'])->name('display-diary');
        Route::get('diary/contents', [QueryBuilderController::class, 'get_diary_contents'])->name('contents');
        Route::get('diary/titles-dropdown', [QueryBuilderController::class, 'get_diary_titles_for_dropdown'])->name('titles-dropdown');
        Route::get('diary/sorted', [QueryBuilderController::class, 'get_sorted_diary'])->name('sorted');
        Route::get('diary/count', [QueryBuilderController::class, 'count_diary_entries'])->name('count');
        Route::get('diary/statistics', [QueryBuilderController::class, 'diary_statistics'])->name('statistics');
        
        // CRUD operations
        Route::post('diary/store', [QueryBuilderController::class, 'store_diary_entry'])->name('store');
        Route::put('diary/{id}/update', [QueryBuilderController::class, 'update_diary_entry'])->name('update');
        Route::delete('diary/{id}/delete', [QueryBuilderController::class, 'delete_diary_entry'])->name('delete');
        
        // Search and filtering
        Route::get('diary/search/{keyword}', [QueryBuilderController::class, 'search_diary'])->name('search');
        Route::get('diary/filtered', [QueryBuilderController::class, 'get_filtered_entries'])->name('filtered');
        
        // Joins and relationships
        Route::get('entries/with-users', [QueryBuilderController::class, 'get_entries_with_users'])->name('with-users');
        Route::get('diary/happy-count', [QueryBuilderController::class, 'count_happy_diary'])->name('happy-count');
        Route::get('entries/with-tags', [QueryBuilderController::class, 'get_entries_with_tags'])->name('with-tags');
        
        // Pagination and distinct
        Route::get('diary/paginated', [QueryBuilderController::class, 'get_paginated_diary'])->name('paginated');
        Route::get('diary/unique-dates', [QueryBuilderController::class, 'get_unique_diary_dates'])->name('unique-dates');
        
        // Aggregations and raw expressions
        Route::get('diary/daily-count', [QueryBuilderController::class, 'get_daily_entry_count'])->name('daily-count');
        Route::get('diary/count-between', [QueryBuilderController::class, 'get_diary_count_between'])->name('count-between');
        Route::get('users/prolific', [QueryBuilderController::class, 'get_prolific_users'])->name('prolific-users');
        Route::get('diary/date-range/{startDate}/{endDate}', [QueryBuilderController::class, 'get_entries_by_date_range'])->name('date-range');
        
        // Advanced queries
        Route::get('emotions/statistics', [QueryBuilderController::class, 'get_emotion_statistics'])->name('emotion-stats');
        Route::get('diary/monthly-summary', [QueryBuilderController::class, 'get_monthly_summary'])->name('monthly-summary');
        Route::get('users/latest-entry', [QueryBuilderController::class, 'get_users_with_latest_entry'])->name('users-latest');
        
        // Dropdowns and utilities
        Route::get('tags/dropdown', [QueryBuilderController::class, 'get_tags_for_dropdown'])->name('tags-dropdown');
        
        // Transactions
        Route::post('diary/with-emotions', [QueryBuilderController::class, 'create_entry_with_emotions_transaction'])->name('with-emotions');
        
        // Practice Exercise - Emotion Summary
        Route::get('diary/emotion-summary', [QueryBuilderController::class, 'get_emotion_summary'])->name('emotion-summary');
        
        // Lab Task - Conflicting Emotions
        Route::get('diary/conflicting-emotions', [QueryBuilderController::class, 'get_conflicting_emotions'])->name('conflicting-emotions');
        Route::get('diary/conflicting-emotions-api', [QueryBuilderController::class, 'get_conflicting_emotions_api'])->name('conflicting-emotions-api');
    });

});

require __DIR__.'/auth.php';
