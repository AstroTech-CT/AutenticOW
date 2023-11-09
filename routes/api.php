<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::prefix('v1')->group(function (){

    Route::post('/register',[UserController::class,"Register"]);
    Route::post('/login', [UserController::class, 'login']);
    Route::middleware('auth:api')->get('/user', 'UserController@getUser');
    Route::get('/logout',[UserController::class,"Logout"])->middleware('auth:api');
});

