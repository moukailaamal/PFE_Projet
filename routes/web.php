<?php

use App\Models\CategoryService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\CategoryController;

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
// services
Route::resource('services', ServiceController::class);

// reservations 
Route::get('/book/{id}', [BookController::class, 'showBookingDaysForm'])->name('book.days');
Route::get('/book/{id}/{day}', [BookController::class, 'showBookingHoursForm'])->name('book.hours');

Route::post('/book/store', [BookController::class, 'storeReservation'])->name('book.store');
Route::post('/reservation/confirmer', [BookController::class, 'confirmReservation'])->name('reservation.confirm');

Route::get('/confirmation/{id}', [BookController::class, 'confirmation'])->name('book.confirmation');

Route::get('/listAppointments/{id}', [BookController::class, 'listAppointmentsTech'])->name('book.listAppointmentsTech');

Route::get('/listAppointments/tech/{id}', [BookController::class, 'listAppointmentsTech'])->name('book.listAppointmentsTech');
Route::get('/listAppointments/client/{id}', [BookController::class, 'listAppointmentsClient'])->name('book.listAppointmentsClient');
Route::get('/listAppointments/admin/{id}', [BookController::class, 'listAppointmentsAdmin'])->name('book.listAppointmentsAdmin');

Route::put('/reservations/{id}/cancel', [BookController::class, 'canceled'])->name('book.cancel');
Route::put('/reservations/{id}/reactivate', [BookController::class, 'reactivate'])->name('book.reactivate');
Route::put('/reservations/{id}/confirmed', [BookController::class, 'confirmed'])->name('book.confirmed');
Route::put('/reservations/{id}/completed', [BookController::class, 'completed'])->name('book.completed');

// Groupe de routes protégées par auth
Route::middleware(['auth'])->group(function () {
    
    // Page principale du chat
    Route::get('/chat', [MessageController::class, 'index'])
         ->name('chat.index');
    
    // Envoi de message
    Route::post('/send-message', [MessageController::class, 'sendMessage'])
         ->name('chat.send');
    
    // Marquer les messages comme lus
    Route::post('/messages/mark-as-read', [MessageController::class, 'markAsRead'])
         ->name('messages.read');
    
    // Récupérer les messages d'une réservation
    Route::get('/messages/{reservation}', [MessageController::class, 'getMessages'])
         ->name('messages.history');
});