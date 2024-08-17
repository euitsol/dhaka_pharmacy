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
        Schema::table('kyc_settings', function (Blueprint $table) {
            $table->dropUnique(['type']);
            $table->enum('type',['user','pharmacy','rider','doctor','dm','lam'])->change();
            $table->boolean('status')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kyc_settings', function (Blueprint $table) {
            $table->enum('type',['user','pharmacy','rider','doctor','dm','lam'])->unique()->change();
            $table->boolean('status')->default(1)->change();
        });
    }
};
