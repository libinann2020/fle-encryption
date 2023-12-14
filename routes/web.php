<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FileController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/upload', [FileController::class, 'upload'])->name('file.upload');
Route::get('/files', [FileController::class, 'showFiles'])->name('file.list');
Route::get('/download/{fileName}', [FileController::class, 'download'])->name('file.download');
