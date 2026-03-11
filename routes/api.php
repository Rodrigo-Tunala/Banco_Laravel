<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/users', [\App\Http\Controllers\UserController::class, 'store']);

Route::post('/transfers', [\App\Http\Controllers\TransferController::class, 'store']);