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

use App\Http\Controllers\Suplier;

Route::get('/', 'Home@index');
Route::get('/registrasi', 'Registrasi@index');
Route::post('/simpanRegis', 'Registrasi@registrasi');

Route::get('/login', 'Suplier@index');
Route::post('/loginSup', 'Suplier@loginSuplier');
Route::post('/password', 'Suplier@password');
Route::get('/logout', 'Suplier@logoutSuplier');
Route::get('/listSup', 'Suplier@listSuplier');
Route::get('/nonAktif/{id}', 'Suplier@nonAktif');
Route::get('/Aktif/{id}', 'Suplier@Aktif');

Route::get('/loginAdmin', 'Admin@index');
Route::post('/pageAdmin', 'Admin@loginAdmin');
Route::post('/registrasiAdmin', 'Admin@registrasiAdmin');
Route::post('/updateAdmin', 'Admin@updateAdmin');
Route::get('/logoutAdmin', 'Admin@logoutAdmin');
Route::get('/listAdmin', 'Admin@listAdmin');
Route::get('/deleteAdmin/{id}', 'Admin@deleteAdmin');
Route::post('/passwordAdm', 'Admin@passwordAdm');


Route::get('/pengajuan', 'Pengajuan@pengajuan');

Route::get('/listPengadaan', 'Pengadaan@index');
Route::post('/tambahPengadaan', 'Pengadaan@tambahPengadaan');
Route::post('/uploadGambar', 'Pengadaan@uploadGambar');
Route::get('/hapusGambar/{id}', 'Pengadaan@hapusGambar');
Route::get('/hapusPengadaan/{id}', 'Pengadaan@hapusPengadaan');
Route::post('/updatePengadaan', 'Pengadaan@updatePengadaan');
Route::get('/listSuplier', 'Pengadaan@listSuplier');
Route::get('/tolakLaporan/{id}', 'Pengadaan@tolakLaporan');

Route::post('/tambahPengajuan', 'Pengajuan@tambahPengajuan');
Route::get('/terimaPengajuan/{id}', 'Pengajuan@terimaPengajuan');
Route::get('/selesaiPengajuan/{id}', 'Pengajuan@selesaiPengajuan');
Route::get('/tolakPengajuan/{id}', 'Pengajuan@tolakPengajuan');
Route::get('/laporan', 'Pengajuan@laporan');
Route::get('/history', 'Pengajuan@history');
Route::post('/tambahLaporan', 'Pengajuan@tambahLaporan');
Route::get('/pengajuanSelesai', 'Pengajuan@pengajuanSelesai');


