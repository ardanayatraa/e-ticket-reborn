<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaketWisataController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\SopirController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\KetersediaanController;
use App\Http\Controllers\IncludeModelController;
use App\Http\Controllers\ExcludeController;
use App\Http\Controllers\TransaksiController;

use App\Http\Controllers\MobilController;
use App\Http\Controllers\Auth\PelangganAuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PointSettingsController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes (No Auth Required)
Route::get('/', [PaketWisataController::class, 'list'])->name('paket-wisata.landing');
Route::get('/paket/{slug}', [PaketWisataController::class, 'show'])->name('paket-wisata.detail');
Route::get('/check-availability', [PaketWisataController::class, 'check'])->name('check-availability');

// Admin Routes (Protected)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [TransaksiController::class, 'dashboard'])
        ->name('dashboard');

    Route::resource('admin', AdminController::class);

    // Paket Wisata Routes - PERBAIKAN: Gunakan primary key untuk model binding
       Route::prefix('paket-wisata')->name('paket-wisata.')->group(function () {
        Route::get('/', [PaketWisataController::class, 'index'])->name('index');
        Route::get('/create', [PaketWisataController::class, 'create'])->name('create');
        Route::post('/', [PaketWisataController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PaketWisataController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PaketWisataController::class, 'update'])->name('update');
        Route::delete('/{id}', [PaketWisataController::class, 'destroy'])->name('destroy');
       });

    Route::resource('pelanggan', PelangganController::class);
    Route::resource('sopir', SopirController::class);
    Route::resource('mobil', MobilController::class);
    Route::resource('pemesanan', PemesananController::class)->only(['index','show','edit','update','destroy']);
    Route::resource('ketersediaan', KetersediaanController::class);
    Route::resource('include', IncludeModelController::class)->except(['show']);
    Route::resource('exclude', ExcludeController::class)->except(['show']);
    Route::resource('transaksi', TransaksiController::class)->except('edit');
    Route::put('transaksi/{transaksi}/confirm', [TransaksiController::class, 'confirmPayment'])
        ->name('transaksi.confirm');
    Route::get('/laporan', [TransaksiController::class, 'laporan'])
        ->name('laporan');

    // Point Settings Routes
    Route::resource('point-settings', PointSettingsController::class);
    Route::put('/point-settings/{id}/toggle-active', [PointSettingsController::class, 'toggleActive'])
        ->name('point-settings.toggle-active');
    Route::post('/point-settings/preview', [PointSettingsController::class, 'preview'])
        ->name('point-settings.preview');
});

// Pelanggan Authentication Routes
Route::prefix('pelanggan')->group(function () {
    Route::get('/login', [PelangganAuthController::class, 'showLoginForm'])->name('pelanggan.login');
    Route::post('/login', [PelangganAuthController::class, 'login']);
    Route::get('/register', [PelangganAuthController::class, 'showRegisterForm'])->name('pelanggan.register');
    Route::post('/register', [PelangganAuthController::class, 'register']);
    Route::post('/logout', [PelangganAuthController::class, 'logout'])->name('pelanggan.logout');
});

// Profile routes (Protected - Pelanggan only)
Route::middleware('auth:pelanggan')->group(function () {
    Route::post('/pelanggan/profile/update', [PelangganController::class, 'updateProfile'])
        ->name('pelanggan.profile.update');
});


Route::post('pelanggan/logout', function () {
    Auth::guard('pelanggan')->logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect('/'); // Ganti sesuai kebutuhan, bisa ke route('pelanggan.login') atau lainnya
})->name('pelanggan.logout');

// Member Routes (Protected - Pelanggan only)
Route::middleware('auth:pelanggan')->prefix('member')->group(function () {
    Route::get('/', [MemberController::class, 'index'])->name('member.index');
    Route::get('/upgrade', [MemberController::class, 'upgrade'])->name('member.upgrade');
    Route::post('/payment/success', [MemberController::class, 'manualSuccess']);
    Route::get('/payment/{orderId}', [MemberController::class, 'payment'])->name('member.payment');
});

// Booking Routes (Protected - Pelanggan only)
Route::middleware('auth:pelanggan')->group(function () {
    Route::get('/booking/create', [PemesananController::class, 'create'])->name('booking.create');
    Route::post('/booking', [PemesananController::class, 'store'])->name('booking.store');
    Route::get('/booking/payment/{transaksi}', [BookingController::class, 'payment'])->name('booking.payment');
    Route::post('/booking/payment/success', [BookingController::class, 'paymentSuccess'])->name('booking.payment.success');
    Route::get('/download-eticket/{transaksi}', [App\Http\Controllers\PemesananController::class, 'download'])
    ->name('download.eticket');
});

// Midtrans Callback Routes (Public - no auth required)
Route::post('/midtrans/callback/member', [MemberController::class, 'callback'])->name('midtrans.callback.member');
Route::post('/midtrans/callback/booking', [BookingController::class, 'callback'])->name('midtrans.callback.booking');

// Ticket Route
Route::get('/transaksi/{transaksi}/ticket', [TransaksiController::class, 'ticket'])
    ->name('transaksi.ticket');
