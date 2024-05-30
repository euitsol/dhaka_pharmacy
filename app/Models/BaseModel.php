<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
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
            return 'badge badge-info';
        }
    }

    public function getMenu()
    {
        if ($this->is_menu == 1) {
            return 'Yes';
        } else {
            return 'No';
        }
    }
    public function getBtnMenu()
    {
        if ($this->is_menu == 1) {
            return 'Remove from menu';
        } else {
            return 'Added on menu';
        }
    }

    public function getMenuClass()
    {
        if ($this->is_menu == 1) {
            return 'btn-primary';
        } else {
            return 'btn-secondary';
        }
    }
    public function getMenuBadgeClass()
    {
        if ($this->is_menu == 1) {
            return 'badge badge-primary';
        } else {
            return 'badge badge-info';
        }
    }

    public function getPermission()
    {
        if($this->permission == 1){
            return 'Accepted';
        }elseif($this->permission == 0){
            return 'Pending';
        }else{
            return 'Declined';
        }
    }
    public function getPermissionClass()
    {
        if($this->permission == 1){
            return 'btn-success';
        }elseif($this->permission == 0){
            return 'btn-info';
        }else{
            return 'btn-danger';
        }
    }
    public function getPermissionAcceptTogleClassName()
    {
        if($this->permission == 1){
            return'd-none';
        }else{
            return 'd-block';
        }
    }
    public function getPermissionDeclineTogleClassName()
    {
        if($this->permission == 1){
            return'd-none';
        }else{
            return 'd-block';
        }
    }

    public function scopeActivated($query){
        return $query->where('status',1);
    }
    public function scopeFeatured($query){
        return $query->where('is_featured',1);
    }
    public function scopeMenu($query){
        return $query->where('is_menu',1);
    }
    

    
}
