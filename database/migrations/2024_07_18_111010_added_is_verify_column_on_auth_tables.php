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
            $table->string('is_verify')->default(0)->after('kyc_status');
        });
        Schema::table('riders', function (Blueprint $table) {
            $table->string('is_verify')->default(0)->after('kyc_status');
        });
        Schema::table('local_area_managers', function (Blueprint $table) {
            $table->string('is_verify')->default(0)->after('kyc_status');
        });
        Schema::table('district_managers', function (Blueprint $table) {
            $table->string('is_verify')->default(0)->after('kyc_status');
        });
    }

    public function down(): void
    {
        Schema::table('pharmacy', function (Blueprint $table) {
            $table->dropColumn('is_verify');
        });
        Schema::table('riders', function (Blueprint $table) {
            $table->dropColumn('is_verify');
        });
        Schema::table('local_area_managers', function (Blueprint $table) {
            $table->dropColumn('is_verify');
        });
        Schema::table('district_managers', function (Blueprint $table) {
            $table->dropColumn('is_verify');
        });
    }
};