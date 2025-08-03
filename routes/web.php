<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\SaleController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('events', EventController::class);
Route::resource('tickets', TicketController::class);
Route::resource('sales', SaleController::class);

// Route for purchasing tickets
Route::get('events/{event}/buy', [EventController::class, 'buy'])->name('events.buy');
Route::post('events/{event}/purchase', [EventController::class, 'purchase'])->name('events.purchase');