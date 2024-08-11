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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_id')->constrained('venues')->onDelete('cascade');
            $table->string('day_of_week'); // Hari dalam seminggu, contoh: 'monday', 'saturday'
            $table->time('start_time');    // Waktu mulai slot
            $table->time('end_time');      // Waktu akhir slot
            $table->boolean('is_available')->default(true); // Menunjukkan apakah slot ini tersedia
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};