<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade'); // Foreign key untuk booking
            $table->dateTime('refund_date_time'); // Kolom untuk date and time refund
            $table->string('status'); // Kolom status (misalnya: pending, completed, etc.)
            $table->decimal('total_payment', 15, 2); // Total payment dalam bentuk decimal
            $table->string('validation_image')->nullable(); // Kolom untuk menyimpan path gambar bukti pembayaran
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refunds');
    }
};
