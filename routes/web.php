<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BubbleSheetController;

Route::get('/', function () {
    return view('upload');
});



Route::get('/upload', function () {
    return view('upload');
});


// Route::post('/upload', [ExcelController::class, 'upload'])->name('upload.excel');


Route::get('/', [BubbleSheetController::class, 'showUploadForm'])->name('upload.form');
Route::post('/process-excel', [BubbleSheetController::class, 'processExcel'])->name('process.excel');
