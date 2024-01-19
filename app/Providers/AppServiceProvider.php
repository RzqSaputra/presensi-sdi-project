<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use App\Models\Presensi;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config(['app,locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_Set('Asia/jakarta');
        Paginator::useBootstrap();

        View::composer('template/sidebar', function ($view) {
            // Di sini Anda bisa mengambil data $presensi dari database atau sumber lainnya
            // Misalnya, ambil data presensi berdasarkan user yang sedang login
            $today = Carbon::now()->toDateString();
            $userId = auth()->user()->id;
            $presensi = Presensi::where('user_id', $userId)->latest('id')->
            where('tgl_presensi', $today)->first();

            // Kemudian, bagikan data $presensi ke view
            $view->with('presensi', $presensi);
        });
    }
}
