<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Traits\AuditColumnsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration
{
    use AuditColumnsTrait,SoftDeletes;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('address_id')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->string('customer_type');
            $table->unsignedBigInteger('ref_user')->nullable();
            $table->json('carts')->comment('cart ids');
            $table->tinyInteger('status')->default(0);
            $table->enum('payment_getway',['bkash', 'nogod', 'roket', 'upay', 'ssl'])->nullable();
            $table->string('order_id');
            $table->string('promo_code')->nullable();
            $table->float('delivery_fee')->nullable();
            $table->string('delivery_type')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $this->addAuditColumns($table);

            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ref_user')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
