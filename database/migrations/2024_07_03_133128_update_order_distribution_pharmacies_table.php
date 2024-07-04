<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_distribution_pharmacies', function (Blueprint $table) {
            $table->dropForeign(['cart_id']);
            $table->dropColumn(['cart_id']);
            $table->unsignedBigInteger('op_id')->nullable();
            $table->foreign('op_id')->references('id')->on('order_products')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_distribution_pharmacies', function (Blueprint $table) {
            $table->dropForeign(['op_id']);
            $table->dropColumn(['op_id']);
            $table->unsignedBigInteger('cart_id');
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade')->onUpdate('cascade');
        });
    }
};
