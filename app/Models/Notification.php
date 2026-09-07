<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_type',
        'type',
        'title',
        'message',
        'data',
        'is_read',
        'support_ticket_id',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
    ];

    public function supportTicket()
    {
        return $this->belongsTo(SupportTicket::class, 'support_ticket_id');
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeForUser($query, $userId, $userType)
    {
        return $query->where('user_id', $userId)->where('user_type', $userType);
    }
}
