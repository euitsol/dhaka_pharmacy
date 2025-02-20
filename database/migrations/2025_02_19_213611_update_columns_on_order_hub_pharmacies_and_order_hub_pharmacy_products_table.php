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
        Schema::table('order_hub_pharmacies', function (Blueprint $table) {
            $table->decimal('total_payable_amount', 8, 2)->default(0)->after('pharmacy_id');
        });

        Schema::table('order_hub_pharmacy_products', function (Blueprint $table) {
            $table->decimal('unit_payable_price', 8, 2)->default(0)->after('order_product_id');
            $table->integer('quantity_collected')->default(0)->after('unit_collecting_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_hub_pharmacies', function (Blueprint $table) {
            $table->dropColumn('total_payable_amount');
        });

        Schema::table('order_hub_pharmacy_products', function (Blueprint $table) {
            $table->dropColumn(['unit_payable_price', 'quantity_collected']);
        });
    }
};
