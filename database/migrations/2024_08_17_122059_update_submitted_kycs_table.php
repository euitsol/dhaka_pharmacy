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
        Schema::table('submitted_kycs', function (Blueprint $table) {
            $table->tinyInteger('status')->default(0)->change();
            $table->unsignedBigInteger('kyc_id');
            $table->foreign('kyc_id')->references('id')->on('kyc_settings')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submitted_kycs', function (Blueprint $table) {
            $table->boolean('status')->nullable()->change();
            $table->dropForeign(['kyc_id']);
            $table->dropColumn('kyc_id');
        });
    }
};
