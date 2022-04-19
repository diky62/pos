<?php

// use App\Http\Controllers\{
//     Admin\DashboardController,

// };
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\{
    KategoriController,
    ProdukController,
    PengeluaranController,
    BarangMasukController,
    UserController,
    SettingController,
    TransaksiController,
    DataTransaksiTunaiController,
    TransaksiUtangController,
    DataTransaksiUtangController,
};
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
    return view('auth/login');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware'=>'auth'],function(){   
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
	// Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
	Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
    Route::resource('/kategori', KategoriController::class);
	// Route::get('\dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/pengeluaran/data', [PengeluaranController::class, 'data'])->name('pengeluaran.data');
    Route::resource('/pengeluaran', PengeluaranController::class);

	Route::get('/produk/data', [ProdukController::class, 'data'])->name('produk.data');
    Route::post('/produk/delete-selected', [ProdukController::class, 'deleteSelected'])->name('produk.delete_selected');
    Route::post('/produk/cetak-barcode', [ProdukController::class, 'cetakBarcode'])->name('produk.cetak_barcode');
    Route::resource('/produk', ProdukController::class);

    Route::get('/barang_masuk/data', [BarangMasukController::class, 'data'])->name('barang_masuk.data');
    Route::resource('/barang_masuk', BarangMasukController::class);

    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::get('/setting/first', [SettingController::class, 'show'])->name('setting.show');
    Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');

    Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
    Route::resource('/user', UserController::class);

    Route::get('/profil', [UserController::class, 'profil'])->name('user.profil');
    Route::post('/profil', [UserController::class, 'updateProfil'])->name('user.update_profil');

    Route::get('/transaksi/data', [TransaksiController::class, 'data'])->name('transaksi.data');
    Route::get('/transaksi/selesai', [TransaksiController::class, 'selesai'])->name('transaksi.selesai');
    Route::get('/transaksi/nota-kecil', [TransaksiController::class, 'notaKecil'])->name('transaksi.nota_kecil');;
    Route::get('/transaksi/nota-besar', [TransaksiController::class, 'notaBesar'])->name('transaksi.nota_besar');
    Route::get('/transaksi', 'Transaksiontroller@index')->name('transaksi');
    Route::resource('/transaksi', TransaksiController::class);

    Route::get('/data_transaksi_tunai/data', [DataTransaksiTunaiController::class, 'data'])->name('data_transaksi_tunai.data');
    Route::resource('/data_transaksi_tunai', DataTransaksiTunaiController::class);

    Route::get('/transaksi_utang/data', [TransaksiUtangController::class, 'data'])->name('transaksi_utang.data');
    Route::get('/transaksi_utang/selesai', [TransaksiUtangController::class, 'selesai'])->name('transaksi_utang.selesai');
    Route::get('/transaksi_utang/nota-kecil', [TransaksiUtangController::class, 'notaKecil'])->name('transaksi_utang.nota_kecil');;
    Route::get('/transaksi_utang/nota-besar', [TransaksiUtangController::class, 'notaBesar'])->name('transaksi_utang.nota_besar');
    Route::get('/transaksi_utang', 'TransaksiUtangController@index')->name('transaksi');
    Route::resource('/transaksi_utang', TransaksiUtangController::class);

    Route::get('/data_transaksi_utang/data', [DataTransaksiUtangController::class, 'data'])->name('data_transaksi_utang.data');
    Route::resource('/data_transaksi_utang', DataTransaksiUtangController::class);
    Route::get('/data_transaksi_utang/{id}', [DataTransaksiUtangController::class, 'detail'])->name('data_transaksi_utang.detail');
    
    
    // Route::resource('/carts/{carts}', CartsController::class);

    Route::get('/cart', [CartsController::class, 'store'])->name('cart.store');
    // Route::resource('/cart',CartsController::class);
    Route::patch('/cart/{cart}',[CartsController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}',[CartsController::class, 'destroy'])->name('cart.destroy');
    // Route::post('/transaction', 'TransactionController@store')->name('transaction.store');


 //    Route::post('/cart', CartsController::class, 'store')->name('cart.store');
	// // Route::post('/cart', CartsController@store:class)->name('cart.store');
	// Route::patch('/cart/{cart}', 'CartsController@update')->name('cart.update');
	// Route::delete('/cart/{cart}', 'CartsController@destroy')->name('cart.destroy');

    
});
