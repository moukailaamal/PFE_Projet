<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SitemapController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/sitemap.xml', [SitemapController::class, 'generateSitemap']);
Route::get('/exemple', function () {
    return view('exemple');
});
Route::get('/loginForm', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register-client-form', [AuthController::class, 'showRegistrationFormClient'])->name('register.client.form');
Route::post('/register-client', [AuthController::class, 'registerClient'])->name('register.client');
Route::get('/register-Technicien-form', [AuthController::class, 'showRegistrationFormTechnicien'])->name('register.Technicien.form');
Route::post('/register-Technicien', [AuthController::class, 'registerTechnicien'])->name('register.Technicien');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register-information-Technicien-form', [AuthController::class, 'showRegistrationFormTechnicien'])->name('register.information.Technicien.form');
Route::post('/register-information-Technicien', [AuthController::class, 'registerTechnicien'])->name('register.information.Technicien');