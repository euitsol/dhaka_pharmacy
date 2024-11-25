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
        Schema::table('admins', function (Blueprint $table) {
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->tinyInteger('identification_type')->nullable();
            $table->string('identification_no')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->longText('present_address')->nullable();
            $table->longText('permanent_address')->nullable();
            $table->string('identification_file')->nullable();
            $table->tinyInteger('gender')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['father_name', 'mother_name', 'phone', 'emergency_phone', 'identification_type', 'identification_no', 'date_of_birth', 'present_address', 'permanent_address', 'identification_file', 'gender']);
        });
    }
};