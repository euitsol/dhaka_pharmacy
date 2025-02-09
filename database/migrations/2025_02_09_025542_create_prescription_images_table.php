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
        Schema::create('prescription_images', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('prescription_id');
            $table->foreign('prescription_id')->references('id')->on('prescriptions')->onDelete('cascade');
            $table->text('path');
            $table->tinyInteger('status')->default(1);

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
        Schema::dropIfExists('prescription_images');
    }
};
