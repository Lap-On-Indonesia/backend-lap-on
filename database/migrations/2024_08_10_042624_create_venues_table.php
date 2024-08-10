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
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('category_id');
            $table->string('name');
            $table->text('description');
            $table->string('image');
            $table->string('address');
            $table->string('link_maps');
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('owners');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};
