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
        Schema::create('order_hubs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('hub_id');
            $table->tinyInteger('status')->default(0);

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('hub_id')->references('id')->on('hubs')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('order_hubs');
    }
};
