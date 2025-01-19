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
        Schema::table('medicine_strengths', function (Blueprint $table) {
            $table->text('name')->nullable();
            $table->text('unit')->nullable()->change();
            $table->text('quantity')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicine_strengths', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('unit')->nullable(false)->change();
            $table->string('quantity')->nullable(false)->change();
        });
    }
};
