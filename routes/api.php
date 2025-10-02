<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Container\Attributes\Auth;

Route::apiResource('books', \App\Http\Controllers\Api\BooksController::class)->middleware('auth:sanctum');

Route::post('register', [\App\Http\Controllers\Api\UserController::class, 'register']);


// Route::get('/restricted', function () {
//     return response()->json(['message' => 'The Token has been tampered.']);
// })->middleware('EnsureTokenIsValid');

// INDIO WAYAT COORDINATES :: 12°53'05.1"N 124°05'35.8"E INDIO WAYAT COORDINATES//


// Route::post('login', [\App\Http\Controllers\Api\UserController::class, 'login']);
// Route::post('logout', [\App\Http\Controllers\Api\UserController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
