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
            $table->dropColumn('promo_code');

            $table->unsignedBigInteger('voucher_id')->nullable()->after('customer_id');
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('SET NULL')->onUpdate('cascade');

            $table->decimal('delivery_fee', 8, 2)->default(0)->after('address_id')->comment('Calculated based on delivery type/location')->change();
            $table->decimal('sub_total', 12, 2)->default(0)->after('delivery_fee')->comment('Sum of order items before discounts');
            $table->decimal('voucher_discount', 12, 2)->default(0)->after('sub_total')->comment('Calculated voucher discount amount');
            $table->decimal('product_discount', 12, 2)->default(0)->after('voucher_discount')->comment('Calculated product discount amount');
            $table->decimal('total_amount', 12, 2)->storedAs('sub_total + delivery_fee - voucher_discount - product_discount')->after('product_discount')->comment('Final payable amount');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('total_amount');

            $table->dropColumn([
                'product_discount',
                'voucher_discount',
                'sub_total',
            ]);

            $table->decimal('delivery_fee', 10, 2)->nullable()->change();

            $table->dropForeign(['voucher_id']);
            $table->dropColumn('voucher_id');

            $table->string('promo_code')->nullable();
        });
    }
};
