<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('earnings', function (Blueprint $table) {
            // Drop the foreign key constraint on order_id
            $table->dropForeign(['order_id']);
            $table->dropColumn('order_id');

            $table->unsignedBigInteger('reward_id')->nullable();
            $table->foreign('reward_id')->references('id')->on('reward_settings')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('source_id')->nullable();
            $table->string('source_type')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('earnings', function (Blueprint $table) {
            $table->dropForeign(['reward_id']);
            $table->dropColumn(['source_id', 'source_type', 'reward_id']);

            // Re-add the order_id column
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
        });
    }
};
