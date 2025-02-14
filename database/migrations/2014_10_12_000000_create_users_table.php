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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // $table->string('first_name');
            // $table->string('last_name');
            $table->string('name', 50);
            $table->string('email', 50)->unique();
            $table->string('phone', 16)->nullable();

            // $table->foreignId('owner_id')->nullable()->constrained('owners')->onDelete('cascade');
            // $table->foreignId('owner_marketplace_id')->nullable()->constrained('owner_marketplace')->onDelete('cascade');
            $table->string('profile_photo_path', 5048)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            // $table->string('roles')->default('user');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
