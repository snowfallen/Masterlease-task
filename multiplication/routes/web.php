<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MultiplicationTableController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('table', MultiplicationTableController::class);
