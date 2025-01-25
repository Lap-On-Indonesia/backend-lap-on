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
        Schema::create('products', function (Blueprint $table) {
            $table->string('product_id')->unique()->primary();
            $table->string('name_product');
            $table->string('image');
            $table->foreignId('category_marketplace_id');
            $table->foreign('category_marketplace_id')->references('id')->on('category_marketplaces')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0); // Menambahkan field stock
            $table->timestamps();
            $table->softDeletes();
        });

        // Menambahkan kolom owner_marketplace_id jika belum ada
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'owner_marketplace_id')) {
                $table->foreignId('owner_marketplace_id')->nullable();
                $table->foreign('owner_marketplace_id')->references('id')->on('owner_marketplaces')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'owner_marketplace_id')) {
                $table->dropForeign(['owner_marketplace_id']);
                $table->dropColumn('owner_marketplace_id');
            }
        });

        Schema::dropIfExists('products');
    }
};
