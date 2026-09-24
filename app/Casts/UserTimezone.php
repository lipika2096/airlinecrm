<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use App\Helpers\TimezoneHelper;
use Carbon\Carbon;

class UserTimezone implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes)
    {
        if (is_null($value)) {
            return null;
        }

        // Return as Carbon instance in user timezone
        try {
            $carbon = Carbon::parse($value, TimezoneHelper::getSystemTimezone());
            return $carbon->setTimezone(TimezoneHelper::getUserTimezone());
        } catch (\Exception $e) {
            return Carbon::parse($value);
        }
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        // Store in system timezone
        if (is_string($value)) {
            try {
                $carbon = Carbon::parse($value, TimezoneHelper::getUserTimezone());
                return $carbon->setTimezone(TimezoneHelper::getSystemTimezone())->toDateTimeString();
            } catch (\Exception $e) {
                return $value;
            }
        }

        if ($value instanceof Carbon) {
            return $value->setTimezone(TimezoneHelper::getSystemTimezone())->toDateTimeString();
        }

        return $value;
    }
}
