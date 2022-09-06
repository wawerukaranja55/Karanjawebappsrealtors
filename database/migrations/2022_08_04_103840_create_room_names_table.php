<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_names', function (Blueprint $table) {
            $table->id();
            $table->integer('rentalhouse_id');
            $table->string('room_name');
            $table->string('house_size')->nullable();
            $table->integer('status')->default(1);
            $table->integer('is_occupied')->default(0);
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
        Schema::dropIfExists('room_names');
    }
}
