<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropUnique(['name']);
            $table->dropUnique(['slug']);
        });

        Schema::table('medicines', function (Blueprint $table) {
            $table->text('name')->nullable()->change();
            $table->text('slug')->nullable()->change();

            $table->unsignedBigInteger('pro_sub_cat_id')->nullable()->change();
            $table->text('description')->nullable()->change();

            $table->unsignedBigInteger('dose_id')->nullable();
            $table->foreign('dose_id')->references('id')->on('medicine_doses');

            $table->tinyInteger('use_for')->nullable();
            $table->string('dar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->string('name')->unique()->nullable(false)->change();
            $table->string('slug')->unique()->nullable(false)->change();

            $table->unsignedBigInteger('pro_sub_cat_id')->nullable(false)->change();

            $table->longText('description')->nullable(false)->change();

            $table->dropForeign(['dose_id']);
            $table->dropColumn(['dose_id', 'use_for', 'details']);
        });
    }
};
