<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkumulasiPoin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akumulasi_poin', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_member')->nullable();
            $table->string('no_hp', 20);
            $table->string('batch', 20);
            $table->timestamps();

            $table->index('no_hp', 'plain_index_akumulasi_poin_no_hp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akumulasi_poin');
    }
}
