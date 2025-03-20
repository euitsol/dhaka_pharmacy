<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Traits\AuditColumnsTrait;
use App\Models\RewardSetting;
use Illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration
{
    use AuditColumnsTrait, SoftDeletes;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reward_settings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('reward_type')->comment(RewardSetting::REWARD_TYPE_LOGIN . ' = Login, ' . RewardSetting::REWARD_TYPE_ORDER . ' = Order');
            $table->tinyInteger('receiver_type')->comment(RewardSetting::RECEIVER_TYPE_LAM . ' = LAM, ' . RewardSetting::RECEIVER_TYPE_DM . ' = DM');
            $table->double('comission', 8, 2);
            $table->tinyInteger('comission_type')->comment(RewardSetting::COMMISSION_TYPE_AMOUNT . ' = Amount, ' . RewardSetting::COMMISSION_TYPE_PERCENTAGE . ' = Percentage');
            $table->tinyInteger('status')->default(RewardSetting::STATUS_DEACTIVE)->comment(RewardSetting::STATUS_ACTIVE . ' = Active, ' . RewardSetting::STATUS_DEACTIVE . ' = Deactive');
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
        Schema::dropIfExists('reward_settings');
    }
};
