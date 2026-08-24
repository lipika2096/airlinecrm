<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicketComment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    protected $casts = [
        'attachments' => 'array',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function supportTicket()
    {
        return $this->belongsTo(SupportTicket::class, 'support_ticket_id');
    }

    public function user()
    {
        // Handle both Admin and User relationships
        if ($this->user_id && \App\Models\Admin::find($this->user_id)) {
            return $this->belongsTo(Admin::class, 'user_id');
        } else {
            return $this->belongsTo(User::class, 'user_id');
        }
    }
}
