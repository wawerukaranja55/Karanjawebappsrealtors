<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('name');
            $table->string('house_id')->after('phone');
            $table->string('id_number')->after('house_id');
            $table->boolean('is_admin')->default('0')->after('id_number');
            $table->boolean('is_approved')->default('0')->after('is_admin');
            $table->string('avatar')->default('default.jpg')->after('is_approved');
            $table->integer('role_id')->default('0')->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropcolumn('is_admin');
        });
    }
}
