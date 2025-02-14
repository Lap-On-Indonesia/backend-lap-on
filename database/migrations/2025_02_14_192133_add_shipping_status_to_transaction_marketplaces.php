<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('transaction_marketplaces', function (Blueprint $table) {
            $table->string('shipping_status')->default('Menunggu konfirmasi')->after('status');
        });
    }

    public function down()
    {
        Schema::table('transaction_marketplaces', function (Blueprint $table) {
            $table->dropColumn('shipping_status');
        });
    }
};

