<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends BaseModel
{
    use HasFactory, SoftDeletes;

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
}
