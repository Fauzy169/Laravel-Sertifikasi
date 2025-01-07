<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificateController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/certificate', [CertificateController::class, 'index'])->name('certificate.index');
Route::post('/certificate', [CertificateController::class, 'store'])->name('certificate.store');
Route::get('/certificate/generate/{id}', [CertificateController::class, 'generate'])->name('certificate.generate');
