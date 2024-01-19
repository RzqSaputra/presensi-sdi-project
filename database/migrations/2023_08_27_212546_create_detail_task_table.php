<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_task', function (Blueprint $table) {
            $table->id();
           $table->foreignId('task_id')
                ->constrained('tasks')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('kegiatan')->nullable();
            $table->integer('status')->nullable();
            $table->time('mulai')->nullable();
            $table->time('selesai')->nullable();
            $table->string('ket')->nullable();
            $table->string('bukti')->nullable();
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
        Schema::dropIfExists('detail_task');
    }
}
