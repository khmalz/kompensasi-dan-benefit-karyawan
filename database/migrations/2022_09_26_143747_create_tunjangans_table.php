<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTunjangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tunjangans', function (Blueprint $table) {
            $table->string('kode');
            $table->primary('kode');
            $table->string('karyawan_nik');
            $table->foreign('karyawan_nik')->references('nik')->on('karyawans')->onDelete('cascade');
            $table->string('jenis_tunjangan');
            $table->integer('besar_tunjangan');
            $table->string('status');
            $table->string('pesan');
            $table->string('bukti');
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
        Schema::dropIfExists('tunjangans');
    }
}
