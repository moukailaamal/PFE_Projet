<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaiementController;


Route::get('/', function () {
    return view('welcome');
});
Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {
  
    
    Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('send-message');
    Route::get('/listsMessages/{id}', [ChatController::class, 'indexListMessage'])->name('listsMessages');
Route::get('/chat/{id}', [ChatController::class, 'indexMessage'])->name('chat');

Route::get('/profile', [UserController::class, 'profile'])->name('profile.form');
Route::put('/profile/update/{id}', [UserController::class, 'update'])->name('profile.update');

Route::post('/reviews', [UserController::class, 'storeAvis'])->name('store.review');
Route::put('/reviews/{review}', [UserController::class, 'updateAvis'])->name('update.review');
Route::delete('/reviews/{review}', [UserController::class, 'deleteAvis'])->name('delete.review');

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
    
    
    Route::get('/listAppointments/tech/{id}', [BookController::class, 'listAppointmentsTech'])->name('book.listAppointmentsTech');
    Route::get('/listAppointments/client/{id}', [BookController::class, 'listAppointmentsClient'])->name('book.listAppointmentsClient');
    Route::get('/listAppointments/admin', [BookController::class, 'listAllAppointement'])->name('book.listAppointmentsAdmin');
    
    Route::put('/reservations/{id}/cancel', [BookController::class, 'canceled'])->name('book.cancel');
    Route::put('/reservations/{id}/reactivate', [BookController::class, 'reactivate'])->name('book.reactivate');
    Route::put('/reservations/{id}/confirmed', [BookController::class, 'confirmed'])->name('book.confirmed');
    Route::put('/reservations/{id}/completed', [BookController::class, 'completed'])->name('book.completed');
    
    Route::get('list-tech', [AdminController::class, 'listTechnician'])->name('technician.list');
    Route::put('/technician/{id}/activate', [AdminController::class, 'activeTechnicianStatus'])->name('technician.activateStatus');
    Route::put('/technician/{id}/deactivate', [AdminController::class, 'inactiveTechnicianStatus'])->name('technician.inactivateStatus');
    
    
    
    Route::get('/paymentsOneline/{id}', [PaiementController::class, 'indexPaiement'])->name('payments.index');
    Route::get('/paymentsMethode/{id}', [PaiementController::class, 'indexPaymentMethod'])->name('payments.PaymentMethod');
    
    Route::post('/payments/{id}', [PaiementController::class, 'storePaiement'])->name('payments.store');



});
require __DIR__.'/auth.php';


Route::get('/sitemap.xml', [SitemapController::class, 'generateSitemap']);

Route::get('/home', [HomeController::class, 'home'])->name('home');


Route::get('/register-information-Technicien-form', [AuthController::class, 'showRegistrationFormTechnicien'])->name('register.information.Technicien.form');
Route::post('/register-information-Technicien', [AuthController::class, 'registerTechnicien'])->name('register.information.Technicien');

// profile


Route::get('/details/{id}', [UserController::class, 'InformationTechnician'])->name('technician.details');
 

