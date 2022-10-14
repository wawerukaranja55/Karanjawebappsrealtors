<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('property_name');
            $table->string('property_slug');
            $table->string('property_address');
            $table->integer('propertylocation_id');
            $table->integer('property_price');
            $table->string('property_image');
            $table->string('property_video')->nullable();
            $table->boolean('property_isactive')->default('0');
            $table->boolean('property_isavailable')->default('1');
            $table->text('property_details');
            $table->integer('propertycat_id');
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
        Schema::dropIfExists('properties');
    }
}
