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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();

            $table->string('invoice')->unique();
            $table->string('type');

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->json('payload')->nullable();
            $table->json('response')->nullable();

            $table->string('status_code')->nullable();

            $table->unsignedBigInteger('receiver_id')->nullable();
            $table->string('receiver_type')->nullable();

            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');

            $table->timestamp('sent_at')->nullable();
            $table->timestamp('received_at')->nullable();

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
        Schema::dropIfExists('deliveries');
    }
};
