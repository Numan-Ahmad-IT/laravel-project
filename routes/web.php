<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\TicketPurchaseController;

Route::get('/', function () {
    return redirect()->route('events.index');
});

// Main events resource
Route::resource('events', EventController::class);

// Nested tickets routes
Route::prefix('events/{event}')->group(function () {
    // Ticket index/create/store (need to define separately for custom names)
    Route::get('tickets', [TicketController::class, 'index'])->name('events.tickets.index');
    Route::get('tickets/create', [TicketController::class, 'create'])->name('events.tickets.create');
    Route::post('tickets', [TicketController::class, 'store'])->name('events.tickets.store');
    
    // Regular resource for other ticket actions
    Route::resource('tickets', TicketController::class)->except(['index', 'create', 'store'])
        ->names([
            'show' => 'events.tickets.show',
            'edit' => 'events.tickets.edit',
            'update' => 'events.tickets.update',
            'destroy' => 'events.tickets.destroy'
        ]);

    
    // Nested sales routes
    Route::prefix('tickets/{ticket}')->group(function () {
        Route::get('sales', [SaleController::class, 'index'])->name('events.tickets.sales.index');
        Route::get('sales/create', [SaleController::class, 'create'])->name('events.tickets.sales.create');
        Route::post('sales', [SaleController::class, 'store'])->name('events.tickets.sales.store');
        
        // Regular resource for other sale actions
        Route::resource('sales', SaleController::class)->except(['index', 'create', 'store'])
            ->names([
                'show' => 'events.tickets.sales.show',
                'edit' => 'events.tickets.sales.edit',
                'update' => 'events.tickets.sales.update',
                'destroy' => 'events.tickets.sales.destroy'
            ]);
    });
});