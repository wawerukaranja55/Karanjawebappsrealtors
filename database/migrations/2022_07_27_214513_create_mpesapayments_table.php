<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMpesapaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpesapayments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('tenant_name');
            $table->string('phone')->nullable();
            $table->integer('amount')->nullable();
            $table->boolean('mpesastatus')->default(0);
            $table->string('callbackurlrequest_id');
            $table->string('mpesatransaction_id')->nullable();
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
        Schema::dropIfExists('mpesapayments');
    }
}
