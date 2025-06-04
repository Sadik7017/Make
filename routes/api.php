<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

// Load HR Module Routes
if (file_exists(base_path('packages/modules/HR/routes/api.php'))) {
    Route::prefix('hr')->group(base_path('packages/modules/HR/routes/api.php'));
} 