<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('photo_ktp')->nullable();
            $table->string('no_rekening')->nullable();
            $table->enum('status', ['pending', 'accept', 'reject'])->nullable();
            $table->string('store_name')->nullable();
            $table->string('address_store')->nullable();
            $table->string('link_maps')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['photo_ktp', 'no_rekening', 'status', 'store_name', 'address_store', 'link_maps']);
        });
    }
}

