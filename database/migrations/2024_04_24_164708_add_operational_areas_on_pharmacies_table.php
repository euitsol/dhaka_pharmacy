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
        Schema::table('pharmacies', function (Blueprint $table) {
            $table->unsignedBigInteger('oa_id')->nullable();
            $table->unsignedBigInteger('osa_id')->nullable();

            $table->foreign('oa_id')->references('id')->on('operation_areas')->onDelete('cascade')->onUpdate('cascade'); 
            $table->foreign('osa_id')->references('id')->on('operation_sub_areas')->onDelete('cascade')->onUpdate('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pharmacies', function (Blueprint $table) {
            //
        });
    }
};
