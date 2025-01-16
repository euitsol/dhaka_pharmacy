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
        Schema::table('pharmacies', function (Blueprint $table) {
            $table->dropColumn('bio');
            $table->dropColumn('designation');
            $table->dropColumn('age');
            $table->dropColumn('identification_no');
            $table->dropColumn('present_address');
            $table->dropColumn('gender');
            $table->dropColumn('dob');
            $table->dropColumn('father_name');
            $table->dropColumn('mother_name');
            $table->dropColumn('permanent_address');
            $table->dropColumn('cv');
            $table->tinyInteger('identification_type')->nullable()->change();
            $table->string('otp')->nullable();
            $table->string('identification_file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pharmacies', function (Blueprint $table) {
            $table->string('bio')->nullable();
            $table->string('designation')->nullable();
            $table->string('age')->nullable();
            $table->string('identification_no')->nullable();
            $table->longText('present_address')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Others'])->nullable();
            $table->date('dob')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('permanent_address')->nullable();
            $table->enum('identification_type', ['NID', 'DOB', 'Passport'])->nullable()->change();
            $table->dropColumn('otp');
            $table->string('cv')->nullable();
            $table->dropColumn('identification_file')->nullable();
        });
    }
};