<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('save', [TaskController::class, 'save']);

Route::get('get-all-tasks', [TaskController::class, 'get']);

Route::patch('update/{id}', [TaskController::class, 'update']);

Route::delete('delete/{id}', [TaskController::class, 'delete']);
