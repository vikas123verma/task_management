<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/tasks', TaskController::class);
    Route::put('task/update-status', [TaskController::class, 'updateStatus']);
});


Route::fallback(function (Request $request) {
    return response()->json(['message' => 'API route not found'], 404);
});
