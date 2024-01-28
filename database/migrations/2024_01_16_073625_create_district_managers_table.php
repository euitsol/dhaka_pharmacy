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
        Schema::create('district_managers', function (Blueprint $table) {
            $table->id();

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

            $table->string('age')->nullable();
            $table->string('area')->nullable();
            $table->enum('identification_type',['NID','DOB','Passport'])->nullable();
            $table->string('identification_no')->nullable();
            $table->string('present_address')->nullable();
            $table->string('cv')->nullable();
            
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
        Schema::dropIfExists('district_managers');
    }
};
