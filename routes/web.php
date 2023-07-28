<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PM\JabatanController;
use App\Http\Controllers\PM\KaryawanController;
use App\Http\Controllers\PM\DataPresensiController;
use App\Http\Controllers\PM\TaskKaryawanController;
use App\Http\Controllers\PM\ProfilPMController;

use App\Http\Controllers\ProjectManagerController;

use App\Models\Presensi;
use Carbon\Carbon;

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


    // Auth
    Route::get('login',     [AuthController::class, 'index'])->name('auth.index');
    Route::post('login',    [AuthController::class, 'login'])->name('auth.login');
    Route::get('daftar',    [AuthController::class, 'create'])->name('auth.daftar');
    Route::post('daftar',   [AuthController::class, 'store'])->name('auth.store');
    Route::post('logout',   [AuthController::class, 'logout'])->name('auth.logout');


    Route::group(['middleware' => ['pm']], function(){
        Route::post('/upload/photo',            [ProjectManagerController::class, 'uploadPhoto'])->name('upload.photo');
        
        //Route Project Manager
        Route::get ('pm',                       [ProjectManagerController::class, 'pm'])->name('pm');
        Route::post('pm',                       [ProjectManagerController::class, 'createPm'])->name('pm.createPm');
        Route::post('pm/update/{id}',           [ProjectManagerController::class, 'updatePm'])->name('pm.updatePm');
        Route::get ('pm/delete/{id}',           [ProjectManagerController::class, 'deletePm'])->name('pm.deletePm');
        Route::post ('pm/passwordupdate/{id}',  [ProjectManagerController::class, 'updatePmPassword'])->name('pegawai.updatePmPassword');

       
    });

    //Route Profil
    Route::group(['middleware' => ['karyawan']], function () {
        Route::get('/profil',                   [MenuPegawaiController::class, 'index'])->name('profil.index');
        Route::post('/profil/PUpdate/{id}',     [MenuPegawaiController::class, 'PUpdate'])->name('PUpdate');
        Route::post('crop',                     [MenuPegawaiController::class, 'crop'])->name('crop');
        Route::post('/profil/update-pass',      [MenuPegawaiController::class, 'updatePassword'])->name('profil.updatePassword');

        
        //Route MenuPegawai
        //Task Harian
        Route::get('task',                  [MenuPegawaiController::class, 'task'])->name('pegawai.task');
        Route::post('task',                 [MenuPegawaiController::class, 'tambahTaskHarian'])->name('pegawai.tambahTaskHarian');
        Route::post('/task/update/{id}',    [MenuPegawaiController::class, 'updateTask'])->name('task.updateTask');
        Route::get('/task/delete/{id}',     [MenuPegawaiController::class, 'deleteTask'])->name('pegawai.deleteTask');
        
        
        //Task Mingguan
        Route::get('taskMingguan',              [MenuPegawaiController::class, 'task_mingguan'])->name('pegawai.task_mingguan');
        Route::post('taskMingguan',             [MenuPegawaiController::class, 'tambahTaskMingguan'])->name('pegawai.tambahTaskMingguan');
        Route::post('/taskM/update/{id}',       [MenuPegawaiController::class, 'updateTaskM'])->name('task.updateTaskM');
        Route::get('/taskM/delete/{id}',        [MenuPegawaiController::class, 'deleteTaskM'])->name('pegawai.deleteTaskM');
        
        
        //Presensi
        Route::get('presensi',              [MenuPegawaiController::class, 'presensi'])->name('pegawai.presensi');
        Route::post('masuk',                [PresensiController::class, 'masuk'])->name('presensi.masuk');
        Route::put('pulang/{presensi}',     [PresensiController::class, 'pulang'])->name('presensi.pulang');
    });


    Route::get('/ip', function(){
        $location = Location::get();
        dd($location);
    });


Route::group(['middleware' => ['pm']], function(){

     /* ----------------------------------------------- R O U T E - J A B A T A N  ----------------------------------------------- */
    Route::prefix('jabatan')->group(function() {
        Route::get ('jabatan',     'JabatanController@index')->name('jabatan');
        Route::post('jabatan',     'JabatanController@create')->name('jabatan.create');
        Route::post('update/{id}', 'JabatanController@update')->name('jabatan.update');
        Route::get ('delete/{id}', 'JabatanController@delete')->name('jabatan.delete');
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
        Route::get ('taskKaryawan',  'TaskKaryawanController@index')->name('taskKaryawan');
        Route::get ('edit/{id}',     'TaskKaryawanController@update')->name('taskKaryawan.update');
    });

     /* ---------------------------------------- R O U T E - P R O F I L  ---------------------------------------- */
    Route::prefix('profilPM')->group(function() {
        Route::get ('profil',        'ProfilPMController@index')->name('profilPM');
        Route::post('update',        'ProfilPMController@update')->name('profilPM.update');
        Route::post('password',      'ProfilPMController@password')->name('profilPM.password');
        Route::post('image/upload',  'ProfilPMController@image')->name('profilPM.image');
    });
    
});