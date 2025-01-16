<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('kyc_status')->default(0)->after('status');
        });
        Schema::table('pharmacies', function (Blueprint $table) {
            $table->string('kyc_status')->default(0)->after('status');
        });
        Schema::table('riders', function (Blueprint $table) {
            $table->string('kyc_status')->default(0)->after('status');
        });
        Schema::table('local_area_managers', function (Blueprint $table) {
            $table->string('kyc_status')->default(0)->after('status');
        });
        Schema::table('district_managers', function (Blueprint $table) {
            $table->string('kyc_status')->default(0)->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('kyc_status');
        });
        Schema::table('pharmacy', function (Blueprint $table) {
            $table->dropColumn('kyc_status');
        });
        Schema::table('riders', function (Blueprint $table) {
            $table->dropColumn('kyc_status');
        });
        Schema::table('local_area_managers', function (Blueprint $table) {
            $table->dropColumn('kyc_status');
        });
        Schema::table('district_managers', function (Blueprint $table) {
            $table->dropColumn('kyc_status');
        });
    }
};
