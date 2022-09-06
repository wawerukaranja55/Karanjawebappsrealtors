<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouseratingreviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houseratingreviews', function (Blueprint $table) {
            $table->id();
            $table->boolean('rating_isactive')->default('0');
            $table->text('house_review');
            $table->integer('house_rating');
            $table->integer('user_id');
            $table->integer('hse_id');
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
        Schema::dropIfExists('houseratingreviews');
    }
}
