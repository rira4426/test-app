<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register-mobile', [UserController::class, 'RegisterMobile']);
Route::get('/set-pin', [UserController::class, 'SetPin']);