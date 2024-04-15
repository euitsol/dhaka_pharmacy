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
        Schema::create('riders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('oa_id')->nullable();
            $table->unsignedBigInteger('osa_id')->nullable();
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
            $table->enum('identification_type',['NID','DOB','Passport'])->nullable();
            $table->string('identification_no')->nullable();
            $table->longText('present_address')->nullable();
            $table->string('cv')->nullable();
            
            $table->enum('gender',['Male','Female','Others'])->nullable();
            $table->date('dob')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('emergency_phone')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $this->addMorphedAuditColumns($table);

            $table->foreign('oa_id')->references('id')->on('operation_areas')->onDelete('cascade')->onUpdate('cascade'); 
            $table->foreign('osa_id')->references('id')->on('operation_sub_areas')->onDelete('cascade')->onUpdate('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riders');
    }
};
