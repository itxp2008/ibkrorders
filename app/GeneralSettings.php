<?php

namespace App;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $account, $status, $paused, $test;
    
    // public bool $site_active;
    
    public static function group(): string
    {
        return 'general';
    }
}