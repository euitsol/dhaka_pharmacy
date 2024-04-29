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
        Schema::create('order_distribution_pharmacies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_distribution_id');
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('pharmacy_id');
            $table->tinyInteger('status')->default(0)->comment('0= pending, 1= distributed, 2=dispute');
            $table->timestamps();
            $table->softDeletes();
            $this->addMorphedAuditColumns($table);

            $table->foreign('order_distribution_id')->references('id')->on('order_distributions')->onDelete('cascade')->onUpdate('cascade');  
            $table->foreign('cart_id')->references('id')->on('add_to_carts')->onDelete('cascade')->onUpdate('cascade');  
            $table->foreign('pharmacy_id')->references('id')->on('pharmacies')->onDelete('cascade')->onUpdate('cascade');  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_distribution_pharmacies');
    }
};
