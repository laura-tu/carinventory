<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\PartsController;

Route::get('/', function () {
    return view('welcome');
});

//Cars endpoint
Route::get('/cars',[CarsController::class,'index']);

//Parts endpoint
Route::get('/parts',[PartsController::class,'index']);