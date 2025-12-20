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
            $table->string('booking_code')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('boarding_house_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->date('start_date');
            $table->string('duration'); // '1_month', '3_months', '6_months', '1_year'
            $table->date('end_date');
            $table->bigInteger('price_per_period');
            $table->bigInteger('total_price');
            $table->string('payment_proof')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled', 'completed'])->default('pending');
            $table->text('rejection_reason')->nullable();
            // Shared/Room Match Logic
            $table->boolean('is_shared')->default(false);
            $table->string('shared_with_email')->nullable();
            $table->foreignId('shared_with_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('shared_status', ['pending', 'accepted', 'rejected'])->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
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
