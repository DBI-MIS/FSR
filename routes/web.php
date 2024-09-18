<?php

use App\Exports\FsrExport;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\DownloadPdfController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Maatwebsite\Excel\Facades\Excel;

// Route::get('/project/{record}/equipments', [ProjectController::class, 'viewEquipments'])->name('projects.equipments');





// Route::get('/fsr/{id}/download-pdf', [DownloadPdfController::class, '__invoke'])->name('fsr.downloadPdf');

// Route::middleware('guest')->group(function () {
//     Volt::route('register', 'pages.auth.register')
//         ->name('register');

//     Volt::route('login', 'pages.auth.login')
//         ->name('login');

//     Volt::route('forgot-password', 'pages.auth.forgot-password')
//         ->name('password.request');

//     Volt::route('reset-password/{token}', 'pages.auth.reset-password')
//         ->name('password.reset');
// });

// Route::middleware('auth')->group(function () {
//     Volt::route('verify-email', 'pages.auth.verify-email')
//         ->name('verification.notice');

//     Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
//         ->middleware(['signed', 'throttle:6,1'])
//         ->name('verification.verify');

//     Volt::route('confirm-password', 'pages.auth.confirm-password')
//         ->name('password.confirm');
// });
