<?php

use App\Http\Controllers\ClientPortalController;
use App\Http\Controllers\IBController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TestController;
use App\Http\Middleware\EnsureStatusTrue;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('orders.index');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('orders.index');
    })->name('dashboard');

    Route::resource('orders', OrderController::class);

    Route::get('/settings', function () {
        return view('settings');
    })->name('settings')->middleware(EnsureStatusTrue::class);

    Route::get('/logs', function () {
        return view('logs');
    })->name('logs');

    Route::prefix('clientportal')->name('clientportal.')->group(function () {
        Route::get('/', [ClientPortalController::class, 'status'])->name('status');
        Route::get('/start', [ClientPortalController::class, 'start'])->name('start');
        Route::get('/stop', [ClientPortalController::class, 'stop'])->name('stop');
        Route::get('/logout', [ClientPortalController::class, 'logout'])->name('logout');
        Route::get('/reauth', [ClientPortalController::class, 'reauth'])->name('reauth');
        Route::get('/statusstart', [ClientPortalController::class, 'statusStart'])->name('status-start');
        Route::get('/statusstop', [ClientPortalController::class, 'statusStop'])->name('status-stop');                
        // Route::get('/scanon', [ClientPortalController::class, 'scanOn'])->name('scan-on');
        // Route::get('/scanoff', [ClientPortalController::class, 'scanOff'])->name('scan-off');
    });

    Route::prefix('ib')->name('ib.')->middleware(EnsureStatusTrue::class)->group(function () {
        // Route::get('/order', [IBController::class, 'newOrder'])->name('newOrder');
        Route::get('/cancelorder/{acctId}/{orderId}', [IBController::class, 'cancelOrder'])->name('cancelOrder');
        // Route::post('/order', [IBController::class, 'postOrder'])->name('postOrder');
        Route::get('/orders', [IBController::class, 'orders'])->name('orders');
        Route::get('/positions', [IBController::class, 'positions'])->name('positions');
        Route::get('/info/{conid}', [IBController::class, 'info'])->name('info');
        Route::get('/orderstatus/{conid}', [IBController::class, 'orderstatus'])->name('orderstatus');
    });

    Route::prefix('test')->name('test.')->group(function() {
        Route::get('/notify', [TestController::class, 'notify'])->name('notify');
        Route::get('/candle', [TestController::class, 'candle'])->name('candle');
        Route::get('/futures', [TestController::class, 'futures'])->name('futures');
        Route::get('/stocks', [TestController::class, 'stocks'])->name('stocks');
    });
});
