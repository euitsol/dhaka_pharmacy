<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Traits\AuditColumnsTrait;

return new class extends Migration
{
    use AuditColumnsTrait;
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);

            $table->dropColumn(['created_by', 'updated_by', 'deleted_by']);
            $this->addMorphedAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['creater_id', 'creater_type', 'updater_id', 'updater_type', 'deleter_id', 'deleter_type']);

            // Add the old audit columns back
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            // Re-add the foreign key constraints
            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('admins')->onDelete('set null');
        });
    }
};
