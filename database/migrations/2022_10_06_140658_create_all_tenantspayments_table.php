<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTenantspaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('all_tenantspayments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('transactiontype_id');
            $table->string('receipt_number');
            $table->string('rental_name');
            $table->integer('total_rent');
            $table->integer('amount_paid');
            $table->integer('total_arrears')->default(0);
            $table->integer('overpaid_amount')->default(0);
            $table->string('date_paid');
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
        Schema::dropIfExists('all_tenantspayments');
    }
}
