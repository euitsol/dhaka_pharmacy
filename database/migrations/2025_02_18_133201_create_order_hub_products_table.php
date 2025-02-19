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
        Schema::create('order_hub_products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_hub_id');
            $table->unsignedBigInteger('order_product_id');

            $table->foreign('order_hub_id')->references('id')->on('order_hubs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('order_product_id')->references('id')->on('order_products')->onDelete('cascade')->onUpdate('cascade');

            $table->tinyInteger('status')->default(0);

            $table->timestamps();
            $table->softDeletes();
            $this->addAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_hub_products');
    }
};
