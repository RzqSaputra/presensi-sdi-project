<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CEO\DataPresensiCeoController;
use App\Http\Controllers\PM\DataPresensiController;
use App\Http\Controllers\PM\TaskKaryawanController;
use App\Http\Controllers\PM\KaryawanController;
use App\Http\Controllers\PM\ProfilPMController;
use App\Http\Controllers\PM\JabatanController;
use App\Http\Controllers\PM\PresensiPMController;
use App\Http\Controllers\PM\CetakLaporanController;
use App\Http\Controllers\Karyawan\RiwayatPresensiController;
use App\Http\Controllers\Karyawan\ProfilKaryawanController;
use App\Http\Controllers\Karyawan\PresensiController;
use App\Http\Controllers\Karyawan\TaskController;
use App\Http\Controllers\Karyawan\DetailTaskController;
use App\Http\Controllers\ExportController;
use App\Models\Presensi;
use Carbon\Carbon;

// Route::get('/export-view/{tanggalAwal}/{tanggalAkhir}', [ExportController::class, 'exportView'])->name('exportView');

    Route::get('/', function () {
        $today  = Carbon::today();
        $count  = DB::table('karyawans')->count();
        $izin   = Presensi::where('status', 2)->whereDate('tgl_presensi', $today)->count();
        $telat  = Presensi::where('status', 3)->whereDate('tgl_presensi', $today)->count();
        $alpa   = Presensi::where('status', 4)->whereDate('tgl_presensi', $today)->count();

        return view('index')->with([
            'title' => 'Sabang Digital Indonesia',
            'count' => $count,
            'izin' => $izin,
            'telat' => $telat,
            'alpa' => $alpa,
        ]);
    })->name('Dashboard')->middleware('auth');


    /* ----------------------------------------------- A U T H  ----------------------------------------------- */
    Route::get('login',     [AuthController::class, 'index'])->name('auth.index');
    Route::post('login',    [AuthController::class, 'login'])->name('auth.login');
    Route::get('daftar',    [AuthController::class, 'create'])->name('auth.daftar');
    Route::post('daftar',   [AuthController::class, 'store'])->name('auth.store');
    Route::post('logout',   [AuthController::class, 'logout'])->name('auth.logout');



Route::group(['middleware' => ['ceo']], function(){

    /* ----------------------------------------------- R O U T E - P R E S E N S I  ----------------------------------------------- */
    Route::prefix('dataPresensiCeo')->group(function() {
        Route::get('dataPresensiCeo',                                [DataPresensiCeoController::class, 'index'])->name('dataPresensi.karyawan');
        Route::get('dataPresensiCeo/{id}',                           [DataPresensiCeoController::class, 'detail'])->name('dataPresensiCeo.detail');
        Route::get('dataPresensiCeo/{tanggalAwal}/{tanggalAkhir}',   [DataPresensiCeoController::class, 'cetak'])->name('cetak');
    });
});


Route::group(['middleware' => ['pm']], function(){

    /* ----------------------------------------------- R O U T E - J A B A T A N  ----------------------------------------------- */
    Route::prefix('jabatan')->group(function() {
        Route::get ('jabatan',     'JabatanController@index')->name('jabatan');
        Route::post('jabatan',     'JabatanController@create')->name('jabatan.create');
        Route::post('update/{id}', 'JabatanController@update')->name('jabatan.update');
        Route::get ('delete/{id}', 'JabatanController@delete')->name('jabatan.delete');
    });

    /* ---------------------------------------- R O U T E - P R E S E N S I  P M---------------------------------------- */
    Route::prefix('presensiPM')->group(function() {
        Route::get('presensiPM',         [PresensiPMController::class, 'index'])->name('presensiPM.pm');
        Route::post('masuk',             [PresensiPMController::class, 'masuk'])->name('presensiPM.masuk');
        Route::get('sakit',              [PresensiPMController::class, 'sakit'])->name('presensiPM.sakit');
        Route::get('izin',               [PresensiPMController::class, 'izin'])->name('presensiPM.izin');
        Route::post('sakit/upload',      [PresensiPMController::class, 'uploadsakit'])->name('presensiPM.uploadsakit');
        Route::post('izin/upload',       [PresensiPMController::class, 'uploadizin'])->name('presensiPM.uploadizin');
        Route::post('pulang/{id}',       [PresensiPMController::class, 'pulang'])->name('presensiPM.pulang');
    });

    /* ---------------------------------------- R O U T E - R I W A Y A T  ---------------------------------------- */
    Route::prefix('riwayatPresensiPM')->group(function() {
        Route::get ('riwayatPresensi',       'RiwayatPresensiPMController@index')->name('riwayatPresensiPM');
        Route::get ('riwayatPresensi/{id}',  'RiwayatPresensiPMController@detail')->name('riwayatPresensiPM.detail');
        
    });

    /* ----------------------------------------------- R O U T E - K A R Y A W A N  ----------------------------------------------- */
    Route::prefix('karyawan')->group(function() {
        Route::get ('karyawan',          'KaryawanController@index')->name('karyawan');
        Route::post('karyawan',          'KaryawanController@create')->name('Karyawan.create');
        Route::post('update/{id}',       'KaryawanController@update')->name('Karyawan.update');
        Route::get ('delete/{id}',       'KaryawanController@delete')->name('Karyawan.delete');
        Route::get ('profile/{id}',      'KaryawanController@profil')->name('karyawan.profil');
        Route::post('password/{id}',     'KaryawanController@password')->name('karyawan.password');
        Route::post('image/upload/{id}', 'KaryawanController@image')->name('karyawan.image');
    });

    /* --------------------------------------------- R O U T E - P R E S E N S I  --------------------------------------------- */
    Route::prefix('dataPresensi')->group(function() {
        Route::get('dataPresensi',        'DataPresensiController@index')->name('dataPresensi');
        Route::post('dataPresensi',       'DataPresensiController@create')->name('dataPresensi.create');
        Route::post('update/{id}',        'DataPresensiController@update')->name('dataPresensi.update');
        Route::get('delete/{id}',         'DataPresensiController@delete')->name('dataPresensi.delete');
        Route::get('detailPresensi/{id}', 'DataPresensiController@detail')->name('dataPresensi.detail');
    });

    /* ------------------------------------------- R O U T E - T A S K  ------------------------------------------- */
    Route::prefix('taskKaryawan')->group(function() {
        Route::get ('taskKaryawan',         'TaskKaryawanController@index')->name('taskKaryawan');
        Route::post('taskKarywan',          'TaskKaryawanController@create')->name('taskKaryawan.create');
        Route::post ('edit/{id}',           'TaskKaryawanController@update')->name('taskKaryawan.update');
        Route::get ('delete/{id}',          'TaskKaryawanController@delete')->name('taskKaryawan.delete');
        Route::get ('taskKaryawan/detail/{id}',  'TaskKaryawanController@detail')->name('taskKaryawan.detail');
        Route::post ('taskKaryawan/done/{id}',  'TaskKaryawanController@done')->name('taskKaryawan.done');
        Route::post ('taskKaryawan/revisi/{id}',  'TaskKaryawanController@revisi')->name('taskKaryawan.revisi');
        Route::post ('taskKaryawan/selesai/{id}',  'TaskKaryawanController@selesai')->name('taskKaryawan.selesai');
    });

    /* ---------------------------------------- R O U T E - P R O F I L  ---------------------------------------- */
    Route::prefix('profilPM')->group(function() {
        Route::get ('profil',        'ProfilPMController@index')->name('profilPM');
        Route::post('update',        'ProfilPMController@update')->name('profilPM.update');
        Route::post('password',      'ProfilPMController@password')->name('profilPM.password');
        Route::post('image/upload',  'ProfilPMController@image')->name('profilPM.image');
    });

    /* ---------------------------------------- R O U T E - C E T A K  ---------------------------------------- */
    Route::prefix('cetak')->group(function() {
        Route::get('cetaklaporan/{tanggalAwal}/{tanggalAkhir}', 'CetakLaporanController@index')->name('cetakLaporan');
    });

});


Route::group(['middleware' => ['karyawan']], function () {

    /* ---------------------------------------- R O U T E - P R E S E N S I ---------------------------------------- */
    Route::prefix('presensi')->group(function() {
        Route::get('presensi',           [PresensiController::class, 'index'])->name('presensi.karyawan');
        Route::post('masuk',             [PresensiController::class, 'masuk'])->name('presensi.masuk');
        Route::get('sakit',              [PresensiController::class, 'sakit'])->name('presensi.sakit');
        Route::get('izin',               [PresensiController::class, 'izin'])->name('presensi.izin');
        Route::post('sakit/upload',      [PresensiController::class, 'uploadsakit'])->name('presensi.uploadsakit');
        Route::post('izin/upload',       [PresensiController::class, 'uploadizin'])->name('presensi.uploadizin');
        Route::post('pulang/{id}',       [PresensiController::class, 'pulang'])->name('presensi.pulang');
    });

    /* ---------------------------------------- R O U T E - R I W A Y A T  ---------------------------------------- */
    Route::prefix('riwayatPresensi')->group(function() {
        Route::get('riwayatPresensi',       [RiwayatPresensiController::class, 'index'])->name('riwayatPresensi');
        Route::get('riwayatPresensi/{id}',  [RiwayatPresensiController::class, 'detail'])->name('riwayatPresensi.detail');
    });

    /* ---------------------------------------- R O U T E - P R O F I L E ---------------------------------------- */
    Route::prefix('profilKaryawan')->group(function() {
        Route::get('profil',            [ProfilKaryawanController::class, 'index'])->name('profilKaryawan');
        Route::post('profil/update',    [ProfilKaryawanController::class, 'update'])->name('profilKaryawan.update');
        Route::post('profil/password',  [ProfilKaryawanController::class, 'password'])->name('profilKaryawan.password');
        Route::post('image/upload',     [ProfilKaryawanController::class, 'image'])->name('profilKaryawan.image');
    });

    /* ---------------------------------------- R O U T E - T A S K ---------------------------------------- */
    Route::prefix('task')->group(function() {
        Route::get('task',               [TaskController::class, 'index'])->name('task');
        Route::get('task/view',          [TaskController::class, 'view'])->name('task.view');
        Route::post('task/create',       [TaskController::class, 'create'])->name('task.create');
        Route::post('task/edit/{id}',    [TaskController::class, 'edit'])->name('task.edit');
    });

    /* ---------------------------------------- R O U T E - D E T A I L  T A S K ---------------------------------------- */
    Route::prefix('detailtask')->group(function() {
        Route::get('detailtask/lapor/{id}',         [DetailTaskController::class, 'lapor'])->name('detailtask.lapor');
        Route::post('detailtask/create/{task_id}',  [DetailTaskController::class, 'create'])->name('detailtask.create');
        Route::post('detailtask/done/{id}',         [DetailTaskController::class, 'done'])->name('detailtask.done');
        Route::post('detailtask/cancle/{id}',       [DetailTaskController::class, 'cancel'])->name('detailtask.cancel');
    });
    
});