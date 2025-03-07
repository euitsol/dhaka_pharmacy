<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class LocaleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (session()->has('locale')) {
            App::setLocale(session()->get('locale'));
        }
    }
}
