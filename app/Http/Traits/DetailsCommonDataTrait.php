<?php

namespace App\Http\Traits;

trait DetailsCommonDataTrait
{
    private function morphColumnData($data)
    {
        $data->creating_time = timeFormate($data->created_at);
        $data->updating_time = $data->created_at != $data->updated_at ? timeFormate($data->updated_at) : '--';
        $data->created_by = c_user_name($data->creater);
        $data->updated_by = u_user_name($data->updater);
    }
    private function simpleColumnData($data)
    {
        $data->creating_time = timeFormate($data->created_at);
        $data->updating_time = $data->created_at != $data->updated_at ? timeFormate($data->updated_at) : '--';
        $data->created_by = c_user_name($data->created_user);
        $data->updated_by = u_user_name($data->updated_user);
    }
}
