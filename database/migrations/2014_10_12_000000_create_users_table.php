<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('bio')->nullable();
            $table->string('designation')->nullable();
            $table->boolean('status')->default(1);
            $table->string('email')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('otp')->nullable();
            $table->rememberToken();

            $table->string('age')->nullable();
            $table->enum('identification_type',['NID','DOB','Passport'])->nullable();
            $table->string('identification_no')->nullable();
            $table->longText('present_address')->nullable();
            
            $table->enum('gender',['Male','Female','Others'])->nullable();
            $table->date('dob')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('permanent_address')->nullable();


            $table->string('google_id')->nullable();
            $table->string('github_id')->nullable();
            $table->string('facebook_id')->nullable();


            $table->string('token')->nullable();
            $table->string('refresh_token')->nullable();
            $table->string('avatar')->nullable();
            $table->string('avatar_original')->nullable();


            

            $table->softDeletes();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
