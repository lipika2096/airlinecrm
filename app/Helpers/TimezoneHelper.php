<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TimezoneHelper
{
    /**
     * Get the current user's timezone
     *
     * @return string
     */
    public static function getUserTimezone(): string
    {
        $user = Auth::user();
        
        if ($user && isset($user->timezone) && !empty($user->timezone)) {
            return $user->timezone;
        }

        // Check for admin user
        $admin = Auth::guard('admin')->user();
        if ($admin && isset($admin->timezone) && !empty($admin->timezone)) {
            return $admin->timezone;
        }

        // Check for employee user
        $employee = Auth::guard('employee')->user();
        if ($employee && isset($employee->timezone) && !empty($employee->timezone)) {
            return $employee->timezone;
        }

        // Default to UTC if no user is logged in or timezone is not set
        return 'UTC';
    }

    /**
     * Convert UTC datetime to user's timezone
     *
     * @param string|Carbon $datetime
     * @param string|null $timezone
     * @return Carbon
     */
    public static function convertToUserTimezone($datetime, ?string $timezone = null): Carbon
    {
        $timezone = $timezone ?? self::getUserTimezone();
        
        if (is_string($datetime)) {
            $datetime = Carbon::parse($datetime, 'UTC');
        }

        return $datetime->setTimezone($timezone);
    }

    /**
     * Convert user's timezone datetime to UTC
     *
     * @param string|Carbon $datetime
     * @param string|null $timezone
     * @return Carbon
     */
    public static function convertToUtc($datetime, ?string $timezone = null): Carbon
    {
        $timezone = $timezone ?? self::getUserTimezone();
        
        if (is_string($datetime)) {
            $datetime = Carbon::parse($datetime, $timezone);
        }

        return $datetime->setTimezone('UTC');
    }

    /**
     * Get current time in user's timezone
     *
     * @param string|null $timezone
     * @return Carbon
     */
    public static function nowInUserTimezone(?string $timezone = null): Carbon
    {
        $timezone = $timezone ?? self::getUserTimezone();
        return Carbon::now($timezone);
    }

    /**
     * Get current time in UTC
     *
     * @return Carbon
     */
    public static function nowInUtc(): Carbon
    {
        return Carbon::now('UTC');
    }

    /**
     * Format datetime in user's timezone
     *
     * @param string|Carbon $datetime
     * @param string $format
     * @param string|null $timezone
     * @return string
     */
    public static function formatInUserTimezone($datetime, string $format = 'Y-m-d H:i:s', ?string $timezone = null): string
    {
        return self::convertToUserTimezone($datetime, $timezone)->format($format);
    }

    /**
     * Format datetime in UTC
     *
     * @param string|Carbon $datetime
     * @param string $format
     * @return string
     */
    public static function formatInUtc($datetime, string $format = 'Y-m-d H:i:s'): string
    {
        if (is_string($datetime)) {
            $datetime = Carbon::parse($datetime, 'UTC');
        }

        return $datetime->format($format);
    }

    /**
     * Set application timezone dynamically based on logged-in user
     *
     * @return void
     */
    public static function setAppTimezone(): void
    {
        $timezone = self::getUserTimezone();
        date_default_timezone_set($timezone);
        config(['app.timezone' => $timezone]);
    }

    /**
     * Get list of available timezones
     *
     * @return array
     */
    public static function getAvailableTimezones(): array
    {
        return [
            'UTC' => 'UTC',
            // North American Timezones (with DST)
            'America/New_York' => 'America/New_York (EST/EDT)',
            'America/Chicago' => 'America/Chicago (CST/CDT)',
            'America/Denver' => 'America/Denver (MST/MDT)',
            'America/Los_Angeles' => 'America/Los_Angeles (PST/PDT)',
            'America/Toronto' => 'America/Toronto (EST/EDT)',
            'America/Vancouver' => 'America/Vancouver (PST/PDT)',
            'America/Mexico_City' => 'America/Mexico_City (CST/CDT)',
            // Western European Timezones (with DST)
            'Europe/London' => 'Europe/London (GMT/BST)',
            'Europe/Dublin' => 'Europe/Dublin (GMT/IST)',
            'Europe/Lisbon' => 'Europe/Lisbon (WET/WEST)',
            'Europe/Paris' => 'Europe/Paris (CET/CEST)',
            'Europe/Berlin' => 'Europe/Berlin (CET/CEST)',
            'Europe/Rome' => 'Europe/Rome (CET/CEST)',
            'Europe/Madrid' => 'Europe/Madrid (CET/CEST)',
            'Europe/Amsterdam' => 'Europe/Amsterdam (CET/CEST)',
            'Europe/Brussels' => 'Europe/Brussels (CET/CEST)',
            'Europe/Vienna' => 'Europe/Vienna (CET/CEST)',
            'Europe/Zurich' => 'Europe/Zurich (CET/CEST)',
            'Europe/Prague' => 'Europe/Prague (CET/CEST)',
            'Europe/Warsaw' => 'Europe/Warsaw (CET/CEST)',
            'Europe/Budapest' => 'Europe/Budapest (CET/CEST)',
            'Europe/Belgrade' => 'Europe/Belgrade (CET/CEST)',
            'Europe/Zagreb' => 'Europe/Zagreb (CET/CEST)',
            'Europe/Ljubljana' => 'Europe/Ljubljana (CET/CEST)',
            'Europe/Bratislava' => 'Europe/Bratislava (CET/CEST)',
            'Europe/Oslo' => 'Europe/Oslo (CET/CEST)',
            'Europe/Copenhagen' => 'Europe/Copenhagen (CET/CEST)',
            'Europe/Stockholm' => 'Europe/Stockholm (CET/CEST)',
            'Europe/Helsinki' => 'Europe/Helsinki (EET/EEST)',
            'Europe/Tallinn' => 'Europe/Tallinn (EET/EEST)',
            'Europe/Riga' => 'Europe/Riga (EET/EEST)',
            'Europe/Vilnius' => 'Europe/Vilnius (EET/EEST)',
            // Eastern European Timezones (with DST)
            'Europe/Sofia' => 'Europe/Sofia (EET/EEST)',
            'Europe/Athens' => 'Europe/Athens (EET/EEST)',
            'Europe/Bucharest' => 'Europe/Bucharest (EET/EEST)',
            'Europe/Kiev' => 'Europe/Kiev (EET/EEST)',
            'Europe/Chisinau' => 'Europe/Chisinau (EET/EEST)',
            'Europe/Kaliningrad' => 'Europe/Kaliningrad (EET)',
            'Europe/Nicosia' => 'Europe/Nicosia (EET/EEST)',
            'Asia/Jerusalem' => 'Asia/Jerusalem (IST/IDT)',
            'Europe/Malta' => 'Europe/Malta (CET/CEST)',
            'Europe/Luxembourg' => 'Europe/Luxembourg (CET/CEST)',
            'Europe/Monaco' => 'Europe/Monaco (CET/CEST)',
            'Europe/San_Marino' => 'Europe/San_Marino (CET/CEST)',
            'Europe/Vatican' => 'Europe/Vatican (CET/CEST)',
            'Europe/Andorra' => 'Europe/Andorra (CET/CEST)',
            'Europe/Gibraltar' => 'Europe/Gibraltar (CET/CEST)',
            'Europe/Isle_of_Man' => 'Europe/Isle_of_Man (GMT/BST)',
            'Europe/Jersey' => 'Europe/Jersey (GMT/BST)',
            'Europe/Guernsey' => 'Europe/Guernsey (GMT/BST)',
            'Europe/Kirov' => 'Europe/Kirov (MSK)',
            // Non-DST European Timezones
            'Europe/Moscow' => 'Europe/Moscow (MSK)',
            'Europe/Istanbul' => 'Europe/Istanbul (TRT)',
            'Europe/Minsk' => 'Europe/Minsk (MSK)',
            'Europe/Samara' => 'Europe/Samara (MSK)',
            'Europe/Saratov' => 'Europe/Saratov (MSK)',
            'Europe/Ulyanovsk' => 'Europe/Ulyanovsk (MSK)',
            'Europe/Astrakhan' => 'Europe/Astrakhan (MSK)',
            // Asian Timezones
            'Asia/Kolkata' => 'Asia/Kolkata (IST)',
            'Asia/Tokyo' => 'Asia/Tokyo (JST)',
            'Asia/Shanghai' => 'Asia/Shanghai (CST)',
            'Asia/Singapore' => 'Asia/Singapore (SGT)',
            'Asia/Dubai' => 'Asia/Dubai (GST)',
            'Asia/Hong_Kong' => 'Asia/Hong_Kong (HKT)',
            'Asia/Seoul' => 'Asia/Seoul (KST)',
            'Asia/Bangkok' => 'Asia/Bangkok (ICT)',
            'Asia/Jakarta' => 'Asia/Jakarta (WIB)',
            'Asia/Manila' => 'Asia/Manila (PST)',
            'Asia/Kuala_Lumpur' => 'Asia/Kuala_Lumpur (MYT)',
            // Australian Timezones (with DST)
            'Australia/Sydney' => 'Australia/Sydney (AEST/AEDT)',
            'Australia/Melbourne' => 'Australia/Melbourne (AEST/AEDT)',
            'Australia/Brisbane' => 'Australia/Brisbane (AEST)',
            'Australia/Perth' => 'Australia/Perth (AWST)',
            'Australia/Adelaide' => 'Australia/Adelaide (ACST/ACDT)',
            'Australia/Hobart' => 'Australia/Hobart (AEST/AEDT)',
            'Australia/Darwin' => 'Australia/Darwin (ACST)',
            // Pacific Timezones (with DST)
            'Pacific/Auckland' => 'Pacific/Auckland (NZST/NZDT)',
            'Pacific/Chatham' => 'Pacific/Chatham (CHAST/CHADT)',
            'Pacific/Fiji' => 'Pacific/Fiji (FJT)',
            'Pacific/Guam' => 'Pacific/Guam (ChST)',
            'Pacific/Honolulu' => 'Pacific/Honolulu (HST)',
        ];
    }
}