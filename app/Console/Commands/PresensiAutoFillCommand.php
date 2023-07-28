<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Presensi;
use App\Models\User;
use Illuminate\Console\Command;

class PresensiAutoFillCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'presensi:autofill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Autofill presensi for all users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today();
        $users = User::all();

        foreach ($users as $user) {
            Presensi::create([
                'user_id' => $user->id,
                'tgl_presensi' => $today,
                'status' => 4, // Alfa
                'keterangan' => 'Tidak hadir'
            ]);
        }
        Log::info('PresensiAutoFill command is executed.');

        $this->info('Presensi autofill completed.');
    }
}
