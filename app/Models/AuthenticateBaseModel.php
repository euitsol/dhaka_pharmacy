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
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

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

    public function scopeActivated($query)
    {
        return $query->where('status', 1);
    }
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', 1);
    }
    public function scopeKycVerified($query)
    {
        return $query->where('kyc_status', 1);
    }
    public function scopeMenu($query)
    {
        return $query->where('is_menu', 1);
    }

    public function getKycStatus()
    {
        if ($this->kyc_status == 1) {
            return 'Complete';
        } else {
            return 'Pending';
        }
    }
    public function getKycStatusClass()
    {
        if ($this->kyc_status == 1) {
            return 'badge badge-success';
        } else {
            return 'badge badge-info';
        }
    }
    public function getPhoneVerifyStatus()
    {
        if ($this->is_verify == 1) {
            return 'Success';
        } else {
            return 'Pending';
        }
    }
    public function getPhoneVerifyClass()
    {
        if ($this->is_verify == 1) {
            return 'badge badge-success';
        } else {
            return 'badge badge-primary';
        }
    }
    public function getEmailVerifyStatus()
    {
        if ($this->is_verify == 1) {
            return 'Success';
        } else {
            return 'Pending';
        }
    }
    public function getEmailVerifyClass()
    {
        if ($this->is_verify == 1) {
            return 'badge badge-success';
        } else {
            return 'badge badge-primary';
        }
    }

    public function identificationType()
    {
        switch ($this->identification_type) {
            case 1:
                return "National ID Card";
            case 2:
                return "Birth Certificate No";
            case 3:
                return "Passport No";
        }
    }
    public function getGender()
    {
        switch ($this->gender) {
            case 1:
                return "Male";
            case 2:
                return "Female";
            case 3:
                return "Other";
        }
    }
}
