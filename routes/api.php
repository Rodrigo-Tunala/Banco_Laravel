<?php

use App\Http\Controllers\TransferController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/users', [UserController::class, 'store']);

Route::post('/transfers', [TransferController::class, 'store']);

Route::get('/user/{id}', [UserController::class, 'show']);