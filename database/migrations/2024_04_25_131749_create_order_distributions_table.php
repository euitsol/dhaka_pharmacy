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
        Schema::create('order_distributions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->tinyInteger('payment_type')->default(1);
            $table->tinyInteger('distribution_type')->default(1);
            $table->dateTime('prep_time');
            $table->tinyInteger('status')->default(0)->comment('0=Pending, 1=Preparing, 2=Waiting for rider, 3=Waiting for pickup, 4=Picked up, 5=Finish');
            $table->longText('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $this->addMorphedAuditColumns($table);

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_distributions');
    }
};
