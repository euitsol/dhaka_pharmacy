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
            $table->tinyInteger('type')->comment(RewardSetting::TYPE_LOGIN . ' = Login, ' . RewardSetting::TYPE_ORDER . ' = Order');
            $table->tinyInteger('receiver_type')->comment(RewardSetting::RECEIVER_TYPE_LAM . ' = LAM, ' . RewardSetting::RECEIVER_TYPE_DM . ' = DM');
            $table->double('reward', 8, 2)->nullable();
            $table->tinyInteger('reward_type')->comment(RewardSetting::REWARD_TYPE_AMOUNT . ' = Amount, ' . RewardSetting::REWARD_TYPE_PERCENTAGE . ' = Percentage')->nullable();
            $table->tinyInteger('status')->default(RewardSetting::STATUS_DEACTIVE)->comment(RewardSetting::STATUS_ACTIVE . ' = Active, ' . RewardSetting::STATUS_DEACTIVE . ' = Deactive', RewardSetting::STATUS_PREVIOUS . ' = Previous');
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
