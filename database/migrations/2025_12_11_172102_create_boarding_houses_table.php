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
        Schema::create('boarding_houses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->bigInteger('price');
            $table->string('room_size')->nullable();
            $table->integer('total_rooms')->default(1);
            $table->integer('available_rooms')->default(1);
            $table->json('rent_schemes')->nullable(); // [1, 3, 6, 12] months
            $table->json('room_facilities')->nullable(); // ['AC', 'WiFi', etc]
            $table->json('common_facilities')->nullable(); // ['Parkir', 'Dapur', etc]
            $table->json('images')->nullable(); // Array of image paths
            $table->text('address');
            $table->text('description')->nullable();
            $table->text('rules')->nullable();

            // Room Match (Berbagi Kamar)
            $table->boolean('is_room_match_enabled')->default(false);
            $table->bigInteger('room_match_price')->nullable();
            $table->string('room_match_period')->nullable(); // e.g., "1 bulan", "3 bulan"

            $table->enum('status', ['active', 'inactive', 'pending'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boarding_houses');
    }
};
