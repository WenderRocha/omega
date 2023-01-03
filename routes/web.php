<?php

use App\Http\Controllers\ManagementController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\WalletController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/wallet', [WalletController::class, 'index'])->middleware(['auth', 'verified'])->name('wallet.index');
Route::get('/wallet/{id}', [WalletController::class, 'show'])->middleware(['auth', 'verified'])->name('wallet.show');
Route::get('/wallet/{id}/book', [ManagementController::class, 'book'])->middleware(['auth', 'verified'])->name('management.book');
Route::post('/wallet', [WalletController::class, 'store'])->middleware(['auth', 'verified'])->name('wallet.store');

Route::get('/trade', [TradeController::class, 'index'])->middleware(['auth', 'verified'])->name('trade.index');
Route::post('/trade', [TradeController::class, 'store'])->middleware(['auth', 'verified'])->name('trade.store');


Route::get('/components/buttons', function () {
    return Inertia::render('Components/Buttons');
})->middleware(['auth', 'verified'])->name('components.buttons');

require __DIR__ . '/auth.php';
