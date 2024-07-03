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
        Schema::table('orders', function (Blueprint $table) {
            //payment_getway
            $table->dropColumn(['payment_getway']);
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->enum('payment_method', ['bkash', 'nogod', 'roket', 'upay', 'ssl', 'cod'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_getway', ['bkash', 'nogod', 'roket', 'upay', 'ssl', 'cod']);
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('payment_method');
        });
    }
};
