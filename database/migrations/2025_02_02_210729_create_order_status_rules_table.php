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
        Schema::create('order_status_rules', function (Blueprint $table) {
            $table->id();

            $table->integer('status_code')->unique();
            $table->string('status_name');
            $table->integer('expected_time_interval')->nullable();
            $table->string('expected_time_unit')->nullable(); // minutes, hours, days
            $table->boolean('visible_to_user')->default(false);
            $table->integer('sort_order');

            $table->timestamps();
            $table->softDeletes();
            $this->addAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_status_rules');
    }
};
