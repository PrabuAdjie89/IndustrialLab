<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MonitorRuanganController;
use App\Http\Controllers\PeminjamanBarangController;
use App\Http\Controllers\PeminjamanRuangController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PublicInventoryController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');

Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->middleware(['auth'])
    ->name('home');
Route::get('/inventory/{kode_unit}', [PublicInventoryController::class,'show'])->name('inventory.public.show');
Route::get('/monitor-jadwal-ruangan',[MonitorRuanganController::class, 'monitor'])->name('peminjaman-ruang.monitor');

Route::middleware('auth')->group(function () {
    Route::middleware('role:laboran,kalab')->group(function () {

        Route::prefix('master-data')->name('master-data.')->group(function () {
            Route::resource('kategori-barang', KategoriBarangController::class);
            Route::get('barang/export',[BarangController::class, 'export'])->name('barang.export');
            Route::get('barang/{barang}/print-qr',[BarangController::class, 'printQr'])->name('barang.print-qr');
            Route::resource('barang', BarangController::class);
            Route::patch('barang-unit/{unit}/status',[BarangController::class, 'updateStatus'])->name('barang.update-status');
            Route::get('barang-masuk/export',[BarangMasukController::class, 'export'])->name('barang-masuk.export');
            Route::resource('barang-masuk', BarangMasukController::class);
            Route::get('barang-keluar/export',[BarangKeluarController::class, 'export'])->name('barang-keluar.export');
            Route::resource('barang-keluar', BarangKeluarController::class);

        });

    });

    Route::middleware('role:laboran,kalab')->group(function () {


        Route::prefix('ruangan')->name('ruangan.')->group(function () {

            Route::get('/', [RuanganController::class, 'index'])
                ->name('index');

            Route::post('/', [RuanganController::class, 'store'])
                ->name('store');

            Route::get('{ruangan}', [RuanganController::class, 'show'])
                ->name('show');

            Route::put('{ruangan}', [RuanganController::class, 'update'])
                ->name('update');

            Route::delete('{ruangan}', [RuanganController::class, 'destroy'])
                ->name('destroy');

        });

    });

    Route::prefix('peminjaman')->name('peminjaman.')->group(function () {

        Route::get('/', [PeminjamanBarangController::class, 'index'])
            ->name('index');

        Route::post('/', [PeminjamanBarangController::class, 'store'])
            ->name('store');

        Route::get('/export',[PeminjamanBarangController::class, 'export'])
            ->name('export');

        Route::get('{peminjaman}', [PeminjamanBarangController::class, 'show'])
            ->name('show');

        Route::put('{peminjaman}', [PeminjamanBarangController::class, 'update'])
            ->name('update');

        Route::delete('{peminjaman}', [PeminjamanBarangController::class, 'destroy'])
            ->name('destroy');

        Route::post(
            '{peminjaman}/verify',
            [PeminjamanBarangController::class, 'verify']
        )
        ->middleware('role:laboran,kalab')
        ->name('verify');

    });

    Route::prefix('peminjaman-ruang')
        ->name('peminjaman-ruang.')
        ->group(function () {
            Route::get('/', [PeminjamanRuangController::class, 'index'])
                ->name('index');
            Route::get('/jadwal',[PeminjamanRuangController::class, 'jadwal'])
                ->name('jadwal');
            Route::post('/', [PeminjamanRuangController::class, 'store'])
                ->name('store');
            Route::get('/export',[PeminjamanRuangController::class, 'export'])
                ->name('export');
            Route::put('{peminjamanRuang}',[PeminjamanRuangController::class, 'update'])
                ->name('update');
            Route::put('{peminjamanRuang}/verify',[PeminjamanRuangController::class, 'verify'])
                ->middleware('role:laboran,kalab')
                ->name('verify');
            Route::post('{peminjamanRuang}/selesai',[PeminjamanRuangController::class, 'selesai'])
                ->name('selesai');
            Route::delete('{peminjamanRuang}',[PeminjamanRuangController::class, 'destroy'])
                ->name('destroy');


        });

    Route::middleware('role:laboran,kalab')->group(function () {

        Route::prefix('laporan')->name('laporan.')->group(function () {

            Route::get('/', [LaporanController::class, 'index'])
                ->name('index');

        });

    });

    Route::middleware('role:laboran')->group(function () {
        Route::get('/pengaturan-sop', [SettingController::class, 'sop'])->name('settings.sop');
        Route::post('/pengaturan-sop', [SettingController::class, 'updateSop'])
            ->name('settings.sop.update');
        Route::get('/user-management',[UserController::class, 'index'])->name('user.index');
        Route::put('/user-management/{user}',[UserController::class, 'updateRole'])->name('user.updateRole');
        Route::delete('/user-management/{user}',[UserController::class, 'destroy'])->name('user.destroy');
        

    });

});