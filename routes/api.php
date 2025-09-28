<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\QueryBuilderApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Query Builder API Examples
Route::middleware(['auth:sanctum'])->prefix('query-builder')->group(function () {
    Route::get('/compare-pluck-select', [QueryBuilderApiController::class, 'comparePluckVsSelect']);
    Route::post('/diary/create', [QueryBuilderApiController::class, 'createDiaryEntry']);
    Route::get('/diary/search', [QueryBuilderApiController::class, 'advancedSearch']);
    Route::get('/diary/statistics', [QueryBuilderApiController::class, 'getDiaryStatistics']);
    Route::post('/diary/bulk-operations', [QueryBuilderApiController::class, 'bulkOperations']);
});