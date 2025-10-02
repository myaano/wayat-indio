<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Container\Attributes\Auth;

Route::apiResource('books', \App\Http\Controllers\Api\BooksController::class)->middleware('auth:sanctum');

Route::post('register', [\App\Http\Controllers\Api\UserController::class, 'register']);



// Route::get('/restricted', function () {
//     return response()->json(['message' => 'The Token has been tampered.']);
// })->middleware('EnsureTokenIsValid');



// Route::post('login', [\App\Http\Controllers\Api\UserController::class, 'login']);
// Route::post('logout', [\App\Http\Controllers\Api\UserController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
