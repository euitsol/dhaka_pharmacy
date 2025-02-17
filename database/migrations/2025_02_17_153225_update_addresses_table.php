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

        Schema::table('addresses', function (Blueprint $table) {
            $table->string('street_address')->nullable()->change();
            $table->text('latitude')->nullable()->change();
            $table->text('longitude')->nullable()->change();
            $table->string('apartment')->nullable()->change();
            $table->string('floor')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('street_address')->nullable(false)->change();
            $table->text('latitude')->nullable(false)->change();
            $table->text('longitude')->nullable(false)->change();
            $table->string('apartment')->nullable(false)->change();
            $table->string('floor')->nullable(false)->change();
        });
    }
};
