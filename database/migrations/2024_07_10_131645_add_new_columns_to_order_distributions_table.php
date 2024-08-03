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
        Schema::table('order_distributions', function (Blueprint $table) {
            $table->dateTime('pharmacy_preped_at')->nullable();
            $table->dateTime('rider_collected_at')->nullable();
            $table->dateTime('rider_delivered_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_distributions', function (Blueprint $table) {
            $table->dropColumn(['pharmacy_preped_at', 'rider_collected_at', 'rider_delivered_at']);
        });
    }
};
