<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class AuthenticateBaseModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

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

    public function creater()
    {
        return $this->morphTo();
    }
    public function updater()
    {
        return $this->morphTo();
    }
    public function deleter()
    {
        return $this->morphTo();
    }

    public function getStatus()
    {
        if ($this->status == 1) {
            return 'Active';
        } else {
            return 'Deactive';
        }
    }
    public function getBtnStatus()
    {
        if ($this->status == 1) {
            return 'Deactive';
        } else {
            return 'Active';
        }
    }

    public function getStatusClass()
    {
        if ($this->status == 1) {
            return 'btn-success';
        } else {
            return 'btn-danger';
        }
    }
    public function getStatusBadgeClass()
    {
        if ($this->status == 1) {
            return 'badge badge-success';
        } else {
            return 'badge badge-warning';
        }
    }


    public function getFeatured()
    {
        if ($this->is_featured == 1) {
            return 'Yes';
        } else {
            return 'No';
        }
    }
    public function getBtnFeatured()
    {
        if ($this->is_featured == 1) {
            return 'Remove from featured';
        } else {
            return 'Make featured';
        }
    }

    public function getFeaturedClass()
    {
        if ($this->is_featured == 1) {
            return 'btn-primary';
        } else {
            return 'btn-secondary';
        }
    }
    public function getFeaturedBadgeClass()
    {
        if ($this->is_featured == 1) {
            return 'badge badge-primary';
        } else {
            return 'badge badge-secondary';
        }
    }

    public function scopeActiveted($query){
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
