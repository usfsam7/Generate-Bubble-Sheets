<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;

Route::get('/', function () {
    return view('upload');
});



Route::get('/upload', function () {
    return view('upload');
});


Route::post('/upload', [ExcelController::class, 'upload'])->name('upload.excel');
