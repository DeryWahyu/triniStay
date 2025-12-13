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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['superadmin', 'owner', 'renter'])->default('renter')->after('name');
            $table->string('phone_number')->nullable()->after('email');
            $table->integer('age')->nullable()->after('phone_number');
            $table->enum('gender', ['Male', 'Female'])->nullable()->after('age');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone_number', 'age', 'gender']);
        });
    }
};
