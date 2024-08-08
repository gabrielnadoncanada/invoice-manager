<?php

if (!function_exists('setting')) {
    function setting($key)
    {
        return app(App\Settings\BusinessSettings::class)->$key;
    }
}

