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
            $table->dropColumn(['prep_time']);
            $table->dateTime('pharmacy_prep_time')->nullable();
            $table->dateTime('rider_collect_time')->nullable();
            $table->dateTime('rider_delivery_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_distributions', function (Blueprint $table) {
            $table->float('prep_time');
            $table->dropColumn(['pharmacy_prep_time', 'rider_collect_time', 'rider_delivery_time']);
        });
    }
};
