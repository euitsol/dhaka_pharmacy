<?php

use App\Models\Delivery;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->tinyInteger('status')->default(0)->after('response')->comment(Delivery::STATUS_ACTIVE . ' = Active, ' . Delivery::STATUS_CANCELED . ' = Canceled');
            $table->string('tracking_id')->nullable()->after('status');
            $table->unsignedBigInteger('hub_id')->after('order_id');
            $table->foreign('hub_id')->references('id')->on('hubs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('tracking_id');
            $table->dropForeign(['hub_id']);
            $table->dropColumn('hub_id');
        });
    }
};
