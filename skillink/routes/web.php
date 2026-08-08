<?php

use App\Http\Controllers\ListingController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\SwapRequestController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;


Route::middleware('auth')->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])
        ->name('categories.index');

    Route::get('/categories/{category}', [CategoryController::class, 'show'])
        ->name('categories.show');
});



Route::get('/', function () {
    return view('welcome');
});

Route::get('/skillselection', function () {
    return view('skillselection');
})->middleware(['auth', 'verified'])->name('skillselection');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.status');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
    Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/listings', [ListingController::class, 'store'])->name('listings.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/listings/{listing}/swap-requests/create', [SwapRequestController::class, 'create'])->name('swap-requests.create');
    Route::post('/listings/{listing}/swap-requests', [SwapRequestController::class, 'store'])->name('swap-requests.store');

    Route::get('/swap-requests', [SwapRequestController::class, 'index'])->name('swap-requests.index');
    Route::get('/swap-requests/{swapRequest}', [SwapRequestController::class, 'show'])->name('swap-requests.show');
    Route::patch('/swap-requests/{swapRequest}/accept', [SwapRequestController::class, 'accept'])->name('swap-requests.accept');
    Route::patch('/swap-requests/{swapRequest}/start', [SwapRequestController::class, 'start'])->name('swap-requests.start');
    Route::patch('/swap-requests/{swapRequest}/reject', [SwapRequestController::class, 'reject'])->name('swap-requests.reject');
    Route::patch('/swap-requests/{swapRequest}/cancel', [SwapRequestController::class, 'cancel'])->name('swap-requests.cancel');
    Route::patch('/swap-requests/{swapRequest}/complete', [SwapRequestController::class, 'complete'])->name('swap-requests.complete');

    Route::post('/swap-requests/{swapRequest}/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/swap-requests/{swapRequest}/messages/poll', [MessageController::class, 'poll'])->name('messages.poll');
    Route::get('/messages/{message}/download', [MessageController::class, 'download'])->name('messages.download');
});

require __DIR__.'/auth.php';
