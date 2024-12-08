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
            Schema::create('bookings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreignId('venue_id');
                $table->foreign('venue_id')->references('id')->on('venues')->onDelete('cascade');
                $table->date('booking_date');
                $table->time('start_time');
                $table->time('end_time');
                $table->decimal('tax_percentage', 5, 2); // Adjusted size for realistic percentages
                $table->decimal('total_payment', 10, 2); // Adjusted for practical total payments
                $table->string('booking_id', 9)->unique()->nullable(); // Add Booking ID (unique, nullable initially)
                $table->timestamps();
                $table->softDeletes();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('bookings');
        }
    };
