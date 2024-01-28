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
        Schema::create('local_area_managers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('dm_id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('bio')->nullable();
            $table->string('designation')->nullable();
            $table->boolean('status')->default(1);
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            $table->timestamps();
            $table->softDeletes();
            $this->addAuditColumns($table);

            $table->foreign('dm_id')->references('id')->on('district_managers')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('local_area_managers');
    }
};
