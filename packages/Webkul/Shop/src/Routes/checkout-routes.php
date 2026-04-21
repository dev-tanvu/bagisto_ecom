<?php

use Illuminate\Support\Facades\Route;
use Webkul\Shop\Http\Controllers\CartController;
use Webkul\Shop\Http\Controllers\OnepageController;
use Webkul\Shop\Http\Controllers\SSLCommerzController;

/**
 * Cart routes.
 */
Route::controller(CartController::class)->prefix('checkout/cart')->group(function () {
    Route::get('', 'index')->name('shop.checkout.cart.index');
});

Route::controller(OnepageController::class)->prefix('checkout/onepage')->group(function () {
    Route::get('', 'index')->name('shop.checkout.onepage.index');

    Route::get('success', 'success')->name('shop.checkout.onepage.success');
});

/**
 * SSLCommerz payment routes.
 *
 * The success/fail/cancel/ipn routes receive POST callbacks from SSLCommerz
 * without CSRF tokens — those are excluded in bootstrap/app.php.
 */
Route::controller(SSLCommerzController::class)
    ->prefix('checkout/sslcommerz')
    ->group(function () {
        Route::get('pay', 'pay')->name('shop.sslcommerz.pay');
        Route::post('success', 'success')->name('shop.sslcommerz.success');
        Route::post('fail', 'fail')->name('shop.sslcommerz.fail');
        Route::post('cancel', 'cancel')->name('shop.sslcommerz.cancel');
        Route::post('ipn', 'ipn')->name('shop.sslcommerz.ipn');
    });
