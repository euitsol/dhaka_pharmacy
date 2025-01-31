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
        Schema::table('order_products', function (Blueprint $table) {
            $table->decimal('unit_price', 12, 2)->default(0)->after('quantity');
            $table->decimal('unit_discount', 12, 2)->default(0)->after('unit_price');
            $table->decimal('total_price', 12, 2)->storedAs('(`unit_price` - `unit_discount`) * `quantity`')->after('unit_discount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->dropColumn('total_price');
            $table->dropColumn([
                'unit_price',
                'unit_discount'
            ]);
        });
    }
};
