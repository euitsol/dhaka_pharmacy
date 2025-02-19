<?php

namespace App\Services;

use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

class AnalyticsService
{
    public function getPageViews(int $days=7)
    {
        $analytics = Analytics::fetchMostVisitedPages(Period::days($days), 5);

        return $analytics->map(function ($row) {
            return [
                'pageTitle' => $row['pageTitle'],
                'screenPageViews' => $row['screenPageViews'],
                'activeUsers' => $row['activeUsers'] ?? 0,
                'percentageViews' => 0, // Will be calculated in controller
            ];
        });
    }
}
