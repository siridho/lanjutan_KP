<?php

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

// Auth::routes();


// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout');
// Registration Routes...
// Route::get('register', 'Auth\RegisterController@showRegistrationForm');
// Route::post('register', 'Auth\RegisterController@register');
// Route::get('konfirmasiemail/{email}/{salt}','FrontEndController@konfirmasiemail');
// Route::get('loadregencies/{id}','FrontEndController@loadregencies');
// Password Reset Routes...
Route::get('password/reset/{token?}', 'Auth\ResetPasswordController@showResetForm');
Route::post('password/email', 'Auth\ResetPasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
Route::get('/home', 'HomeController@index');
// Route::get('/', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@pilihproyek');
// Route::get('pilihproyek', 'HomeController@pilihproyek');
Route::post('/pilihproyekk', 'HomeController@pilihproyekk');
Route::get('/nodata', 'HomeController@nodata');
// Route::get('/', function () {
//     return view('index');
// });


// Route::post('customers/importcsv', 'customersController@importcsv');
//Route::post('materials/importcsv', 'materialsController@importcsv');
//Route::post('alats/importcsv', 'alatsController@importcsv');
//Route::post('gudangs/importcsv', 'gudangsController@importcsv');
// Route::post('jenis-pengeluaran-kas-proyeks/importcsv', 'jenisPengeluaranKasProyeksController@importcsv');
//Route::post('manager-proyeks/importcsv', 'managerProyeksController@importcsv');
// Route::post('mata-anggaran-proyeks/importcsv', 'mataAnggaranProyeksController@importcsv');
//Route::post('mitra-kerjas/importcsv', 'mitraKerjasController@importcsv');
//Route::post('proyeks/importcsv', 'proyeksController@importcsv');
// Route::post('standar-beli-material/importcsv', 'standarBeliMaterialController@importcsv');
// Route::post('standar-sewa-alat/importcsv', 'standarSewaAlatController@importcsv');
//Route::post('biaya-kas/importcsv', 'biayaKasController@importcsv');
// Route::post('jenis-biaya-proyeks/importcsv', 'JenisBiayaProyeksController@importcsv');

//=================================================== Impor Data ==================================================

Route::get('imporLapangan', 'HomeController@imporLapangan');
Route::post('imporLapangancsv', 'HomeController@imporLapangancsv');
Route::get('imporPusat', 'HomeController@imporPusat');
Route::post('imporPusatcsv', 'HomeController@imporPusatcsv');

//===================================================== End of Impor Data =========================================

//===================================================== Ekspor Data Acuan  Dan Transaksi=====================================================
Route::get('customers/exportcsv', 'customersController@exportcsv');
Route::get('users/exportcsv', 'usersController@exportcsv');
Route::get('materials/exportcsv', 'materialsController@exportcsv');
Route::get('alats/exportcsv', 'alatsController@exportcsv');
Route::get('gudangs/exportcsv', 'gudangsController@exportcsv');
Route::get('jenis-pengeluaran-kas-proyeks/exportcsv', 'jenisPengeluaranKasProyeksController@exportcsv');
Route::get('manager-proyeks/exportcsv', 'managerProyeksController@exportcsv');
Route::get('mata-anggaran-proyeks/exportcsv', 'mataAnggaranProyeksController@exportcsv');
Route::get('mitra-kerjas/exportcsv', 'mitraKerjasController@exportcsv');
Route::get('proyeks/exportcsv', 'proyeksController@exportcsv');
Route::get('standar-beli-material/exportcsv', 'standarBeliMaterialController@exportcsv');
Route::get('standar-sewa-alat/exportcsv', 'standarSewaAlatController@exportcsv');
Route::get('biaya-kas/exportcsv', 'biayaKasController@exportcsv');
Route::get('jenis-biaya-proyeks/exportcsv', 'JenisBiayaProyeksController@exportcsv');
Route::get('kelompok_kegiatans/exportcsv', 'Kelompok_kegiatansController@exportcsv');


Route::post('nota-beli-materials/exportcsv', 'NotaBeliMaterialsController@exportcsv');
Route::post('nota-pengeluaran-kass/exportcsv', 'NotaPengeluaranKassController@exportcsv');
Route::post('nota-penggunaan-materials/exportcsv', 'NotaPenggunaanMaterialsController@exportcsv');
Route::post('nota-terima-barangs/exportcsv', 'NotaTerimaBarangsController@exportcsv');
Route::post('nota-kas-masuk/exportcsv', 'NotaKasMasukController@exportcsv');
Route::post('memo_proyeks/exportcsv', 'Memo_proyeksController@exportcsv');
Route::post('opname-volume/exportcsv', 'Opname_volume_pekerjaansController@exportcsv');
Route::post('nota-penetralan-kasbon/exportcsv', 'NotaPengeluaranKassController@exportkasboncsv');


//===================================================== End Ekspor Data Acuan =====================================================

Route::get('notapengeluarankas', 'LapanganController@notapengeluarankas');

// penetralan kasbon
Route::get('penetralan-kasbon', 'NotaPengeluaranKassController@penetralankasbon');
Route::get('create-penetralan-kasbon', 'NotaPengeluaranKassController@createpenetralankasbon');
Route::post('penetralan-kasbon', 'NotaPengeluaranKassController@simpanpenetralankasbon');

Route::get('/tampilkasbon/{id}', 'NotaPengeluaranKassController@loadkasbon');
Route::get('/loadharga/{nonota}/{nobaris}', 'NotaPengeluaranKassController@loadharga');
Route::get('/loaduraian/{nonota}/{nobaris}', 'NotaPengeluaranKassController@loaduraian');

//================== ajax nota =======================
Route::get('/setjumlah/{id}', 'NotaPenggunaanMaterialsController@setjumlah');
Route::get('/loaddetail/{id}', 'NotaTerimaBarangsController@loaddetail');
Route::get('/loadtgl/{id}', 'NotaTerimaBarangsController@loadtgl');
Route::get('/loadmitra/{id}', 'NotaTerimaBarangsController@loadmitra');
Route::get('/getsatuan/{id}', 'NotaBeliMaterialsController@getsatuan');
Route::get('/getsatuankelompokkegiatan/{id}', 'Opname_volume_pekerjaansController@getsatuan');
Route::get('/rap/{id}', 'RapsController@tambahpekerjaan');
Route::get('/getsatuanbiaya/{id}', 'RapsController@getsatuanbiaya');
Route::post('/setsessionbiaya', 'RapsController@setsessionbiaya');
Route::get('/getisimodal/{id}', 'RapsController@getisimodal');
Route::get('/editrap/{nonota}/{kode_pekerjaan}', 'RapsController@editrap');
Route::post('/destroypekerjaan/{id}/{kerja}', 'RapsController@destroypekerjaan');
Route::get('/getmodalpekerjaan/{id}/{kerja}', 'RapsController@getmodalindex');
//====================== end of ajax nota =========================


//============ laporan ============

Route::get('rekapitulasi-material', 'materialsController@rekapitulasimaterial');
Route::get('rangkuman-material', 'materialsController@rangkumanmaterial');
Route::get('kartu-stok-material', 'materialsController@kartustokmaterial');
Route::get('/tampilStok/{id}', 'materialsController@tampilStok');
Route::get('rekapitulasi-penggunaan-material', 'materialsController@rekapitulasipenggunaanmaterial');
Route::get('/setrekapmaterial/{tgl}', 'materialsController@tampilrekap');
Route::get('/setrekapmaterialfoot/{tgl}', 'materialsController@tampilrekapfoot');
Route::get('/setrangkumanmaterial/{tgl}', 'materialsController@tampilrangkuman');
Route::get('/setrangkumanmaterialfoot/{tgl}', 'materialsController@tampilrangkumanfoot');
Route::get('/setpenggunaanmaterial/{tglaw}/{tglakh}', 'materialsController@tampilpenggunaan');
Route::get('/setpenggunaanmaterialtfoot/{tglaw}/{tglakh}', 'materialsController@tampilpenggunaantfoot');
Route::get('rekapitulasi-biaya', 'BiayaKasController@rekapitulasibiaya');
Route::get('rekapitulasi-biaya', 'BiayaKasController@rekapitulasibiaya');
Route::get('setrekapbiaya/{jenis}/{tgl}', 'BiayaKasController@tampilrekap');
Route::get('setrekapbiayafoot/{jenis}/{tgl}', 'BiayaKasController@tampilrekapfoot');
Route::get('transaksi-material', 'materialsController@transaksimaterial');
Route::get('transaksi-kas', 'BiayaKasController@transaksikas');
Route::get('/setdatamaterial/{tglaw}/{tglakh}', 'materialsController@tampiltransaksi');
Route::get('/setdatakas/{tglaw}/{tglakh}', 'BiayaKasController@tampiltransaksi');
Route::get('buku-kas', 'BiayaKasController@bukuKas');
Route::get('setbukukas/{tglaw}/{tglakh}', 'BiayaKasController@tampilbukukas');
Route::get('setbukukasfoot/{tglaw}/{tglakh}', 'BiayaKasController@tampilbukukasfoot');
Route::get('/setprogres/{tglaw}/{tglakh}', 'BiayaKasController@tampilprogresbiaya');
Route::get('/setprogresfoot/{tglaw}/{tglakh}', 'BiayaKasController@tampilprogresbiayafoot');
Route::get('rekapitulasi-progres-biaya', 'BiayaKasController@rekapitulasiprogresbiaya');
Route::get('rekap-rvm', 'RapsController@rekapmingguan');
Route::get('rekap-rbm', 'RapsController@rekapbiayamingguan');
//=========== end of laporan ==========

Route::get('inputulangbeli', 'NotaBeliMaterialsController@inputulang');
Route::get('itungstok', 'NotaTerimaBarangsController@itungstok');
Route::get('inputulangterima', 'NotaTerimaBarangsController@inputulang');
Route::get('inputulangpenggunaan', 'NotaPenggunaanMaterialsController@inputulang');

Route::get('/tampilStok/{id}', 'materialsController@tampilstok');
Route::get('/tampilStokFoot/{id}', 'materialsController@tampilstokfoot');

//===================================Laporan PDF=========================================
Route::get('printmaster/{nama}', 'HomeController@printmaster');
Route::get('printnota/{nama}/{kode}', 'HomeController@printnota');
Route::get('printrap/{kode}', 'HomeController@printrap');
Route::get('rekapmaterial/{tgl}/', 'HomeController@rekapmaterialpdf');
Route::get('rangkummaterial/{tgl}/', 'HomeController@rangkumanmaterialpdf');
Route::get('transaksimaterial/{tglaw}/{tglakh}', 'HomeController@transaksimaterialpdf');
Route::get('bukukaspdf/{tglaw}/{tglakh}', 'HomeController@bukukaspdf');
Route::get('kartustokpdf/{kode}/', 'HomeController@kartustokpdf');
Route::get('rekappenggunaanpdf/{tglaw}/{tglakh}', 'HomeController@rekappenggunaanpdf');
Route::get('rekapkaspdf/{tgl}/{jenis}', 'HomeController@rekapkaspdf');
Route::get('transaksikas/{tglaw}/{tglakh}', 'HomeController@transaksikaspdf');
Route::get('rekapprogresbiayapdf/{tglaw}/{tglakh}', 'HomeController@rekapprogresbiayapdf');
//===================================End of Laporan PDF========================================

Route::resource('customers', 'customersController');
Route::resource('manager-proyeks', 'managerProyeksController');
Route::resource('proyeks', 'proyeksController');
Route::resource('mata-anggaran-proyeks', 'mataAnggaranProyeksController');
Route::resource('materials', 'materialsController');
Route::resource('alats', 'alatsController');
Route::resource('mitra-kerjas', 'mitraKerjasController');
Route::resource('gudangs', 'gudangsController');
Route::resource('jenis-pengeluaran-kas-proyeks', 'jenisPengeluaranKasProyeksController');
Route::resource('standar-beli-material', 'standarBeliMaterialController');
Route::resource('standar-sewa-alat', 'standarSewaAlatController');
Route::resource('detail-pengeluaran-kass', 'DetailPengeluaranKassController');
Route::resource('nota-beli-materials', 'NotaBeliMaterialsController');
Route::resource('detail-beli-materials', 'DetailBeliMaterialsController');
Route::resource('jenis-biaya-proyeks', 'JenisBiayaProyeksController');
Route::resource('biaya-kas', 'BiayaKasController');
Route::resource('material-gudangs', 'MaterialGudangsController');
Route::resource('nota-penggunaan-materials', 'NotaPenggunaanMaterialsController');
Route::resource('detail-penggunaan-materials', 'DetailPenggunaanMaterialsController');
Route::resource('nota-pengeluaran-kass', 'NotaPengeluaranKassController');
Route::resource('nota-terima-barangs', 'NotaTerimaBarangsController');
Route::resource('users', 'usersController');
Route::resource('nota-kas-masuk', 'NotaKasMasukController');
Route::resource('detail-nota-kas-masuk', 'DetailNotaKasMasukController');

Route::resource('akuns', 'AkunsController');
Route::resource('rekenings', 'RekeningsController');
Route::resource('kelompok_asets', 'Kelompok_asetsController');
Route::resource('personal_manajemens', 'Personal_manajemensController');
Route::resource('memo_proyeks', 'Memo_proyeksController');

Route::resource('detail_memo_proyeks', 'Detail_memo_proyeksController');
Route::resource('kelompok_kegiatans', 'Kelompok_kegiatansController');
Route::resource('opname_volume_pekerjaans', 'Opname_volume_pekerjaansController');
Route::resource('detail_opname_pekerjaans', 'Detail_opname_pekerjaansController');
Route::resource('raps', 'RapsController');

Auth::routes();

