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


Auth::routes();
$this->get('logout', 'Auth\LoginController@logout');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');


//admin
Route::group(['middleware' => ['web', 'cekuser:1']], function(){
  // Route::get('/', function () {
  //   return view('admin.index');
  // });
  Route::get('pasien/data', 'PasienController@listData')->name('pasien.data');
  Route::resource('pasien', 'PasienController');

  Route::get('arsip/data', 'ArsipController@listData')->name('arsip.data');
  Route::get('arsip/{id}/print', 'ArsipController@printPasien');
  Route::resource('arsip', 'ArsipController');

  Route::get('dokter/data', 'AdminController@listData')->name('dokter.data');
  Route::resource('dokter', 'AdminController');

  Route::resource('setting', 'SettingController');
});


//dokter
Route::group(['middleware' => ['web', 'cekuser:2']], function(){
  // Route::get('/', function () {
  //   return view('dokter.index');
  // });
  Route::get('periksa/data', 'PeriksaController@listData')->name('periksa.data');
  Route::get('periksa/{kode}/dataPeriksa', 'PeriksaController@listDataPeriksa')->name('periksa.dataPeriksa');
  Route::get('periksa/{kode}/showHasil', 'PeriksaController@showHasil');
  Route::patch('periksa/{kode}/update', 'PeriksaController@update');
  Route::resource('periksa', 'PeriksaController');
  Route::get('periksa/{kode}', 'PeriksaController@show');

  Route::post('periksa/{kode}/riwayat', 'RiwayatPenyakitController@store');
  Route::get('periksa/{kode}/editRiwayat', 'RiwayatPenyakitController@edit');
  Route::patch('periksa/{kode}/updateRiwayat', 'RiwayatPenyakitController@update');
  //Route::post('periksa/{kode}/updateRiwayat', 'RiwayatPenyakitController@store');
});

Route::get('/tes', 'PasienController@age');
