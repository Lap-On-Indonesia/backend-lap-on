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
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('phone', 20);
            $table->string('photo_profile', 255)->nullable();
            $table->string('photo_ktp', 255)->nullable();
            $table->string('no_rekening')->nullable();
            $table->string('store_name');
            $table->string('store_address');
            $table->string('photo_store')->nullable();
            $table->enum('status', ['pending', 'accept', 'reject'])->default('pending');
            $table->string('link_maps');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owners');
    }
};
