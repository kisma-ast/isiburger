<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BurgerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestMailController;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;


// Routes publiques
Route::get('/', function () {
    return redirect()->route('burgers.catalog');
});

// Routes d'authentification
Auth::routes();

// Redirection après connexion
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Routes pour les clients (catalogue, details des burgers)
Route::get('/catalog', [BurgerController::class, 'catalog'])->name('burgers.catalog');
Route::get('/burgers/{burger}', [BurgerController::class, 'show'])->name('burgers.show');

// Routes authentifiees communes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Routes du panier
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    
    // Routes commune pour les commandes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/invoice', [OrderController::class, 'generateInvoice'])->name('orders.invoice');
});

// Routes pour les clients
Route::middleware(['client'])->group(function () {
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
});

// Routes pour les gestionnaires
Route::middleware(['gestionnaire'])->group(function () {
    // Gestion des burgers
    Route::get('/admin/burgers', [BurgerController::class, 'index'])->name('burgers.index');
    Route::get('/admin/burgers/create', [BurgerController::class, 'create'])->name('burgers.create');
    Route::post('/admin/burgers', [BurgerController::class, 'store'])->name('burgers.store');
    Route::get('/admin/burgers/{burger}/edit', [BurgerController::class, 'edit'])->name('burgers.edit');
    Route::put('/admin/burgers/{burger}', [BurgerController::class, 'update'])->name('burgers.update');
    Route::patch('/admin/burgers/{burger}/archive', [BurgerController::class, 'archive'])->name('burgers.archive');
    Route::delete('/admin/burgers/{burger}', [BurgerController::class, 'destroy'])->name('burgers.destroy');
    
    // Gestion des commandes
    Route::patch('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status.update');
    Route::delete('/admin/orders/{order}', [OrderController::class, 'cancel'])->name('orders.cancel');
    
    // Gestion des paiements
    Route::get('/admin/orders/{order}/payment', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/admin/orders/{order}/payment', [PaymentController::class, 'store'])->name('payments.store');
    
    // Statistiques
    Route::get('/admin/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
});


// Routes de test pour les emails (à supprimer en production)
Route::get('/test-order-confirmation', [TestMailController::class, 'testOrderConfirmation']);
Route::get('/test-order-ready', [TestMailController::class, 'testOrderReady']);