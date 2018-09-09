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

Route::get('/', function () {
    return view('admin.index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/tes', 'PasienController@age');

Route::get('pasien/data', 'PasienController@listData')->name('pasien.data');
Route::resource('pasien', 'PasienController');

Route::get('periksa/data', 'PeriksaController@listData')->name('periksa.data');
Route::get('periksa/{kode}/dataPeriksa', 'PeriksaController@listDataPeriksa')->name('periksa.dataPeriksa');
Route::get('periksa/{kode}/showHasil', 'PeriksaController@showHasil');
Route::patch('periksa/{kode}/update', 'PeriksaController@update');
Route::resource('periksa', 'PeriksaController');
Route::get('periksa/{kode}', 'PeriksaController@show');

Route::post('periksa/{kode}/riwayat', 'RiwayatPenyakitController@store');
Route::get('periksa/{kode}/editRiwayat', 'RiwayatPenyakitController@edit');
Route::patch('periksa/{kode}/updateRiwayat', 'RiwayatPenyakitController@update');
