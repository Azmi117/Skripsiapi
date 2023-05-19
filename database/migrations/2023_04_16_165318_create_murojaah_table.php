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
        Schema::create('murojaah', function (Blueprint $table) {
            $table->id();
            $table->string('surah');
            $table->string('juz');
            $table->string('ayat');
            $table->unsignedBigInteger('id_kelas');
            $table->timestamps();
            $table->softDeletes();

           // $table->foreign('id_kelas')->references('id')->on('kelas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('murojaah');
    }
};
