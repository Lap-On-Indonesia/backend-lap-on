<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('owner_marketplace_id')->nullable();

            // Jika Anda ingin menggunakan relasi foreign key
            $table->foreign('owner_marketplace_id')
                ->references('product_id')
                ->on('owner_marketplaces')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['owner_marketplace_id']);
            $table->dropColumn('owner_marketplace_id');
        });
    }
};
