<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Traits\AuditColumnsTrait;

return new class extends Migration
{
    use AuditColumnsTrait;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_prescriptions', function (Blueprint $table) {
            // Drop foreign keys using array syntax
            $table->dropForeign(['user_id']);
            $table->dropForeign(['address_id']);
            $table->dropColumn(['user_id', 'address_id', 'image', 'delivery_type', 'delivery_fee']);

            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')
                  ->references('id')->on('orders')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->unsignedBigInteger('prescription_id');
            $table->foreign('prescription_id')
                  ->references('id')->on('prescriptions')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->unique(['order_id', 'prescription_id']);

            $this->dropAuditColumns($table);
            $this->addMorphedAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_prescriptions', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['prescription_id']);
            $table->dropUnique(['order_id', 'prescription_id']);
            $table->dropColumn(['order_id', 'prescription_id']);
            $this->dropMorphedAuditColumns($table);

            $this->addAuditColumns($table);
            $table->unsignedBigInteger('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('address_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('image');
            $table->string('delivery_type');
            $table->decimal('delivery_fee', 10, 2);
        });
    }
};
