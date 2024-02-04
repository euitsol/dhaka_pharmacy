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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedBigInteger('pro_cat_id');
            $table->unsignedBigInteger('generic_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('medicine_cat_id');
            $table->unsignedBigInteger('strength_id');
            $table->json('unit');
            $table->string('price');
            $table->string('image')->nullable();
            $table->longText('description');
            $table->boolean('prescription_required')->nullable();
            $table->string('max_quantity')->nullable();
            $table->boolean('kyc_required')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $this->addAuditColumns($table);

            
            $table->foreign('pro_cat_id')->references('id')->on('product_categories')->onDelete('cascade')->onUpdate('cascade');      
            $table->foreign('generic_id')->references('id')->on('generic_names')->onDelete('cascade')->onUpdate('cascade');      
            $table->foreign('company_id')->references('id')->on('company_names')->onDelete('cascade')->onUpdate('cascade');      
            $table->foreign('medicine_cat_id')->references('id')->on('medicine_categories')->onDelete('cascade')->onUpdate('cascade');      
            $table->foreign('strength_id')->references('id')->on('medicine_strengths')->onDelete('cascade')->onUpdate('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
