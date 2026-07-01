<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\FoodController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Web\RegionalController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\PemandianController;
use App\Http\Controllers\Web\PenginapanController;
use App\Http\Controllers\Web\KritikSaranController;

Route::group(['domain' => ''], function () {
    Route::get('auth', [AuthController::class, 'index'])->name('auth.index');
    Route::get('auth/google/redirect', [AuthController::class, 'redirectToGoogle'])->name('auth.google.redirect');
    Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
    Route::post('auth/firebase', [AuthController::class, 'handleFirebaseAuth'])->name('auth.firebase');
    Route::post('auth/login', [AuthController::class, 'do_login'])->name('auth.login');
    Route::get('auth/register', [AuthController::class, 'register'])->name('register');
    Route::post('auth/register', [AuthController::class, 'do_register'])->name('auth.register');
    Route::get('auth/forgot', [AuthController::class, 'forgot'])->name('forgot');
    Route::post('auth/forgot', [AuthController::class, 'do_forgot'])->name('auth.forgot');
    Route::post('auth/reset-password', [AuthController::class, 'reset_password'])->name('auth.reset_password');

    Route::prefix('')->name('web.')->group(function () {
        Route::get('penginapan', [PenginapanController::class, 'index'])->name('penginapan');
        Route::get('penginapan/{id}/detail', [PenginapanController::class, 'detail'])->name('penginapan.detail');
        Route::get('penginapan/{id}/create', [PenginapanController::class, 'create'])->name('penginapan.create');
        Route::post('penginapan/book', [PenginapanController::class, 'book'])->name('penginapan.book');
        Route::post('penginapan/storeReservation', [PenginapanController::class, 'storeReservation'])->name('penginapan.storeReservation');
        Route::put('penginapan/{id}', [PenginapanController::class, 'update'])->name('penginapan.update');
        Route::post('penginapan/payment', [PenginapanController::class, 'updatePayment'])->name('penginapan.payment');
        Route::get('penginapan/{penginapan}/pdf', [PenginapanController::class, 'pdf'])->name('penginapan.pdf');
        Route::get('penginapan/history', [PenginapanController::class, 'history'])->name('penginapan.history');



        Route::post('penginapan/{id}/store', [PenginapanController::class, 'store'])->name('penginapan.store')->middleware('auth');
        // Route::get('penginapan/booking', [PenginapanController::class, 'booking'])->name('penginapan.booking');
        Route::post('penginapan/check', [PenginapanController::class, 'check'])->name('penginapan.check');

        Route::get('food', [FoodController::class, 'index'])->name('food');
        Route::get('food/{food}', [FoodController::class, 'detail'])->name('food.detail');
        // Route::get('check', [PenginapanController::class, 'check'])->name('check');
        Route::get('checkout/history', [CheckoutController::class, 'history'])->name('checkout.history');



        Route::get('pemandian', [PemandianController::class, 'index'])->name('pemandian');
        Route::get('pemandian/{id}/detail', [PemandianController::class, 'detail'])->name('booking.detail');
        Route::post('pemandian/book', [PemandianController::class, 'book'])->name('pemandian.book');
        Route::get('pemandian/{id}/create', [PemandianController::class, 'create'])->name('pemandian.create');
        Route::get('pemandian/history', [PemandianController::class, 'history'])->name('pemandian.history');
        Route::post('pemandian/storeReservation', [PemandianController::class, 'storeReservation'])->name('pemandian.storeReservation');
        Route::put('pemandian/{id}', [PemandianController::class, 'update'])->name('pemandian.update');
        Route::post('pemandian/payment', [PemandianController::class, 'updatePayment'])->name('pemandian.payment');
        Route::get('pemandian/{pemandian}/pdf', [PemandianController::class, 'pdf'])->name('pemandian.pdf');
        Route::post('pemandian/check', [PemandianController::class, 'check'])->name('pemandian.check');




        Route::get('kritik-saran', [KritikSaranController::class, 'index'])->name('kritik');
        Route::post('kritik-saran/store', [KritikSaranController::class, 'store'])->name('kritik.store');


        // Route::middleware('can:User')->group(function () {
        Route::redirect('/', 'dashboard', 301);
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        // CART
        Route::get('counter_cart', [CartController::class, 'notif'])->name('counter_cart');
        Route::get('cart', [CartController::class, 'index'])
            ->name('cart.index')
            ->middleware('auth');
        Route::post('cart/add', [CartController::class, 'store'])->name('cart.add');
        Route::patch('cart/increase/{cart}', [CartController::class, 'increase'])->name('cart.increase');
        Route::patch('cart/decrease/{cart}', [CartController::class, 'decrease'])->name('cart.decrease');
        Route::patch('cart/update/{cart}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('cart/delete/{cart}', [CartController::class, 'destroy'])->name('cart.delete');


        // Checkout
        // Route::get('checkout/customer', [CheckoutController::class, 'customer'])->name('checkout.customer');
        Route::get('checkout/customer', [CheckoutController::class, 'customer'])
            ->name('checkout.customer')
            ->middleware('auth');
        Route::post('checkout/customer', [CheckoutController::class, 'updateCustomer'])->name('checkout.update_customer');
        Route::get('checkout/shipping', [CheckoutController::class, 'shipping'])->name('checkout.shipping');
        Route::get('checkout/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
        Route::get('checkout/{order}/pdf', [CheckoutController::class, 'pdf'])->name('checkout.pdf');
        Route::post('check', [CheckoutController::class, 'check'])->name('check');
        Route::post('checkout', [CheckoutController::class, 'checkout'])->name('checkout');
        Route::get('checkout/{id}', [CheckoutController::class, 'checkout_detail'])->name('checkout.detail');


        // REGIONAL
        Route::post('regional/province', [RegionalController::class, 'province'])->name('regional.province');
        Route::post('regional/city', [RegionalController::class, 'city'])->name('regional.city');
        Route::post('regional/subdistrict', [RegionalController::class, 'subdistrict'])->name('regional.subdistrict');


        Route::get('logout', [AuthController::class, 'do_logout'])->name('logout');

        // // PROFILE
        // Route::get('profile', [ProfileController::class, 'index'])->name('profile');
        // Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        // Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');
        // Route::post('profile/change-password', [ProfileController::class, 'do_change_password'])->name('profile.do_change_password');

    });
});
// });
