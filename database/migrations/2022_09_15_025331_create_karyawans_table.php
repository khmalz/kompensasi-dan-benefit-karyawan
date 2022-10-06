<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->string('nik');
            $table->primary('nik');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('nama');
            $table->string('status');
            $table->string('lokasi');
            $table->date('tanggal_masuk');
            $table->integer('tunjangan_kesehatan')->default(5000000);
            $table->integer('tunjangan_pernikahan')->default(2500000);
            $table->integer('tunjangan_bencana')->default(5000000);
            $table->integer('tunjangan_kematian')->default(10000000);
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
        Schema::dropIfExists('karyawans');
    }
}
