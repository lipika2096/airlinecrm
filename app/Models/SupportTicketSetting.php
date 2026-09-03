<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicketSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'auto_close_hours',
        'auto_close_enabled',
        'auto_close_statuses',
    ];

    protected $casts = [
        'auto_close_enabled' => 'boolean',
        'auto_close_hours' => 'integer',
    ];

    /**
     * Get the auto-close statuses as an array
     */
    public function getAutoCloseStatusesArrayAttribute()
    {
        return $this->auto_close_statuses ? explode(',', $this->auto_close_statuses) : [];
    }

    /**
     * Set the auto-close statuses from an array
     */
    public function setAutoCloseStatusesArrayAttribute($value)
    {
        $this->auto_close_statuses = is_array($value) ? implode(',', $value) : $value;
    }

    /**
     * Get the current settings (singleton pattern)
     */
    public static function getSettings()
    {
        return self::firstOrCreate(
            ['id' => 1],
            [
                'auto_close_hours' => 24,
                'auto_close_enabled' => false,
                'auto_close_statuses' => 'resolved',
            ]
        );
    }
}
