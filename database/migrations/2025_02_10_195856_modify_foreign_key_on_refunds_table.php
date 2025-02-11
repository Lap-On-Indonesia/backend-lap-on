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
        Schema::table('refunds', function (Blueprint $table) {
            // Hapus foreign key lama
            $table->dropForeign(['booking_id']);

            // Tambahkan foreign key baru dengan onDelete('restrict')
            $table->foreign('booking_id')
                  ->references('id')
                  ->on('bookings')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('refunds', function (Blueprint $table) {
            // Hapus foreign key dengan onDelete('restrict')
            $table->dropForeign(['booking_id']);

            // Tambahkan kembali foreign key dengan onDelete('cascade')
            $table->foreign('booking_id')
                  ->references('id')
                  ->on('bookings')
                  ->onDelete('cascade');
        });
    }
};
