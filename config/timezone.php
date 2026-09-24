<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Timezone Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for timezone handling
    | across the entire application.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | System Default Timezone
    |--------------------------------------------------------------------------
    |
    | The default timezone used when no user-specific timezone is set.
    | This should match the timezone in config/app.php
    |
    */
    'system_timezone' => env('SYSTEM_TIMEZONE', 'Asia/Kolkata'),

    /*
    |--------------------------------------------------------------------------
    | Auto-Convert Timezone
    |--------------------------------------------------------------------------
    |
    | When enabled, all datetime displays will be automatically converted
    | to the user's timezone without requiring manual conversion.
    |
    */
    'auto_convert' => env('TIMEZONE_AUTO_CONVERT', true),

    /*
    |--------------------------------------------------------------------------
    | Database Storage Timezone
    |--------------------------------------------------------------------------
    |
    | The timezone used for storing datetimes in the database.
    | Recommended: UTC for consistency, or system timezone for simplicity.
    |
    */
    'database_timezone' => env('DB_TIMEZONE', 'Asia/Kolkata'),

    /*
    |--------------------------------------------------------------------------
    | Timezone Display Format
    |--------------------------------------------------------------------------
    |
    | Default format for displaying dates and times in user timezone.
    |
    */
    'default_format' => env('TIMEZONE_DEFAULT_FORMAT', 'Y-m-d H:i:s'),

    /*
    |--------------------------------------------------------------------------
    | Available Timezones
    |--------------------------------------------------------------------------
    |
    | List of available timezones for user selection.
    | This can be customized to show only relevant timezones.
    |
    */
    'available_timezones' => [
        'UTC' => 'UTC',
        'America/New_York' => 'America/New_York (EST/EDT)',
        'America/Chicago' => 'America/Chicago (CST/CDT)',
        'America/Denver' => 'America/Denver (MST/MDT)',
        'America/Los_Angeles' => 'America/Los_Angeles (PST/PDT)',
        'Europe/London' => 'Europe/London (GMT/BST)',
        'Europe/Paris' => 'Europe/Paris (CET/CEST)',
        'Europe/Berlin' => 'Europe/Berlin (CET/CEST)',
        'Europe/Moscow' => 'Europe/Moscow (MSK)',
        'Asia/Kolkata' => 'Asia/Kolkata (IST)',
        'Asia/Tokyo' => 'Asia/Tokyo (JST)',
        'Asia/Shanghai' => 'Asia/Shanghai (CST)',
        'Asia/Singapore' => 'Asia/Singapore (SGT)',
        'Asia/Dubai' => 'Asia/Dubai (GST)',
        'Australia/Sydney' => 'Australia/Sydney (AEST/AEDT)',
        'Pacific/Auckland' => 'Pacific/Auckland (NZST/NZDT)',
    ],
];
