<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\StudentApiController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function () {
    return response()->json(['message' => 'API is working']);
});

// Route::get('/students', [StudentApiController::class, 'index']);

Route::prefix('students')->group(function () {
    Route::get('/', [StudentApiController::class, 'index']);
    Route::get('/{id}', [StudentApiController::class, 'show']);
    Route::post('/', [StudentApiController::class, 'store']);
    Route::put('/{id}', [StudentApiController::class, 'update']);
    Route::delete('/{id}', [StudentApiController::class, 'destroy']);
});
