<?php

namespace App\Services;

use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

class AnalyticsService
{
    public function getPageViews()
    {
        return Analytics::fetchVisitorsAndPageViews(Period::days(7));
    }
}
