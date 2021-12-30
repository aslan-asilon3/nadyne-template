<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnicharmMemberRaw extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unicharm_member_raw', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_member');
            $table->string('no_hp');
            $table->string('status_cek_data', 1)->nullable();
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
        Schema::dropIfExists('unicharm_member_raw');
    }
}
