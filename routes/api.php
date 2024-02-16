<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| To Do List
|--------------------------------------------------------------------------
|
| Don't forget to update policies requests at '@/app/Http/Request'.
|
| Endpoint Services Must Be Done:
| - [x] Docs
| - [x] Auth
| - [x] Grade
| - [x] Student
| - [x] Book
| - [ ] Book Borrow
| - [ ] Book Return
| - [ ] Detail Book Borrow
| - [ ] Comments
|
*/

/*
|--------------------------------------------------------------------------
| Example Route
|--------------------------------------------------------------------------
|
| Route::post('/kelas', [GradeController::class, 'store']);
|
| Route::apiResource('/kelas', GradeController::class);
|
| Route::prefix('auth')->group(function () {
|   Route::post('/login', [AuthController::class, 'login']);
|   Route::post('/register', [AuthController::class, 'register']);
|
|   // Protected Routes (Need Token)
|   Route::get('/refresh', [AuthController::class, 'refresh']);
|   Route::get('/user', [AuthController::class, 'user']);
|   Route::put('/update', [AuthController::class, 'update']);
|   Route::post('/logout', [AuthController::class, 'logout']);
| });
|
| Route::apiResources([
|     'kelas' => GradeController::class,
|     'siswa' => StudentController::class,
|     'buku' => BookController::class,
|     'pinjam' => BookBorrowController::class,
|     'buku-kembali' => BookReturnController::class
| ]);
|
*/

Route::prefix('v1')->group(function () {
    require __DIR__ . '/endpoint/docs.php'; // Docs
    require __DIR__ . '/endpoint/auth/auth.php'; // Auth Endpoint (Protected)
    require __DIR__ . '/endpoint/main.php'; // Main Endpoint (Protected)
});
