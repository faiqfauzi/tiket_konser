<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tikets', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_tiket');
            $table->string('nama_konser');
            $table->date('tanggal_konser');
            $table->time('waktu_konser');
            $table->string('nama_penyanyi');
            $table->double('harga');
            $table->integer('stok');
            $table->string('tempat_duduk');
            $table->string('alamat');
            $table->string('panggung');
            $table->enum('ketersediaan', ['tersedia', 'tidak_tersedia'])->default('tersedia');
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
        Schema::dropIfExists('tickets');
    }
}
