<?php

use App\Http\Controllers\ActivityLogController;
use App\Models\Supplier;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DirektoratController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\LaporanBarangKeluarController;
use App\Http\Controllers\LaporanBarangMasukController;
use App\Http\Controllers\LaporanStokController;
use App\Http\Controllers\ManajemenUserController;
use App\Http\Controllers\UbahPasswordController;
use App\Http\Controllers\AmprahanController;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware('auth')->group(function () {

    Route::group(['middleware' => 'checkRole:superadmin'], function(){
        Route::get('/data-pengguna/get-data', [ManajemenUserController::class, 'getDataPengguna']);
        Route::get('/api/role/', [ManajemenUserController::class, 'getRole']);
        Route::resource('/data-pengguna', ManajemenUserController::class);
    
        Route::get('/hak-akses/get-data', [HakAksesController::class, 'getDataRole']);
        Route::resource('/hak-akses', HakAksesController::class);
    });

    Route::group(['middleware' => 'checkRole:superadmin,user'], function(){
        Route::resource('/aktivitas-user', ActivityLogController::class);
        
    });

    Route::group(['middleware' => 'checkRole:user,superadmin,admin'], function(){

        Route::get('/barang/detail/{id}', [BarangController::class, 'showDetail'])->name('barang.detail');
        Route::get('/barang/get-data', [BarangController::class, 'getDataBarang']);
        Route::resource('/barang', BarangController::class);

        Route::resource('/dashboard', DashboardController::class);
        Route::get('/', [DashboardController::class, 'index']);
    
        
        Route::get('/ubah-password', [UbahPasswordController::class,'index']);
        Route::POST('/ubah-password', [UbahPasswordController::class, 'changePassword']);
        
        Route::get('/amprahan', [AmprahanController::class, 'index']);
        Route::get('/amprahan/get-data', [AmprahanController::class, 'getDataAmprahan']);
        Route::get('/amprahan/print-amprahan/{id}', [AmprahanController::class, 'printAmprahan']);
        Route::resource('/amprahan', AmprahanController::class);

        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsReadAndRedirect'])->name('notification.read');
        Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);

        Route::get('laporan/kondisi_barang', [BarangController::class, 'kondisi_barang'])->name('laporan.kondisi_barang');
        Route::get('laporan/data-penyusutan', [BarangController::class, 'data_penyusutan']);
        Route::get('laporan/print_penyusutan', [BarangController::class, 'print_data_penyusutan'])->name('laporan.print_penyusutan');
        
        
        Route::get('/laporan/fetch_kondisi_barang', [BarangController::class, 'fetch_kondisi_barang']);
        Route::get('/laporan/fetch_jenis_barang', [BarangController::class, 'fetch_jenis_barang']);
        Route::get('/laporan/print_barang', [BarangController::class, 'print_laporan_barang'])->name('laporan.print_barang');

    });


    Route::group(['middleware' => 'checkRole:superadmin,admin'], function(){
    
        Route::get('/jenis-barang/get-data', [JenisController::class, 'getDataJenisBarang']);
        Route::resource('/jenis-barang', JenisController::class);
    
        Route::get('/satuan-barang/get-data', [SatuanController::class, 'getDataSatuanBarang']);
        Route::resource('/satuan-barang', SatuanController::class);
    
        Route::get('/direktorat/get-data', [DirektoratController::class, 'getDataDirektorat']);
        Route::resource('/direktorat', DirektoratController::class);
    
        Route::get('/customer/get-data', [CustomerController::class, 'getDataCustomer']);
        Route::resource('/customer', CustomerController::class);
    
        Route::get('/api/barang-masuk/', [BarangMasukController::class, 'getAutoCompleteData']);
        Route::get('/barang-masuk/get-data', [BarangMasukController::class, 'getDataBarangMasuk']);
        Route::get('/api/satuan/', [BarangMasukController::class, 'getSatuan']);
        Route::resource('/barang-masuk', BarangMasukController::class);
    
        Route::get('/api/barang-keluar/', [BarangKeluarController::class, 'getAutoCompleteData']);
        Route::get('/barang-keluar/get-data', [BarangKeluarController::class, 'getDataBarangKeluar']);
        Route::get('/api/satuan/', [BarangKeluarController::class, 'getSatuan']);
        Route::resource('/barang-keluar', BarangKeluarController::class);

        Route::get('laporan/penyusutan', [BarangController::class, 'laporanPenyusutan'])->name('laporan.penyusutan');
        Route::get('laporan/data-penyusutan', [BarangController::class, 'data_penyusutan']);
        Route::get('laporan/print_penyusutan', [BarangController::class, 'print_data_penyusutan'])->name('laporan.print_penyusutan');
        // Tambahkan route untuk mendapatkan data penyusutan barang

    });


});

require __DIR__.'/auth.php';
