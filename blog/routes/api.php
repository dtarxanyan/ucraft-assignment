<?php

use App\Http\Controllers\CreatePostController;
use App\Http\Controllers\DeletePostController;
use App\Http\Controllers\UpdatePostController;
use Illuminate\Support\Facades\Route;

Route::post("posts", CreatePostController::class);
Route::patch("posts/{post}", UpdatePostController::class);
Route::delete("posts/{post}", DeletePostController::class);
