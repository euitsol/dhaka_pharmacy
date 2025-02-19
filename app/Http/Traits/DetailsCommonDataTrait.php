<?php

namespace App\Http\Traits;

trait DetailsCommonDataTrait
{
    private function morphColumnData($data)
    {
        $data->loadMissing(['creater', 'updater']);
        $data->creating_time = timeFormate($data->created_at);
        $data->updating_time = $data->created_at != $data->updated_at ? timeFormate($data->updated_at) : 'null';
        $data->created_by = c_user_name($data->creater);
        $data->updated_by = u_user_name($data->updater);
    }

    private function simpleColumnData($data): void
    {
        // Ensure relationships are loaded
        $data->loadMissing(['created_user', 'updated_user']);

        // Time formatting with fallbacks
        $data->creating_time = $data->created_at
            ? timeFormate($data->created_at)
            : 'N/A';

        $data->updating_time = ($data->created_at && $data->updated_at &&
            $data->created_at->ne($data->updated_at))
            ? timeFormate($data->updated_at)
            : 'Not updated yet';

        // User name formatting with fallbacks
        $data->created_by = $data->created_user
            ? c_user_name($data->created_user)
            : 'System Generated';

        $data->updated_by = $data->updated_user
            ? u_user_name($data->updated_user)
            : 'N/A';
    }
}
