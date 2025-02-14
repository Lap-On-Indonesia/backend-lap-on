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
        Schema::create('owner_marketplaces', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('email', 50)->unique();
            $table->string('phone', 16);
            $table->string('photo_profile', 255)->nullable();
            $table->string('photo_ktp', 255)->nullable();
            $table->string('no_rekening', 50)->nullable();
            $table->string('store_name', 50);
            $table->string('store_address', 100);
            $table->string('photo_store')->nullable();
            $table->enum('status', ['pending', 'accept', 'reject'])->default('pending');
            $table->string('link_maps');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owner_marketplaces');
    }
};
