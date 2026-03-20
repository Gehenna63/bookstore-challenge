<?php

use App\Http\Controllers\Api\V1\AuthorController;
use App\Http\Controllers\Api\V1\BookController;
use Illuminate\Support\Facades\Route;

Route::apiResource('authors', AuthorController::class);
//Route::post('/authors', [AuthorController::class, 'store']);
//Route::get('/authors', [AuthorController::class, 'index']);

Route::post('/books', [BookController::class, 'store']);
Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{uuid}', [BookController::class, 'show']);
