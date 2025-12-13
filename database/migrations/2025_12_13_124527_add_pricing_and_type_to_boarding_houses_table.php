<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('boarding_houses', function (Blueprint $table) {
            // Pricing per period - rename existing price to price_monthly
            $table->bigInteger('price_monthly')->nullable()->after('slug');
            $table->bigInteger('price_6months')->nullable()->after('price_monthly');
            $table->bigInteger('price_yearly')->nullable()->after('price_6months');
            
            // Kos type (gender)
            $table->enum('type', ['putra', 'putri', 'campur'])->default('campur')->after('name');
        });

        // Copy existing price to price_monthly
        DB::statement('UPDATE boarding_houses SET price_monthly = price WHERE price_monthly IS NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('boarding_houses', function (Blueprint $table) {
            $table->dropColumn(['price_monthly', 'price_6months', 'price_yearly', 'type']);
        });
    }
};
