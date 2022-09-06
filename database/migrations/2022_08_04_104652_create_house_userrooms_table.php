<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouseUserroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('house_userrooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rentalroom_id');
            $table->foreign('rentalroom_id')->references('id')->on('room_names')->onDelete('cascade');
            $table->unsignedBigInteger('userhse_id');
            $table->foreign('userhse_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('house_userrooms');
    }
}
