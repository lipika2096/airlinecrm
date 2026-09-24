<?php

namespace App\Traits;

use App\Helpers\TimezoneHelper;
use Carbon\Carbon;

trait HasTimezoneConversion
{
    /**
     * Get a date attribute converted to user timezone
     *
     * @param string $attribute
     * @param string $format
     * @return string|null
     */
    protected function getDateInUserTimezone($attribute, $format = 'Y-m-d H:i:s')
    {
        if (!$this->{$attribute}) {
            return null;
        }

        return TimezoneHelper::formatInUserTimezone($this->{$attribute}, $format);
    }

    /**
     * Get created_at in user timezone
     *
     * @param string $format
     * @return string|null
     */
    public function getCreatedAtInUserTimezone($format = 'Y-m-d H:i:s')
    {
        return $this->getDateInUserTimezone('created_at', $format);
    }

    /**
     * Get updated_at in user timezone
     *
     * @param string $format
     * @return string|null
     */
    public function getUpdatedAtInUserTimezone($format = 'Y-m-d H:i:s')
    {
        return $this->getDateInUserTimezone('updated_at', $format);
    }

    /**
     * Get deleted_at in user timezone
     *
     * @param string $format
     * @return string|null
     */
    public function getDeletedAtInUserTimezone($format = 'Y-m-d H:i:s')
    {
        return $this->getDateInUserTimezone('deleted_at', $format);
    }

    /**
     * Scope to format dates in user timezone when accessing as array
     */
    public function scopeWithUserTimezone($query)
    {
        return $query->get()->map(function ($item) {
            $item->formatted_dates = [
                'created_at' => $item->getCreatedAtInUserTimezone(),
                'updated_at' => $item->getUpdatedAtInUserTimezone(),
            ];
            return $item;
        });
    }
}
