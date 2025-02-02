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
        Schema::create('hub_staff', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hub_id');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->boolean('status')->default(1);
            $table->string('emergency_phone')->nullable();
            $table->string('email');
            $table->string('password');
            $table->string('image')->nullable();
            $table->string('bio')->nullable();
            $table->boolean('is_verify')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('otp')->nullable();
            $table->string('age')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $this->addMorphedAuditColumns($table);

            $table->foreign('hub_id')->references('id')->on('hubs')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hub_staff');
    }
};
