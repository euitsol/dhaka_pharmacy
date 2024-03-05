<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OperationSubArea extends BaseModel
{
    use HasFactory, SoftDeletes;
    public function operation_area()
    {
        return $this->belongsTo(OperationArea::class, 'oa_id');
    }


    public function getMultiStatus()
    {
        if ($this->status == 0) {
            return 'Pending';
        } elseif($this->status == 1) {
            return 'Accepted';
        }else{
            return 'Declined';
        }
    }
public function getMultiStatusClass()
    {
        if ($this->status == 0) {
            return 'badge badge-info';
        } elseif($this->status == 1) {
            return 'badge badge-success';
        }else{
            return 'badge badge-warning';
        }
    }
 public function getMultiStatusBtn($id, $slug)
    {

        if ($this->status == 0) {
            return['menuItems' => [
                ['routeName' => 'javascript:void(0)',   'params' => [$id], 'label' => 'View Details', 'className' => 'view','data-id' => $id,],
                ['routeName' => 'dm_management.operation_sub_area.status.operation_sub_area_edit',   'params' => [$id,'accept'], 'label' => 'Accept', 'className' => 'accept'],
                ['routeName' => 'dm_management.operation_sub_area.status.operation_sub_area_edit',   'params' => [$id,'declined'], 'label' => 'Declined'],
                ['routeName' => 'dm_management.operation_sub_area.operation_sub_area_edit',   'params' => [$slug], 'label' => 'Update'],
                ['routeName' => 'dm_management.operation_sub_area.operation_sub_area_delete', 'params' => [$id], 'label' => 'Delete', 'delete' => true],
            ]];
        } elseif($this->status == 1) {
            return['menuItems' => [
                ['routeName' => 'javascript:void(0)',   'params' => [$id], 'label' => 'View Details', 'className' => 'view','data-id' => $id,],
                ['routeName' => 'dm_management.operation_sub_area.status.operation_sub_area_edit',   'params' => [$id,'declined'], 'label' => 'Declined'],
                ['routeName' => 'dm_management.operation_sub_area.operation_sub_area_edit',   'params' => [$slug], 'label' => 'Update'],
                ['routeName' => 'dm_management.operation_sub_area.operation_sub_area_delete', 'params' => [$id], 'label' => 'Delete', 'delete' => true],
            ]];
        }else{
            return['menuItems' => [
                ['routeName' => 'javascript:void(0)',   'params' => [$id], 'label' => 'View Details', 'className' => 'view','data-id' => $id,],
                ['routeName' => 'dm_management.operation_sub_area.status.operation_sub_area_edit',   'params' => [$id,'accept'], 'label' => 'Accept', 'className' => 'accept'],
                ['routeName' => 'dm_management.operation_sub_area.operation_sub_area_edit',   'params' => [$slug], 'label' => 'Update'],
                ['routeName' => 'dm_management.operation_sub_area.operation_sub_area_delete', 'params' => [$id], 'label' => 'Delete', 'delete' => true],
            ]];
        }
    }


}
