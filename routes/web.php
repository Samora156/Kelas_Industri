<?php

use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Auth;
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
// admin

// Route::group(['first', 'second'])->group(function () {
//     Route::get('/', function () {
//         // Uses first & second middleware...
//     });
 
//     Route::get('/user/profile', function () {
//         // Uses first & second middleware...
//     });
// });



// login
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/', [LoginController::class, 'index'])->name('tes');
Route::post('/email', [LoginController::class, 'email']);
Route::post('/action', [LoginController::class, 'login']);

Route::get('/signUp', [LoginController::class, 'register']);
Route::post('/register/action', [LoginController::class, 'register_action']);

Route::post('forget-password', [LoginController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password', [LoginController::class, 'showResetPasswordForm'])->name('reset.password.get');
// Route::post('reset-password', [LoginController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::get('logout', [LoginController::class, 'logout'])->name('actionlogout')->middleware('auth');


// siswa
Route::get('admin/siswa/export', [SiswaController::class, 'export']);
Route::get('/admin/siswa/excel', [SiswaController::class, 'excel']);
Route::get('/admin/siswa/pilih_excel/id_siswa={id}', [SiswaController::class, 'excelPilih']);
Route::post('/admin/siswa/coba', [SiswaController::class, 'pdfPilih']);
Route::post('admin/import/siswa', [SiswaController::class, 'import']);

Route::post('admin/siswa/kelas', [SiswaController::class, 'kelas']);
Route::post('admin/siswa/angkatan', [SiswaController::class, 'angkatan']);
Route::post('admin/siswa/data', [SiswaController::class, 'data']);
Route::resource('admin/siswa', SiswaController::class)->middleware('auth');
Route::post('admin/siswa/update', [SiswaController::class, 'updateAngkatan']);
Route::post('admin/siswa/hapus', [SiswaController::class, 'hapusSiswa']);
Route::delete('delete-student/{id}', [SiswaController::class, 'destroy']);
Route::post('admin/siswa/edit/{id}', [SiswaController::class, 'edit']);
Route::post('update', [SiswaController::class, 'update']);

// kelas
Route::post('admin/kelas/data', [KelasController::class, 'data']);
Route::post('admin/kelas/data/jumlah', [KelasController::class, 'jumlah']);
Route::resource('admin/kelas', KelasController::class)->middleware('auth');
Route::delete('delete/kelas/{id}', [KelasController::class, 'destroy']);
Route::post('admin/kelas/edit/{id}', [KelasController::class, 'edit']);
Route::post('update/kelas', [KelasController::class, 'update']);

// guru
Route::get('admin/guru/export', [GuruController::class, 'export']);
Route::get('/admin/guru/excel', [GuruController::class, 'excel']);
Route::get('/admin/guru/pilih_excel/id_guru={id}', [GuruController::class, 'excelPilih']);
Route::post('/admin/guru/coba', [GuruController::class, 'pdfPilih']);
Route::post('admin/import/guru', [GuruController::class, 'import']);

Route::post('admin/guru/kelas', [GuruController::class, 'kelas']);
Route::post('admin/guru/data', [GuruController::class, 'data']);
Route::resource('admin/guru', GuruController::class)->middleware('auth');
Route::post('admin/guru/hapus', [GuruController::class, 'hapusGuru']);
Route::delete('delete/guru/{id}', [GuruController::class, 'destroy']);
Route::post('admin/guru/edit/{id}', [GuruController::class, 'edit']);
Route::post('update/guru', [GuruController::class, 'update']);

// sekolah
Route::post('admin/sekolah/data', [SekolahController::class, 'data']);
Route::post('admin/sekolah/jumlah', [SekolahController::class, 'jumlah']);
Route::resource('admin/sekolah', SekolahController::class)->middleware('auth');
Route::delete('delete/sekolah/{id}', [SekolahController::class, 'destroy']);
Route::get('amdin/sekolah/{id}', [SekolahController::class, 'show']);
Route::post('admin/kelas/tambah', [KelasController::class, 'store']);
Route::post('admin/sekolah/edit/{id}', [SekolahController::class, 'edit']);
Route::post('update/sekolah', [SekolahController::class, 'update']);

// -------------------------------------------------------------------------

// Guru
Route::get('guru/index', [GuruController::class, 'tampilan']);
Auth::routes();
