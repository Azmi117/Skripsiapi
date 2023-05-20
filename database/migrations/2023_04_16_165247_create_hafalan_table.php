<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hafalan', function (Blueprint $table) {
            $table->id();
            $table->string('surah');
            $table->string('juz');
            $table->string('ayat');
            $table->integer('status');
            $table->unsignedBigInteger('id_kelas');
            $table->unsignedBigInteger('id_murid');
            $table->unsignedBigInteger('id_penyetor')->nullable();
            $table->timestamps();
            $table->softDeletes();

           // $table->foreign('id_kelas')->references('id')->on('kelas');
            //$table->foreign('id_murid')->references('id')->on('murid');
            //$table->foreign('id_penyetor')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hafalan');
    }
};
