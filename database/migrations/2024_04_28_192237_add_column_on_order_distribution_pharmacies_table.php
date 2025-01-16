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
        Schema::table('order_distribution_pharmacies', function (Blueprint $table) {
            $table->float('open_amount')->nullable();
            $table->longText('note')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('order_distribution_pharmacies', function (Blueprint $table) {
            //
        });
    }
};
