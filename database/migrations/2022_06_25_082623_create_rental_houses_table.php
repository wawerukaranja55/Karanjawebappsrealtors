<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateRentalHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_houses', function (Blueprint $table) {
            $table->id();
            $table->string('rental_name');
            $table->string('rental_slug');
            $table->string('rental_address');
            $table->integer('monthly_rent');
            $table->text('rental_details');
            $table->string('rental_image');
            $table->string('rental_video')->nullable();
            $table->integer('rentalcat_id');
            $table->integer('location_id');
            $table->integer('landlord_id');
            $table->boolean('is_rentable')->default('0');
            $table->boolean('rental_status')->default('1');
            $table->boolean('is_addedtags')->default('0');
            $table->boolean('is_extraimages')->default('0');
            $table->string('is_featured')->default('no');
            $table->integer('total_rooms');
            $table->boolean('is_vacancy')->default('1');
            $table->string('wifi')->default('no');
            $table->string('generator')->default('no');
            $table->string('balcony')->default('no');
            $table->string('parking')->default('no');
            $table->string('cctv_cameras')->default('no');
            $table->string('servant_quarters')->default('no');
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
        Schema::dropIfExists('rental_houses');
    }
}
