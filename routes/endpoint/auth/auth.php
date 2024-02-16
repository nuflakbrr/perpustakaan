<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

$maps = require __DIR__ . '/auth.map.php';

Route::prefix('auth')->group(function () use ($maps) {
    foreach ($maps as $map) {
        Route::{$map[0]}($map[1], [AuthController::class, $map[2]]);
    };
});
