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
        Schema::create('order_distribution_riders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_distribution_id');
            $table->unsignedBigInteger('rider_id');
            $table->tinyInteger('status')->default(3)->comment('0=dispute, 3=assign/on the way, 4=delivared, 5=complete(with payment)');
            $table->tinyInteger('priority')->comment('0=Normal, 1=Medium, 2=High');
            $table->longText('instraction')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $this->addMorphedAuditColumns($table);

            $table->foreign('order_distribution_id')->references('id')->on('order_distributions')->onDelete('cascade')->onUpdate('cascade');    
            $table->foreign('rider_id')->references('id')->on('riders')->onDelete('cascade')->onUpdate('cascade');  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_distribution_riders');
    }
};