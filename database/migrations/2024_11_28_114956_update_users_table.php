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
            $table->dropColumn(['designation']);
            $table->tinyInteger('identification_type')->nullable()->change();
            $table->tinyInteger('gender')->nullable()->change();
            $table->string('occupation')->nullable();
            $table->string('identification_file')->nullable();
            $table->string('emergency_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('designation')->nullable();
            $table->enum('identification_type', ['NID', 'DOB', 'Passport'])->nullable()->change();
            $table->enum('gender', ['Male', 'Female', 'Others'])->nullable()->change();
            $table->dropColumn(['occupation', 'identification_file', 'emergency_phone']);
        });
    }
};
