<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V2\AuthController;
use App\Http\Controllers\Api\V2\PlatformGroupController;
use App\Http\Controllers\Api\V2\PlatformController;
use App\Http\Controllers\Api\V2\PlatformPositionController;

Route::prefix('auth')->group(function() {
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});
Route::middleware([
    \App\Http\Middleware\PaginateAPI::class,
    'auth:sanctum'
])->group(function() {
    Route::apiResource('ag_platformGroups', PlatformGroupController::class)->parameters([
        'ag_platformGroups' => 'platformGroup'
    ]);
    Route::apiResource('ag_platforms', PlatformController::class)->parameters([
        'ag_platforms' => 'platform'
    ]);
    Route::apiResource('ag_platformPositions', PlatformPositionController::class)->parameters([
        'ag_platformPositions' => 'platformPosition'
    ]);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
