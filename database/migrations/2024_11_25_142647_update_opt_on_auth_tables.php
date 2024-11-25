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
            $table->string('otp')->nullable()->after('email_verified_at');
        });
        Schema::table('local_area_managers', function (Blueprint $table) {
            $table->timestamp('phone_verified_at')->nullable()->after('email_verified_at');
            $table->string('otp')->nullable()->after('phone_verified_at');
        });
        Schema::table('district_managers', function (Blueprint $table) {
            $table->timestamp('phone_verified_at')->nullable()->after('email_verified_at');
            $table->string('otp')->nullable()->after('phone_verified_at');
        });
        Schema::table('riders', function (Blueprint $table) {
            $table->timestamp('phone_verified_at')->nullable()->after('email_verified_at');
            $table->string('otp')->nullable()->after('phone_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('otp');
        });
        Schema::table('local_area_managers', function (Blueprint $table) {
            $table->dropColumn(['otp', 'phone_verified_at']);
        });
        Schema::table('district_managers', function (Blueprint $table) {
            $table->dropColumn(['otp', 'phone_verified_at']);
        });
        Schema::table('riders', function (Blueprint $table) {
            $table->dropColumn(['otp', 'phone_verified_at']);
        });
    }
};