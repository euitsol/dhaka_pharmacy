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
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropColumn('apartment_type');

            $this->dropAuditColumns($table);

            $table->string('name')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->longText('delivery_instruction')->nullable()->change();
            $table->string('address');
            $table->text('note')->nullable();
            $table->boolean('is_default')->default(0);
            $this->addMorphedAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('note');
            $table->dropColumn('is_default');

            $table->unsignedBigInteger('user_id');
            $table->string('apartment_type');
        });
    }
};
