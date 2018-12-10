<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriksaPasiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periksa_pasiens', function (Blueprint $table) {
            $table->increments('id_periksa');
            $table->bigInteger('pasien_kode');
            $table->date('tanggal_periksa');
            $table->text('diagnosa');
            $table->text('obat');
            $table->text('catatan');
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
        Schema::dropIfExists('periksa_pasiens');
    }
}
