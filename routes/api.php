<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('save', [TaskController::class, 'save']);

// Route::get('get-all-tasks', [TaskController::class, 'get']);

// Route::patch('update/{id}', [TaskController::class, 'update']);

// Route::delete('delete/{id}', [TaskController::class, 'delete']);

Route::controller(LoginController::class)->group(function() {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout', [LoginController::class, 'logout']);

    Route::controller(TaskController::class)->group(function() {
        Route::post('/save', 'save');
        Route::get('/get', 'get');
        Route::patch('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'delete');
    });
});
