<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    protected $fillable = [
        'ticket_number',
        'department',
        'subject',
        'description',
        'priority',
        'status',
        'created_by',
        'assigned_to',
        'related_user_id',
        'booking_reference',
        'attachments',
        'rating',
        'rating_comment',
        'resolved_at',
        'closed_at',
        'company_name',
    ];

    protected $casts = [
        'priority' => 'string',
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
        'attachments' => 'array',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'resolved_at',
        'closed_at',
    ];

    public function creator()
    {
        // Handle both Admin and User creators
        // Check if the ID exists in admins table first
        if ($this->created_by && \App\Models\Admin::where('id', $this->created_by)->exists()) {
            return $this->belongsTo(Admin::class, 'created_by');
        } else {
            return $this->belongsTo(User::class, 'created_by');
        }
    }

    public function assignedTo()
    {
        // Handle both Admin and User assignments
        if ($this->assigned_to && \App\Models\Admin::find($this->assigned_to)) {
            return $this->belongsTo(Admin::class, 'assigned_to');
        } else {
            return $this->belongsTo(User::class, 'assigned_to');
        }
    }

    public function relatedUser()
    {
        // Handle both Admin and User related users
        if ($this->related_user_id && \App\Models\Admin::find($this->related_user_id)) {
            return $this->belongsTo(Admin::class, 'related_user_id');
        } else {
            return $this->belongsTo(User::class, 'related_user_id');
        }
    }

    public function comments()
    {
        return $this->hasMany(SupportTicketComment::class, 'support_ticket_id');
    }

    public function internalNotes()
    {
        return $this->hasMany(InternalNote::class);
    }

    public function ticketStatus()
    {
        return $this->belongsTo(TicketStatus::class, 'status', 'slug');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('created_by', $userId)
                    ->orWhere('assigned_to', $userId)
                    ->orWhere('related_user_id', $userId);
    }

    public function scopeOpen($query)
    {
        return $query->whereIn('status', ['open', 'in_progress']);
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }
}
