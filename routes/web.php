<?php

use App\Models\CategoryService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sitemap.xml', [SitemapController::class, 'generateSitemap']);

Route::get('/home', [HomeController::class, 'home'])->name('home');

Route::get('/loginForm', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register-client-form', [AuthController::class, 'showRegistrationFormClient'])->name('register.client.form');
Route::post('/register-client', [AuthController::class, 'registerClient'])->name('register.client');
Route::get('/register-Technicien-form', [AuthController::class, 'showRegistrationFormTechnicien'])->name('register.Technicien.form');
Route::post('/register-Technicien', [AuthController::class, 'registerTechnicien'])->name('register.Technicien');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register-information-Technicien-form', [AuthController::class, 'showRegistrationFormTechnicien'])->name('register.information.Technicien.form');
Route::post('/register-information-Technicien', [AuthController::class, 'registerTechnicien'])->name('register.information.Technicien');

// profile

Route::get('/profile', [UserController::class, 'profile'])->name('profile.form');
Route::put('/profile/update/{id}', [UserController::class, 'update'])->name('profile.update');
Route::get('/details/{id}', [UserController::class, 'InformationTechnician'])->name('technician.details');
Route::post('/store-review', [UserController::class, 'storeAvis'])->name('store.review');

// categories 


Route::resource('categories', CategoryController::class);

