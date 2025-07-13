<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\StudentApiController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function () {
    return response()->json(['message' => 'API is working']);
});

Route::get('/students', [StudentApiController::class, 'index']);
