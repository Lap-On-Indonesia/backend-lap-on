<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('transaction_id')->nullable()->after('id');
        });

        Schema::table('transaction_marketplaces', function (Blueprint $table) {
            $table->string('transaction_id')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
        });

        Schema::table('transaction_marketplaces', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
        });
    }
};
