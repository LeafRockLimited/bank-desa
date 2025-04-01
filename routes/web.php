<?php

use App\Http\Controllers\AgunanController;
use App\Http\Controllers\AngsuranController;
use App\Http\Controllers\BukuBesarController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JenisRekeningController;
use App\Http\Controllers\JenisSimpananController;
use App\Http\Controllers\KodeRekeningController;
use App\Http\Controllers\NeracaController;
use App\Http\Controllers\SimpananController;
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
            Route::get('/', 'index')->name('index');
            Route::get('show', 'show')->name('show');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{nasabah}', 'edit')->name('edit');
            Route::put('update/{nasabah}', 'update')->name('update');
            Route::delete('delete/{nasabah}', 'destroy')->name('delete');
            Route::get('download', 'download')->name('download');
            Route::get('rekap_tahunan', 'rekap_tahunan')->name('rekap_tahunan');
        });

    Route::prefix('agunan')
        ->name('agunan.')
        ->controller(AgunanController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('show/{pinjaman_id}', 'show')->name('show');
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
            Route::get('/', 'index')->name('index');
            Route::get('show', 'show')->name('show');
            Route::get('show_rekap', 'show_rekap')->name('show_rekap');
            Route::get('create', 'create')->name('create')->middleware('checkPermission:create pinjaman');
            Route::post('store', 'store')->name('store');
            Route::delete('delete/{id}', 'destroy')->name('delete');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::put('update/{id}', 'update')->name('update');
            Route::get('download', 'download')->name('download');
            Route::get('setting-pinjaman', 'setting_pinjaman');
        });

    Route::prefix('angsuran')
        ->name('angsuran.')
        ->controller(AngsuranController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('angsuran_terakhir/{id}', 'angsuran_terakhir')->name('angsuran_terakhir');
            Route::get('show', 'show')->name('show');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::delete('delete/{id}', 'destroy')->name('delete');
            Route::get('download', 'download')->name('download');
            Route::get('rekap_bulanan', 'rekap_bulanan')->name('rekap_bulanan');
            Route::get('setting-angsuran', 'setting_angsuran')->name('setting_angsuran');
        });

    Route::prefix('simpanan')
        ->name('simpanan.')
        ->controller(SimpananController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('store','store')->name('store');
            Route::post('deposit', 'deposit')->name('deposit');

            Route::get('tabungan_nasabah/{nasabah_id}','tabungan_nasabah')->name('tabungan_nasabah');

            Route::prefix('jenis')
            ->name('jenis.')
            ->controller(JenisSimpananController::class)
            ->group(function () {
                Route::get('data','data')->name('data');
            });
        });

    Route::prefix('kode_rekening')
        ->name('kode_rekening.')
        ->controller(KodeRekeningController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('show', 'show')->name('show');
            Route::get('level_data', 'level_data')->name('level_data');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::put('update/{id}', 'update')->name('update');
            Route::delete('delete/{id}', 'destroy')->name('delete');
            Route::post('import', 'import')->name('import');
        });

    Route::prefix('jurnal')
        ->name('jurnal.')
        ->controller(\App\Http\Controllers\JurnalController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('show', 'show')->name('show');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::put('update/{id}', 'update')->name('update');
            Route::delete('delete/{id}', 'destroy')->name('delete'); // Menghapus transaksi
            Route::post('import', 'import')->name('import');
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
            Route::get('bkd', 'index_bkd')->name('bkd');
            Route::get('show', 'show')->name('show');
            Route::get('download_neraca_bkd', 'export_neraca_bkd')->name('download_neraca_bkd');
            Route::get('download_laba_rugi_bkd', 'export_laba_rugi_bkd')->name('export_laba_rugi_bkd');
        });

    Route::prefix('laba_rugi')
        ->name('laba_rugi.')
        ->controller(\App\Http\Controllers\LabaRugiController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('export', 'export')->name('export');
        });

    Route::prefix('lpe')
        ->name('lpe.')
        ->controller(\App\Http\Controllers\LpeController::class)
        ->group(function () {
            Route::get('download', 'download')->name('download');
        });

    Route::prefix('lak')
        ->name('lak.')
        ->controller(\App\Http\Controllers\LakController::class)
        ->group(function () {
            Route::get('download', 'download')->name('download');
        });
});


require __DIR__ . '/auth.php';
