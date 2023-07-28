<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('tgl_presensi');
            $table->time('jam_masuk')->nullable();
            $table->string('foto_masuk')->nullable();
            $table->string('lokasi_masuk')->nullable();
            $table->time('jam_pulang')->nullable(); 
            $table->string('foto_pulang')->nullable();
            $table->string('lokasi_pulang')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('ket')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presensis');
    }
}
