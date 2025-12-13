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
        Schema::create('roommate_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Kebiasaan Tidur (Sleep Habits)
            $table->boolean('sleep_lamp_off')->default(false)->comment('Suka tidur dengan lampu mati?');
            $table->boolean('sleep_late')->default(false)->comment('Sering tidur larut malam?');
            $table->boolean('sleep_noise_tolerant')->default(false)->comment('Tidak terganggu dengan suara saat tidur?');
            $table->boolean('sleep_snore')->default(false)->comment('Mendengkur saat tidur?');

            // Kebersihan (Cleanliness)
            $table->boolean('clean_daily')->default(false)->comment('Merapikan barang setiap hari?');
            $table->boolean('clean_tolerance')->default(false)->comment('Tidak terganggu dengan keadaan berantakan?');
            $table->boolean('clean_self_wash')->default(false)->comment('Mencuci alat makan sendiri?');
            $table->boolean('clean_shared_duty')->default(false)->comment('Bersedia berbagi tugas kebersihan?');

            // Kebiasaan Belajar/Kerja (Study/Work Habits)
            $table->boolean('study_late')->default(false)->comment('Sering belajar/kerja larut malam?');
            $table->boolean('study_quiet_needed')->default(false)->comment('Membutuhkan suasana hening saat belajar?');
            $table->boolean('study_music')->default(false)->comment('Suka mendengarkan musik saat belajar?');

            // Sosial (Social)
            $table->boolean('guest_welcome')->default(false)->comment('Menerima tamu di kamar?');
            $table->boolean('introvert')->default(false)->comment('Lebih suka menyendiri?');
            $table->boolean('smoking')->default(false)->comment('Merokok?');
            $table->boolean('pet_friendly')->default(false)->comment('Suka hewan peliharaan?');

            // Bio/Description
            $table->text('description')->nullable()->comment('Tentang saya');
            $table->string('contact_preference')->default('whatsapp')->comment('Preferensi kontak: whatsapp, email, phone');

            // Status
            $table->boolean('is_active')->default(true)->comment('Masih mencari teman sekamar?');

            $table->timestamps();

            // Ensure one preference per user
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roommate_preferences');
    }
};
