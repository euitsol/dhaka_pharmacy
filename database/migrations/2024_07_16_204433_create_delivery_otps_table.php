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
        Schema::create('delivery_otps', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_distribution_id');
            $table->foreign('order_distribution_id')->references('id')->on('order_distributions')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('rider_id')->nullable();
            $table->foreign('rider_id')->references('id')->on('riders')->onDelete('cascade')->onUpdate('cascade');


            $table->string('otp');
            $table->boolean('status')->default(1);

            $table->timestamps();
            $table->softDeletes();
            $this->addMorphedAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_otps');
    }
};
