<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\BookBorrowController;
use App\Http\Controllers\BookReturnController;

Route::apiResources([
    'user' => UserController::class,
    'kelas' => GradeController::class,
    'siswa' => StudentController::class,
    'buku' => BookController::class,
    // Need to testing below
    'pinjam' => BookBorrowController::class,
    'kembali' => BookReturnController::class,
    // Need to testing above
]);

// Upload Image Route
Route::post('/buku/updatecover/{id}', [BookController::class, 'updateimage'])->name('buku.updateimage');
