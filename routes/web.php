<?php

use App\Http\Controllers\AgunanController;
use App\Http\Controllers\AngsuranController;
use App\Http\Controllers\BukuBesarController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JenisRekeningController;
use App\Http\Controllers\KodeRekeningController;
use App\Http\Controllers\NeracaController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('user')
        ->name('user.')
        ->controller(UserController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index')->middleware('checkPermission:view user');
            Route::get('show', 'show')->name('show')->middleware('checkPermission:view user');
            Route::get('create', 'create')->name('create')->middleware('checkPermission:create user');
            Route::post('store', 'store')->name('store')->middleware('checkPermission:create user');
            Route::get('edit/{id}', 'edit')->name('edit')->middleware('checkPermission:update user');
            Route::put('update/{id}', 'update')->name('update')->middleware('checkPermission:update user');
            Route::delete('delete/{id}', 'destroy')->name('delete')->middleware('checkPermission:delete user');
        });

    // nasabah route
    Route::prefix('nasabah')
        ->name('nasabah.')
        ->controller(NasabahController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index')->middleware('checkPermission:view nasabah');
            Route::get('show', 'show')->name('show')->middleware('checkPermission:view nasabah');
            Route::get('create', 'create')->name('create')->middleware('checkPermission:create nasabah');
            Route::post('store', 'store')->name('store')->middleware('checkPermission:create nasabah');
            Route::get('edit/{nasabah}', 'edit')->name('edit')->middleware('checkPermission:edit nasabah');
            Route::put('update/{nasabah}', 'update')->name('update')->middleware('checkPermission:edit nasabah');
            Route::delete('delete/{nasabah}', 'destroy')->name('delete')->middleware('checkPermission:delete nasabah');
            Route::get('download', 'download')->name('download')->middleware('checkPermission:view nasabah');
            Route::get('rekap_tahunan', 'rekap_tahunan')->name('rekap_tahunan')->middleware('checkPermission:view nasabah');
        });

    Route::prefix('agunan')
        ->name('agunan.')
        ->controller(AgunanController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('show', 'show')->name('show');
            Route::get('create/{pinjaman_id}', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::put('update/{id}', 'update')->name('update');
            Route::delete('delete/{id}', 'destroy')->name('delete');
            Route::get('download', 'download')->name('download');
        });

    // pinjaman route
    Route::prefix('pinjaman')
        ->name('pinjaman.')
        ->controller(PinjamanController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index')->middleware('checkPermission:view pinjaman');
            Route::get('show', 'show')->name('show')->middleware('checkPermission:view pinjaman');
            Route::get('show_rekap', 'show_rekap')->name('show_rekap')->middleware('checkPermission:view pinjaman');
            Route::get('create', 'create')->name('create')->middleware('checkPermission:create pinjaman');
            Route::post('store', 'store')->name('store')->middleware('checkPermission:create pinjaman');
            Route::delete('delete/{id}', 'destroy')->name('delete')->middleware('checkPermission:delete pinjaman');
            Route::get('edit/{id}', 'edit')->name('edit')->middleware('checkPermission:edit pinjaman');
            Route::put('update/{id}', 'update')->name('update')->middleware('checkPermission:edit pinjaman');
            Route::get('download', 'download')->name('download')->middleware('checkPermission:view pinjaman');
            Route::get('setting-pinjaman', 'setting_pinjaman')->name('setting_pinjaman');
        });

    Route::prefix('angsuran')
        ->name('angsuran.')
        ->controller(AngsuranController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index')->middleware('checkPermission:view angsuran');
            Route::get('angsuran_terakhir/{id}', 'angsuran_terakhir')->name('angsuran_terakhir')->middleware('checkPermission:view angsuran');
            Route::get('show', 'show')->name('show')->middleware('checkPermission:view angsuran');
            Route::get('create', 'create')->name('create')->middleware('checkPermission:create angsuran');
            Route::post('store', 'store')->name('store')->middleware('checkPermission:create angsuran');
            Route::delete('delete/{id}', 'destroy')->name('delete')->middleware('checkPermission:delete angsuran');
            Route::get('download', 'download')->name('download')->middleware('checkPermission:view angsuran');
            Route::get('rekap_bulanan', 'rekap_bulanan')->name('rekap_bulanan')->middleware('checkPermission:view angsuran');
            Route::get('setting-angsuran', 'setting_angsuran')->name('setting_angsuran');
        });

    Route::prefix('kode_rekening')
        ->name('kode_rekening.')
        ->controller(KodeRekeningController::class)
        ->group(function () {
            Route::get('/index/{jenis_rekening}', 'index')->name('index');
            Route::get('show/{jenis_rekening?}', 'show')->name('show');
            Route::get('create/{jenis_rekening}', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::put('update/{id}', 'update')->name('update');
            Route::delete('delete/{id}', 'destroy')->name('delete');
        });

    Route::prefix('jenis_rekening')
        ->name('jenis_rekening.')
        ->controller(JenisRekeningController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('show', 'show')->name('show');
            Route::get('show_all', 'show_all')->name('show_all');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::put('update/{id}', 'update')->name('update');
            Route::delete('delete/{id}', 'destroy')->name('delete');
        });


    Route::prefix('buku_besar')
        ->name('buku_besar.')
        ->controller(BukuBesarController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index'); // Menampilkan daftar transaksi
            Route::get('show', 'show')->name('show'); // Menampilkan daftar transaksi
            Route::get('create', 'create')->name('create'); // Menampilkan form tambah transaksi
            Route::post('store', 'store')->name('store'); // Menyimpan transaksi baru
            Route::get('edit/{id}', 'edit')->name('edit'); // Menampilkan form edit transaksi
            Route::put('update/{id}', 'update')->name('update'); // Memperbarui transaksi yang ada
            Route::delete('delete/{id}', 'destroy')->name('delete'); // Menghapus transaksi
        });


    Route::prefix('neraca')
        ->name('neraca.')
        ->controller(NeracaController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('show', 'show')->name('show');
        });
});


require __DIR__ . '/auth.php';
