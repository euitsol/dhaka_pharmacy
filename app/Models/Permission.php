<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory;

    public $guarded = [];
    public function created_user()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    public function updated_user()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
    public function deleted_user()
    {
        return $this->belongsTo(Admin::class, 'deleted_by');
    }

    public function scopeActivated($query){
        return $query->where('status',1);
    }
    public function scopeCreater_name(){
        return $this->creater->name ?? 'System';
    }
    public function scopeUpdater_name(){
        return $this->updater->name ?? '--';
    }
    public function scopeDeleter_name(){
        return $this->deleter->name ?? '--';
    }
    public function scopeCreated_user_name(){
        return $this->created_user->name ?? 'System';
    }
    public function scopeUpdated_user_name(){
        return $this->updated_user->name ?? '--';
    }
    public function scopeDeleted_user_name(){
        return $this->deleted_user->name ?? '--';
    }
    public function scopeCreated_date(){
        return timeFormate($this->created_at);
    }
    public function scopeUpdated_date(){
        return ($this->updated_at != $this->created_at) ? timeFormate($this->updated_at) : '--';
    }
    public function scopeDeleted_date(){
        return timeFormate($this->deleted_at);
    }
}
