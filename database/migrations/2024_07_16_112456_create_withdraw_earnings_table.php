<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Traits\AuditColumnsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration
{
    use AuditColumnsTrait, SoftDeletes;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('withdraw_earnings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('w_id');
            $table->unsignedBigInteger('e_id');
            $table->timestamps();
            $table->softDeletes();
            $this->addMorphedAuditColumns($table);

            $table->foreign('w_id')->references('id')->on('withdraws')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('e_id')->references('id')->on('earnings')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraw_earnings');
    }
};
