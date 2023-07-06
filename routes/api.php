<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::prefix('v1')->group(function ()
{
    Route::post('/user',[UserController::class,"Register"]);
    Route::post('/login', [UserController::class, 'login']);
    Route::get('/validate',[UserController::class,"ValidateToken"])->middleware('auth:api');
    Route::get('/logout',[UserController::class,"Logout"])->middleware('auth:api');


});
