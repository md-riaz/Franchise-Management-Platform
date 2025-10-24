<?php

use App\Http\Controllers\Api\FranchiseController;
use App\Http\Controllers\Api\SalesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Franchise routes
    Route::apiResource('franchises', FranchiseController::class);
    
    // Sales routes
    Route::get('/sales/stats', [SalesController::class, 'stats']);
    Route::apiResource('sales', SalesController::class);
});
