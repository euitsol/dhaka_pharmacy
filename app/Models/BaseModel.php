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

    public function getStatus()
    {
        if ($this->status == 1) {
            return 'Active';
        } else {
            return 'Deactive';
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


    public function getFeatured()
    {
        if ($this->is_featured == 1) {
            return 'Remove from featured';
        } else {
            return 'Make featured';
        }
    }
    public function getFeaturedStatus()
    {
        if ($this->is_featured == 1) {
            return "Yes";
        } else {
            return "No";
        }
    }
    public function getFeaturedStatusClass()
    {
        if ($this->is_featured == 1) {
            return "badge badge-primary";
        } else {
            return "badge badge-secondary";
        }
    }
}
