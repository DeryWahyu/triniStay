<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Values: 0 = Tidak, 1 = Ya, 2 = Kadang-kadang
     */
    public function up(): void
    {
        Schema::table('roommate_preferences', function (Blueprint $table) {
            // Kebiasaan Tidur
            $table->tinyInteger('sleep_lamp_off')->default(0)->change();
            $table->tinyInteger('sleep_late')->default(0)->change();
            $table->tinyInteger('sleep_noise_tolerant')->default(0)->change();
            $table->tinyInteger('sleep_snore')->default(0)->change();

            // Kebersihan
            $table->tinyInteger('clean_daily')->default(0)->change();
            $table->tinyInteger('clean_tolerance')->default(0)->change();
            $table->tinyInteger('clean_self_wash')->default(0)->change();
            $table->tinyInteger('clean_shared_duty')->default(0)->change();

            // Kebiasaan Belajar/Kerja
            $table->tinyInteger('study_late')->default(0)->change();
            $table->tinyInteger('study_quiet_needed')->default(0)->change();
            $table->tinyInteger('study_music')->default(0)->change();

            // Sosial
            $table->tinyInteger('guest_welcome')->default(0)->change();
            $table->tinyInteger('introvert')->default(0)->change();
            $table->tinyInteger('smoking')->default(0)->change();
            $table->tinyInteger('pet_friendly')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roommate_preferences', function (Blueprint $table) {
            // Revert back to boolean
            $table->boolean('sleep_lamp_off')->default(false)->change();
            $table->boolean('sleep_late')->default(false)->change();
            $table->boolean('sleep_noise_tolerant')->default(false)->change();
            $table->boolean('sleep_snore')->default(false)->change();

            $table->boolean('clean_daily')->default(false)->change();
            $table->boolean('clean_tolerance')->default(false)->change();
            $table->boolean('clean_self_wash')->default(false)->change();
            $table->boolean('clean_shared_duty')->default(false)->change();

            $table->boolean('study_late')->default(false)->change();
            $table->boolean('study_quiet_needed')->default(false)->change();
            $table->boolean('study_music')->default(false)->change();

            $table->boolean('guest_welcome')->default(false)->change();
            $table->boolean('introvert')->default(false)->change();
            $table->boolean('smoking')->default(false)->change();
            $table->boolean('pet_friendly')->default(false)->change();
        });
    }
};
