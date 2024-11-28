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
        Schema::table('district_managers', function (Blueprint $table) {
            $table->tinyInteger('identification_type')->nullable()->change();
            $table->tinyInteger('gender')->nullable()->change();
        });
        Schema::table('local_area_managers', function (Blueprint $table) {
            $table->tinyInteger('identification_type')->nullable()->change();
            $table->tinyInteger('gender')->nullable()->change();
        });
        Schema::table('riders', function (Blueprint $table) {
            $table->tinyInteger('identification_type')->nullable()->change();
            $table->tinyInteger('gender')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('district_managers', function (Blueprint $table) {
            $table->enum('identification_type', ['NID', 'DOB', 'Passport'])->nullable()->change();
            $table->enum('gender', ['Male', 'Female', 'Others'])->nullable()->change();
        });
        Schema::table('local_area_managers', function (Blueprint $table) {
            $table->enum('identification_type', ['NID', 'DOB', 'Passport'])->nullable()->change();
            $table->enum('gender', ['Male', 'Female', 'Others'])->nullable()->change();
        });
        Schema::table('riders', function (Blueprint $table) {
            $table->enum('identification_type', ['NID', 'DOB', 'Passport'])->nullable()->change();
            $table->enum('gender', ['Male', 'Female', 'Others'])->nullable()->change();
        });
    }
};
